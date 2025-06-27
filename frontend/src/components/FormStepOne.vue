<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">
    <h3 class="form-title">Step 1: Your Details</h3>
    <p class="form-desc">Please provide your contact and company information. This helps us get in touch and understand your needs.</p>
    <div class="form-grid">
      <div>
        <label class="block mb-1 font-medium">Name <span style="color: #ef4444">*</span></label>
        <input v-model="form.name" @blur="touched.name = true" type="text" class="input" :class="{'error': errors.name && touched.name}" placeholder="Your full name" />
        <p v-if="errors.name && touched.name" class="error-message">{{ errors.name }}</p>
      </div>
      <div>
        <label class="block mb-1 font-medium">Email <span style="color: #ef4444">*</span></label>
        <input v-model="form.email" @blur="touched.email = true" type="email" class="input" :class="{'error': errors.email && touched.email}" placeholder="you@email.com" />
        <p v-if="errors.email && touched.email" class="error-message">{{ errors.email }}</p>
      </div>
      <div>
        <label class="block mb-1 font-medium">Company Name <span style="color: #ef4444">*</span></label>
        <input v-model="form.company" @blur="touched.company = true" type="text" class="input" :class="{'error': errors.company && touched.company}" placeholder="Your company" />
        <p v-if="errors.company && touched.company" class="error-message">{{ errors.company }}</p>
      </div>
      <div>
        <label class="block mb-1 font-medium">Website URL <span style="color: #ef4444">*</span></label>
        <input v-model="form.website" @blur="touched.website = true" type="url" class="input" :class="{'error': errors.website && touched.website}" placeholder="https://yourwebsite.com" />
        <p v-if="errors.website && touched.website" class="error-message">{{ errors.website }}</p>
      </div>
    </div>
    <button type="submit" class="btn" style="width: 100%;">Next</button>
  </form>
</template>

<script setup>
import { reactive } from 'vue'
import { useLeadFormStore } from '../stores/leadFormStore'

const store = useLeadFormStore()
const form = reactive({
  name: store.form.name,
  email: store.form.email,
  company: store.form.company,
  website: store.form.website,
})
const errors = reactive({})
const touched = reactive({ name: false, email: false, company: false, website: false })

function validate() {
  errors.name = form.name ? '' : 'Name is required.'
  errors.email = form.email ? (/^\S+@\S+\.\S+$/.test(form.email) ? '' : 'Please enter a valid email address.') : 'Email is required.'
  errors.company = form.company ? '' : 'Company name is required.'
  errors.website = form.website ? (/^(https?:\/\/)?([\w\-]+\.)+[\w\-]+(\/\S*)?$/.test(form.website) ? '' : 'Please enter a valid website URL.') : 'Website URL is required.'
  return !errors.name && !errors.email && !errors.company && !errors.website
}

function handleSubmit() {
  Object.keys(touched).forEach(key => touched[key] = true)
  if (validate()) {
    store.setForm(form)
    store.nextStep()
  }
}
</script>

<style scoped>
.input {
  @apply w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white shadow-sm;
}
.btn {
  @apply py-2 px-6 rounded font-semibold transition;
}
</style> 