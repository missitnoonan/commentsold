import ApiService from "./ApiService";

class ProductsProvider {
    async getList(params = {}) {
        const filtered_query_params = {};

        for (const query_param in params) {
            if (!params[query_param]) {
                continue;
            }

            filtered_query_params[query_param] = params[query_param];
        }

        return await ApiService.get('/products?' + new URLSearchParams(filtered_query_params).toString(), true);
    }

    async getProduct(id)
    {
        return await ApiService.get('/products/' + id, true)
    }
}

export default new ProductsProvider();