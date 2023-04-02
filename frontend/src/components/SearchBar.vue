<script setup>
import { ref } from "vue";

  const emit = defineEmits(['searchNavigate']);

  const search_model = ref('');

  function filter() {
    emit('searchNavigate', search_model.value)
  }
</script>

<template>
  <div class="columns is-mobile">
    <div class="column is-6">
      <div class="field">
        <label class="label">Search (SKU or Product ID)</label>
        <div class="control">
          <input class="input" type="text" placeholder="SKU or Product ID" v-model="search_model">
        </div>
      </div>
    </div>
    <div class="column is-6">
      <div class="button is-info" id="filter_button" @click="filter">Filter</div>
    </div>
  </div>
</template>

<style scoped>
  #filter_button {
    margin-top: 2rem;
  }
</style>