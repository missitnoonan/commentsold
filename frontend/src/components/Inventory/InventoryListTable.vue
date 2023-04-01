<script setup>
  const props = defineProps(['inventory_items', 'display_product_name'])
</script>

<template>
  <div class="table-container">
    <table class="table is-hoverable">
      <thead>
      <tr>
        <th>ID</th>
        <th v-if="props.display_product_name">Product Name</th>
        <th>SKU</th>
        <th>Quantity</th>
        <th>Size</th>
        <th>Price</th>
        <th>Cost</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="item in props.inventory_items">
        <td><router-link :to="{ name: 'inventory_item_view', params: { id: item.id }}">{{ item.id }}</router-link></td>
        <td v-if="props.display_product_name">{{ item.product_name }}</td>
        <td>{{ item.sku }}</td>
        <td>{{ item.quantity }}</td>
        <td>{{ item.size }}</td>
        <td>{{ item.price_cents }}</td>
        <td>{{ item.cost_cents }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>