import './index.css'

import { createPinia } from 'pinia'
import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios'

axios.defaults.baseURL = 'http://127.0.0.1:8000/api'

const app = createApp(App)
app.use(createPinia())
app.config.globalProperties.$axios = axios
app.mount('#app')
