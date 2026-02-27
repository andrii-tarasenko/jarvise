import { createApp } from 'vue'
import { createVuestic } from 'vuestic-ui'
import 'vuestic-ui/css'
import 'vuestic-ui/styles/essential.css'
import 'vuestic-ui/styles/typography.css'
import './index.css'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router'

// Підготуємо роутер (маршрутизатор)
const routes = [
    { path: '/', component: () => import('./views/Dashboard.vue') }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

const app = createApp(App)

// Використовуємо Vuestic UI та Router
app.use(createVuestic())
app.use(router)

app.mount('#app')
