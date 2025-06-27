<template>
  <div>
    <h3 class="form-title">Step 3: Platform Selection</h3>
    <p class="form-desc">Select the platform your website is built on. This helps us provide the most relevant guidance and support for your setup.</p>
    <form @submit.prevent="handleNext" style="margin-bottom: 0;">
      <div style="margin-bottom: 1.5rem;">
        <label class="block font-medium mb-2">Platform <span style="color: #ef4444">*</span></label>
        <div v-if="loading" style="margin-bottom: 1rem; color: #2563eb;">Loading platform options...</div>
        <div v-else style="display: flex; flex-direction: column; gap: 0.5rem;">
          <label v-for="platform in platformOptions" :key="platform" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
            <input type="radio" v-model="selectedPlatform" :value="platform" @change="touched = true" />
            <span>{{ platform }}</span>
          </label>
        </div>
        <p v-if="error && touched" class="error-message">{{ error }}</p>
      </div>
      <button type="submit" class="btn" style="width: 100%;">Next</button>
    </form>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { useLeadFormStore } from '../stores/leadFormStore'
import axios from 'axios'

const store = useLeadFormStore()
const selectedPlatform = ref(store.form.platform)
const error = ref('')
const touched = ref(false)
const platformOptions = ref([])
const loading = ref(false)

async function fetchPlatforms(type) {
  console.log('line no 35', type)
  if (!type) return
  loading.value = true
  try {
    const { data } = await axios.get(`/platform-types/${encodeURIComponent(type)}`)
    platformOptions.value = data.platforms || []
  } catch (e) {
    platformOptions.value = []
  } finally {
    loading.value = false
  }
}

watch(() => store.form.websiteType, (type) => {
  selectedPlatform.value = ''
  fetchPlatforms(type)
}, { immediate: true })

onMounted(() => {
  fetchPlatforms(store.form.websiteType)
})

function validate() {
  error.value = selectedPlatform.value ? '' : 'Please select a platform.'
  return !error.value
}

function handleNext() {
  touched.value = true
  if (validate()) {
    store.setForm({ platform: selectedPlatform.value })
    store.nextStep()
  }
}
</script>

<style scoped>
.btn {
  @apply py-2 px-6 rounded font-semibold transition;
}
</style> 