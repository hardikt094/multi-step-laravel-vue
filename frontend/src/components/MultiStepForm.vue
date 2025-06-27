<template>
  <div class="form-wrapper">
    <div class="mb-8">
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
        <h2 class="form-title">Lead Capture Form</h2>
        <span style="color: #6b7280;">Step {{ store.step }} of 4</span>
      </div>
      <div class="progress-bar-bg">
        <div
          class="progress-bar"
          :style="{ width: `${(store.step - 1) * 33.33 + 33.33}%` }"
        ></div>
      </div>
    </div>
    <component :is="currentStepComponent" />
    <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
      <button
        v-if="store.step > 1 && store.step < 4"
        @click="store.prevStep"
        class="btn secondary"
      >
        Back 
      </button>
      <div style="flex: 1;"></div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useLeadFormStore } from '../stores/leadFormStore'
import FormStepOne from './FormStepOne.vue'
import FormStepTwo from './FormStepTwo.vue'
import FormStepThree from './FormStepThree.vue'
import FormStepFour from './FormStepFour.vue'

const store = useLeadFormStore()

const currentStepComponent = computed(() => {
  switch (store.step) {
    case 1:
      return FormStepOne
    case 2:
      return FormStepTwo
    case 3:
      return FormStepThree
    case 4:
      return FormStepFour
    default:
      return FormStepOne
  }
})
</script>

<style scoped>
.btn {
  @apply py-2 px-6 rounded font-semibold transition;
}
</style> 