import './index.css'

import { createPinia } from 'pinia'
import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios'

axios.defaults.baseURL = 'https://multi-step-laravel-vue.onrender.com/api'

const app = createApp(App)
app.use(createPinia())
app.config.globalProperties.$axios = axios
app.mount('#app')
