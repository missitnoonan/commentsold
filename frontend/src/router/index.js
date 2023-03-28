import { createRouter, createWebHistory } from 'vue-router'
import HomePage from "../views/pages/HomePage.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'home', component: HomePage },
    { path: '/test', name: 'test_page', component: () => import('../views/pages/TestPage.vue') },
    { path: '/test-parameter/:id', name: 'test_parameter', component: () => import('../views/pages/TestParameterPage.vue') },
  ]
})

export default router
