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

        return ApiService.get('/inventory?' + new URLSearchParams(filtered_query_params).toString(), true);
    }

    async getInventoryItem(id)
    {
        return ApiService.get('/inventory/' + id, true)
    }
}

export default new InventoryProvider();