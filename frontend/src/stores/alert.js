import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useAlertStore = defineStore('alert', () => {
    const alerts = ref([]);
    const success = 'is-success';
    const warning = 'is-warning';
    const danger = 'is-danger';

    function removeExpiredAlerts() {
        alerts.value = alerts.value.filter((alert) => {
            return alert.time > 0;
        });
    }

    function decrementMessageTimes() {
        alerts.value.map((alert) => {
            alert.time--;

            return alert;
        });
    }

    function removeAlert(key) {
        alerts.value.splice(key, 1);
    }

    function addAlert(message = '', type = success, time = 5) {
        alerts.value.push({
            type: type,
            message: message,
            time: time,
        });
    }

    return { alerts, removeExpiredAlerts, removeAlert, addAlert, decrementMessageTimes, success, warning, danger };
});