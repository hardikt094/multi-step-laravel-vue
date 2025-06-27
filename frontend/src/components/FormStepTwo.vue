<template>
  <div>
    <h3 class="form-title">Step 2: Website Details</h3>
    <p class="form-desc">Please select the type of website you have. This helps us tailor our recommendations and support to your specific needs.</p>
    <form @submit.prevent="handleNext" style="margin-bottom: 0;">
      <div style="margin-bottom: 1.5rem;">
        <label class="block font-medium mb-2">Website Type <span style="color: #ef4444">*</span></label>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
          <label v-for="type in websiteTypes" :key="type" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
            <input type="radio" v-model="selectedType" :value="type" @change="touched = true" />
            <span>{{ type }}</span>
          </label>
        </div>
        <p v-if="error && touched" class="error-message">{{ error }}</p>
      </div>
      <button type="submit" class="btn" style="width: 100%;">Next</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useLeadFormStore } from '../stores/leadFormStore'

const store = useLeadFormStore()
const websiteTypes = [
  'ecommerce',
  'blog',
  'corporate',
  'portfolio',
  'other',
]
const selectedType = ref(store.form.websiteType)
const error = ref('')
const touched = ref(false)

function validate() {
  error.value = selectedType.value ? '' : 'Please select a website type.'
  return !error.value
}

function handleNext() {
  touched.value = true
  if (validate()) {
    store.setForm({ websiteType: selectedType.value })
    store.nextStep()
  }
}
</script>

<style scoped>
.btn {
  @apply py-2 px-6 rounded font-semibold transition;
}
</style> 