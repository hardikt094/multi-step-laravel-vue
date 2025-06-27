<template>
  <div>
    <h3 class="form-title">Step 4: Review & Submit</h3>
    <p class="form-desc">Please review your information below. If you need to make changes, use the Back button. When you're ready, click Submit to save your data.</p>
    <div class="review-list">
      <dl style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem 2rem;">
        <div>
          <dt>Name</dt>
          <dd>{{ store.form.name }}</dd>
        </div>
        <div>
          <dt>Email</dt>
          <dd>{{ store.form.email }}</dd>
        </div>
        <div>
          <dt>Company Name</dt>
          <dd>{{ store.form.company }}</dd>
        </div>
        <div>
          <dt>Website URL</dt>
          <dd>{{ store.form.website }}</dd>
        </div>
        <div>
          <dt>Website Type</dt>
          <dd>{{ store.form.websiteType }}</dd>
        </div>
        <div>
          <dt>Platform</dt>
          <dd>{{ store.form.platform }}</dd>
        </div>
      </dl>
    </div>
    <form @submit.prevent="handleSubmit">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <button type="button" @click="store.prevStep" class="btn secondary">Back</button>
        <div style="flex: 1;"></div>
        <button type="submit" class="btn success" :disabled="loading">{{ loading ? 'Submitting...' : 'Submit' }}</button>
      </div>
      <p v-if="error && attempted" class="error-message" style="text-align: center; margin-top: 1rem;">{{ error }}</p>
    </form>
    <div v-if="submitted" style="margin-top: 1.5rem; padding: 1rem; background: #dcfce7; color: #166534; border-radius: 8px;">
      Thank you! Your information has been submitted.
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useLeadFormStore } from '../stores/leadFormStore'
import axios from 'axios'

const store = useLeadFormStore()
const submitted = ref(false)
const error = ref('')
const attempted = ref(false)
const loading = ref(false)

async function handleSubmit() {
  attempted.value = true
  if (!store.form.name || !store.form.email || !store.form.company || !store.form.website || !store.form.websiteType || !store.form.platform) {
    error.value = 'Please complete all steps and required fields before submitting.'
    return
  }
  error.value = ''
  loading.value = true
  try {
    await axios.post('/leads', {
      name: store.form.name,
      email: store.form.email,
      company_name: store.form.company,
      website_url: store.form.website,
      website_type: store.form.websiteType,
      platform: store.form.platform,
    })
    submitted.value = true
  } catch (e) {
    error.value = e.response?.data?.message || 'Failed to submit. Please try again.'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.btn {
  @apply py-2 px-6 rounded font-semibold transition;
}
</style> 