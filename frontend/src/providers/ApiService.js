import  { useAlertStore } from "../stores/alert";

class ApiService {
    constructor() {
        this.base_api = import.meta.env.VITE_API_URL;
    }

    async get(uri, with_auth = false) {
        const url = this.base_api + uri;

        let options = {
            method: "GET",
        };

        options = this.#addHeader(options, with_auth);

        try {
            const response =  await fetch(url, options);

            return this.#processApiResponse(response);
        } catch (error) {
            // TODO: Add More Info Around Error
            this.#addErrorAlert();

            return null;
        }
    }

    async post(uri, body, with_auth = false) {
        const url = this.base_api + uri;

        let options = {
            method: "POST",
            body: JSON.stringify(body),
        };

        options = this.#addHeader(options, with_auth);

        try {
            const response =  await fetch(url, options);

            return this.#processApiResponse(response);
        } catch (error) {
            // TODO: Add More Info Around Error
            this.#addErrorAlert();

            return null;
        }
    }

    #addHeader(options, with_auth = false) {
        if (with_auth) {
            // TODO
        } else {
            options.headers = {
                "Content-Type": "application/json",
            };
        }

        return options;
    }

    async #processApiResponse(response) {
        if (!response) {
            return null;
        }

        if (response?.ok) {
            const json = await response.json();

            return json.data;
        } else {
            const json = await response.json();
            let message = 'Something went wrong, please try again. If you continue to see this message, please contact support.'

            if (json.message) {
                message = json.message;
            }

            useAlertStore().addAlert(message, useAlertStore().warning)

            return null;
        }
    }

    #addErrorAlert() {
        useAlertStore().addAlert('Something went wrong, please try again. If you continue to see this message, please contact support.', useAlertStore().danger);
    }
}

export default new ApiService();