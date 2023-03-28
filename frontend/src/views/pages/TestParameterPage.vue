<script setup>
import {ref, watch, onMounted, computed} from "vue";
  import { useRoute } from "vue-router";

  const route = useRoute();

  const next = computed(() => {
    let next_int = parseInt(route.params.id) + 1
    return next_int.toString();
  })
</script>

<template>
  <div class="columns is-mobile is-multiline">
    <div class="column">
      <div class="card">
        <div class="card-content">
          <p class="title">
            TestPage Card
          </p>
          <p><router-link :to="{ name: 'test_parameter', params: { id: next }}">Next</router-link></p>
          <p>{{ next }}</p>
        </div>
      </div>
    </div>
  </div>
</template>