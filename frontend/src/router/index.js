import { createRouter, createWebHistory } from 'vue-router'
import HomePage from "../views/pages/HomePage.vue";
import { useUserStore } from "../stores/user";
import AuthProvider from "../providers/AuthProvider";
import ProductList from "../views/pages/Products/ProductList.vue";
import LoginView from "../views/pages/LoginView.vue";
import ProductView from "../views/pages/Products/ProductView.vue";
import InventoryList from "../views/pages/Inventory/InventoryList.vue";
import InventoryItemView from "../views/pages/Inventory/InventoryItemView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'home', component: HomePage },
    { path: '/login', name: 'login', component: LoginView },
    {
      path: '/products',
      name: 'products_list',
      component: ProductList,
      beforeEnter: (to, from) => {
        if (!useUserStore().is_logged_in && !AuthProvider.checkCachedToken()) {
          return false;
        }
      },
    },
    {
      path: '/products/:id',
      name: 'products_view',
      component: ProductView,
      beforeEnter: (to, from) => {
        if (!useUserStore().is_logged_in && !AuthProvider.checkCachedToken()) {
          return false;
        }
      },
    },
    {
      path: '/inventory',
      name: 'inventory_list',
      component: InventoryList,
      beforeEnter: (to, from) => {
        if (!useUserStore().is_logged_in && !AuthProvider.checkCachedToken()) {
          return false;
        }
      },
    },
    {
      path: '/inventory/:id',
      name: 'inventory_item_view',
      component: InventoryItemView,
      beforeEnter: (to, from) => {
        if (!useUserStore().is_logged_in && !AuthProvider.checkCachedToken()) {
          return false;
        }
      },
    },
  ]
})

export default router
