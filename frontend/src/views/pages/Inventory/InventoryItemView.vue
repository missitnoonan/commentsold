<script setup>
  import { useRoute } from "vue-router";
  import {computed, onMounted, ref} from "vue";
  import inventoryProvider from "../../../providers/InventoryProvider";

  const route = useRoute();
  const inventory_item = ref({});
</script>

<template>

</template>