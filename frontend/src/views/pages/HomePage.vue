<script setup>
  import {useUserStore} from "../../stores/user";

  const userStore = useUserStore();
</script>

<template>
  <div class="columns is-mobile is-multiline">
    <div class="column">
      <div class="card">
        <div class="card-content">
          <p class="title">
            HomePage Card
          </p>
          <div class="columns is-multiline">
            <div class="column is-12">
              <div v-if="userStore.is_logged_in">
                <router-link :to="{ name: 'products_list'}">View Products</router-link><br>
                <router-link :to="{ name: 'inventory_list'}">View Inventory</router-link>
              </div>
              <div v-else>
                Please Log In To View Options
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>