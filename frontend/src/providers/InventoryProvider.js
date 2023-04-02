import ApiService from "./ApiService";

class InventoryProvider {
    async getList(params = {})
    {
        const filtered_query_params = {};

        for (const query_param in params) {
            if (!params[query_param]) {
                continue;
            }

            filtered_query_params[query_param] = params[query_param];
        }

        return await ApiService.get('/inventory?' + new URLSearchParams(filtered_query_params).toString(), true);
    }

    async getInventoryItem(id)
    {
        return await ApiService.get('/inventory/' + id, true)
    }

    async getStats()
    {
        return await ApiService.get('/inventory/stats', true)
    }
}

export default new InventoryProvider();