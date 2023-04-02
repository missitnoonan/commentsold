<script setup>
  import {computed} from "vue";

  const props = defineProps([
    'limit',
    'sort_direction',
    'sort',
    'model',
    'sortable_fields'
  ]);

  const emit = defineEmits(['limitNavigate', 'sortNavigate', 'sortDirectionNavigate']);

  const sort_model = computed({
    get() {
      return props.sort;
    },
    set(value) {
      emit('sortNavigate', value);
    }
  });

  const limit_model = computed({
    get() {
      return props.limit;
    },
    set(value) {
      emit('limitNavigate', value);
    }
  });

  const sort_direction_model = computed({
    get() {
      return props.sort_direction;
    },
    set(value) {
      emit('sortDirectionNavigate', value);
    }
  });
</script>

<template>
  <div class="columns is-multiline is-vcentered is-mobile">
    <div class="column is-half-mobile">
      <label class="label">{{ props.model }} Per Page</label>
      <div class="control">
        <div class="select">
          <select v-model="limit_model">
            <option>10</option>
            <option>20</option>
            <option>50</option>
            <option>100</option>
          </select>
        </div>
      </div>
    </div>

    <div class="column is-half-mobile">
      <label class="label">Sort Direction</label>
      <div class="control">
        <div class="select">
          <select v-model="sort_direction_model">
            <option value="desc">Descending</option>
            <option value="asc">Ascending</option>
          </select>
        </div>
      </div>
    </div>

    <div class="column is-half-mobile">
      <label class="label">Sort On</label>
      <div class="control">
        <div class="select">
          <select v-model="sort_model">
            <option v-for="(object_value, key) in props.sortable_fields" :value="key">{{ object_value }}</option>
          </select>
        </div>
      </div>
    </div>

    <div class="column is-half-mobile">
<!--      <router-link class="button is-info" :to="{ name: 'dive_log_create' }">Log New Dive</router-link>-->
    </div>
  </div>
</template>