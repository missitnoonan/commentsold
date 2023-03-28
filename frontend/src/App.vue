<script setup>
  import { RouterView } from 'vue-router'
  import TopNav from "./components/TopNav.vue";
  import Alerts from "./components/Alerts.vue";
</script>

<style scoped>
  .app_container {
    padding-top: 1rem;
  }
</style>

<template>
  <TopNav />
  <Alerts />
  <div class="container app_container">
    <RouterView />
  </div>
</template>
