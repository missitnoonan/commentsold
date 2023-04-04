<script setup>
  const props = defineProps(['products'])
</script>

<template>
  <div class="table-container">
    <table class="table is-hoverable">
      <thead>
      <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Style</th>
        <th>Brand</th>
        <th>Potential Revenue</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="product in products">
        <td><router-link :to="{ name: 'products_view', params: { id: product.id }}">{{ product.id }}</router-link></td>
        <td>{{ product.product_name }}</td>
        <td>{{ product.style }}</td>
        <td>{{ product.brand }}</td>
        <td>{{ $filters.centsToDollars(product.potential_revenue) }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>