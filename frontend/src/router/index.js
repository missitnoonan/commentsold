import { createRouter, createWebHistory } from 'vue-router'
import HomePage from "../views/pages/HomePage.vue";
import { useUserStore } from "../stores/user";
import AuthProvider from "../providers/AuthProvider";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'home', component: HomePage },
    { path: '/test', name: 'test_page', component: () => import('../views/pages/TestPage.vue') },
    { path: '/test-parameter/:id', name: 'test_parameter', component: () => import('../views/pages/TestParameterPage.vue') },
    { path: '/login', name: 'login', component: () => import('../views/pages/LoginView.vue') },
    {
      path: '/products',
      name: 'products_list',
      component: () => import('../views/pages/Products/ProductList.vue'),
      beforeEnter: (to, from) => {
        if (!useUserStore().is_logged_in && !AuthProvider.checkCachedToken()) {
          return false;
        }
      },
    },
    {
      path: '/products/:id',
      name: 'products_view',
      component: () => import('../views/pages/Products/ProductView.vue'),
      beforeEnter: (to, from) => {
        if (!useUserStore().is_logged_in && !AuthProvider.checkCachedToken()) {
          return false;
        }
      },
    },
    {
      path: '/inventory/:id',
      name: 'inventory_item_view',
      component: () => import('../views/pages/Inventory/InventoryItemView.vue'),
      beforeEnter: (to, from) => {
        if (!useUserStore().is_logged_in && !AuthProvider.checkCachedToken()) {
          return false;
        }
      },
    },
  ]
})

export default router
