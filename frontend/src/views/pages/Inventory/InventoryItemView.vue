<script setup>
  import { useRoute } from "vue-router";
  import { computed, onMounted, ref} from "vue";
  import inventoryProvider from "../../../providers/InventoryProvider";

  const route = useRoute();
  const inventory_item = ref({});
  const is_loading = ref(false);

  const product_name = computed(() => {
    if (inventory_item.value.hasOwnProperty('product')) {
      return inventory_item.value.product.product_name;
    }

    return '';
  })

  onMounted(() => {
    is_loading.value = true;
    inventoryProvider.getInventoryItem(route.params.id)
        .then((response) => {
          inventory_item.value = response;
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
          <p v-if="product_name" class="subtitle">
            <router-link :to="{ name: 'products_view', params: { id: inventory_item.product.id }}">
              Product: {{ inventory_item.product.id }} {{ product_name }}
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
              <b>Price: </b>{{ $filters.centsToDollars(inventory_item.price_cents) }}<br>
              <b>Sale Price: </b>{{ $filters.centsToDollars(inventory_item.sale_price_cents) }}<br>
              <b>Cost: </b>{{ $filters.centsToDollars(inventory_item.cost_cents) }}<br>
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