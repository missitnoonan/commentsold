import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useUserStore = defineStore('user', () => {
    const user = ref({});
    const access_token = ref('');
    const expires_at = ref(new Date().getTime());
    const is_logged_in = ref(false);
    const has_checked_session = ref(false);

    function setExpiresAt(expires_in_minutes) {
        const time = new Date().getTime();
        expires_at.value = time + (expires_in_minutes * 60 * 1000);
    }

    function setToken(access_token_response, expires_in_response) {
        access_token.value = access_token_response;
        window.localStorage.setItem('cs_access_token', access_token_response)

        const time = new Date().getTime();
        const expires_at_time = time + (expires_in_response * 60 * 1000);
        expires_at.value = expires_at_time;

        window.localStorage.setItem('cs_expires_at', expires_at_time.toString());
    }

    function getMillisecondsUntilExpiration() {
        const time = new Date().getTime();

        return expires_at.value - time;
    }

    function reset() {
        user.value = {};
        access_token.value = '';
        expires_at.value = new Date().getTime();
        is_logged_in.value = false;
        has_checked_session.value = false;
    }

    return {
        user,
        access_token,
        expires_at,
        is_logged_in,
        has_checked_session,
        setExpiresAt,
        getMillisecondsUntilExpiration,
        setToken,
        reset,
    };
});