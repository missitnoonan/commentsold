import ApiService from "../providers/ApiService";

class HealthCheck {
    async getHealthCheck() {
        return await ApiService.get('/health-check');
    }
}

export default new HealthCheck();
