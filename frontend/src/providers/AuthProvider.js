import ApiService from "./ApiService";
import {useUserStore} from "../stores/user";

class AuthProvider {
    async login(body) {
        return await ApiService.post('/login', body);
    }

    async logout() {
        return await ApiService.post('/logout', {}, true);
    }

    async register(body) {
        // TODO
    }

    async refreshToken() {
        return await ApiService.post('/refresh', {}, true)
    }

    async getUser() {
        return await ApiService.get('/user', true);
    }

    checkCachedToken() {
        const access_token = window.localStorage.getItem('cs_access_token');
        const expires_at = window.localStorage.getItem('cs_expires_at');
        if (!access_token || !expires_at) {
            return false;
        }

        const time = new Date().getTime();
        if (time < expires_at) {
            useUserStore().$patch({
                access_token: access_token,
                expires_at: parseInt(expires_at),
                is_logged_in: true,
                has_checked_session: true,
            });

            this.getUser()
                .then((response) => {
                    useUserStore().$patch({
                        user: response.user
                    });
                })

            return true;
        }

        return false;
    }
}

export default new AuthProvider();