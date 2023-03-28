<script setup>
</script>

<template>
  <div class="columns is-mobile is-multiline">
    <div class="column">
      <div class="card">
        <div class="card-content">
          <p class="title">
            HomePage Card
          </p>
          <div class="columns is-multiline">
            <div class="column is-12">
              <router-link :to="{ name: 'test_parameter', params: { id: '1' }}">Test Param 1</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>