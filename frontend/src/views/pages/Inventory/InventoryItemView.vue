<script setup>
  import { useRoute } from "vue-router";
  import {computed, onMounted, ref} from "vue";
  import inventoryProvider from "../../../providers/InventoryProvider";
  import productsProvider from "../../../providers/ProductsProvider";

  const route = useRoute();
  const inventory_item = ref({});
  const is_loading = ref(false);

  onMounted(() => {
    is_loading.value = true;
    inventoryProvider.getInventoryItem(route.params.id)
        .then((response) => {
          inventory_item.value = response
          is_loading.value = false;
        });
  });
</script>

<template>
  <div class="columns is-multiline">
    <div class="column is-12">
      <div class="card">
        <div v-if="!is_loading" class="card-content">
          <p class="title">SKU: {{ inventory_item.sku }}</p>
          <p class="subtitle">
            <router-link :to="{ name: 'products_view', params: { id: inventory_item.product.id }}">
              Product: {{ inventory_item.product.id }} {{ inventory_item.product.product_name }}
            </router-link>
          </p>
          <div class="columns is-multiline">
            <div class="column is-6-desktop">
              <b>ID: </b>{{ inventory_item.id }}<br>
              <b>Quantity: </b>{{ inventory_item.quantity }}<br>
              <b>Quantity: </b>{{ inventory_item.quantity }}<br>
              <b>Color: </b>{{ inventory_item.color }}<br>
              <b>Size: </b>{{ inventory_item.size }}<br>
              <b>Weight: </b>{{ inventory_item.weight }}<br>
            </div>
            <div class="column is-6-desktop">
              <b>Price: </b>{{ inventory_item.price_cents }}<br>
              <b>Sale Price: </b>{{ inventory_item.sale_price_cents }}<br>
              <b>Cost: </b>{{ inventory_item.cost_cents }}<br>
            </div>
            <div class="column is-6-desktop">
              <b>Comment: </b>{{ inventory_item.comment }}
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