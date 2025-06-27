import { defineStore } from 'pinia'

export const useLeadFormStore = defineStore('leadForm', {
  state: () => ({
    step: 1,
    form: {
      name: '',
      email: '',
      company: '',
      website: '',
      websiteType: '',
      platform: '',
    },
  }),
  actions: {
    setForm(payload) {
      this.form = { ...this.form, ...payload }
    },
    resetForm() {
      this.form = { name: '', email: '', company: '', website: '', websiteType: '', platform: '' }
      this.step = 1
    },
    nextStep() {
      if (this.step < 4) this.step++
    },
    prevStep() {
      if (this.step > 1) this.step--
    },
    goToStep(step) {
      this.step = step
    },
  },
}) 