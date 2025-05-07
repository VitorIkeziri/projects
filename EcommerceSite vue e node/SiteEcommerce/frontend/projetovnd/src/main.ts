import { createApp } from 'vue'
import App from './App.vue'
import './style.css'

// importa o router
import router from './routes/'

const app = createApp(App)

// usa o router
app.use(router)

app.mount('#app')