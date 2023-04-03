<script setup>
import {computed, ref} from "vue";

  const props = defineProps(['label', 'placeholder', 'search']);
  const emit = defineEmits(['searchNavigate']);

  const search_model = computed({
    get() {
      return props.search;
    },
    set(value) {
      emit('updateSearch', value);
    }
  });

  function filter() {
    emit('searchNavigate', search_model.value)
  }
</script>

<template>
  <div class="columns is-mobile">
    <div class="column is-6">
      <div class="field">
        <label class="label">{{ props.label }}</label>
        <div class="control">
          <input class="input" type="text" :placeholder="props.placeholder" v-model="search_model">
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