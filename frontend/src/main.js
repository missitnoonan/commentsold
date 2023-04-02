import { createApp } from 'vue'
import { createPinia } from 'pinia'
import "bulma/css/bulma.css";

import App from './App.vue'
import router from './router'

import './assets/main.css'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.config.globalProperties.$filters = {
    centsToDollars(value) {
        const formated =  Intl.NumberFormat(
            'en-US',
            { style: 'currency', currency: 'USD', currencyDisplay: 'narrowSymbol'},
        ).format(value / 100)

        return formated;
    }
}

app.mount('#app')
