<script setup>
  import { useAlertStore } from "../stores/alert";
  import { onMounted } from "vue";

  onMounted(() => {
    setInterval(() => {
      if (useAlertStore().alerts.length > 0) {
        useAlertStore().decrementMessageTimes();
        useAlertStore().removeExpiredAlerts();
      }
    }, 1000);
  });
</script>

<template>
  <TransitionGroup>
    <div
        v-for="(alert, key) in useAlertStore().alerts"
        :key="'alert' + key"
        :class="alert.type"
        class="notification"
        data-test="notification"
    >
      <button class="delete" @click="useAlertStore().removeAlert(key)" data-test="notification-dismiss"></button>
      {{ alert.message }}
    </div>
  </TransitionGroup>
</template>