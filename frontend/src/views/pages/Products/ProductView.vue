<script setup>
  import { useRoute } from "vue-router";
  import {computed, onMounted, ref} from "vue";
  import productsProvider from "../../../providers/ProductsProvider";
  import InventoryListTable from "../../../components/Inventory/InventoryListTable.vue";

  const route = useRoute();
  const product = ref({});
  const is_loading = ref(false);

  const show_inventory = computed(() => {
    if (product.value.hasOwnProperty('inventories')) {
      return product.value.inventories.length > 0;
    } else {
      return false;
    }
  })

  onMounted(() => {
    is_loading.value = true;
    productsProvider.getProduct(route.params.id)
        .then((response) => {
          product.value = response
          is_loading.value = false;
        });
  });
</script>

<template>
  <div class="columns is-multiline">
    <div class="column is-12">
      <div class="card">
        <div v-if="!is_loading" class="card-content">
          <p class="title">{{ product.product_name }}</p>
          <div class="columns">
            <div class="column is-6-desktop">
              <b>ID: </b>{{ product.id }}<br>
              <b>Brand: </b>{{ product.brand }}<br>
              <b>Product Type: </b>{{ product.product_type }}
            </div>
            <div class="column is-6-desktop">
              <b>Description: </b> {{ product.description }}
            </div>
          </div>
          <div v-if="show_inventory" class="columns">
            <div class="column is-12">
              <p class="subtitle">SKUs</p>
              <InventoryListTable :display_product_name="false" :inventory_items="product.inventories" />
            </div>
          </div>
        </div>
        <div v-else class="card-content">
          <progress class="progress is-large is-info" max="100">60</progress>
        </div>
      </div>
    </div>
  </div>
</template>