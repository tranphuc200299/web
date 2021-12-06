import './plugins/plugins'

import {createApp} from 'vue'

import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'

import {createI18n} from 'vue-i18n'
import ja from './lang/ja.json';
import en from './lang/en.json';
import Const from './const/appConst';

const messages = {
    ja: ja,
    en: en,
};
const _httpRequest = axios.create({
    baseURL: process.env.VUE_APP_API_URL,
    timeout: 1000 * 12
});

window.locale = 'en';
const i18n = createI18n({
    locale: window.locale,
    messages,
    fallbackLocale: window.locale
});

router.beforeEach((to, from, next) => {
    let language = to.params.lang;

    if (!language) {
        language = 'en';
    }

    if (Object.keys(messages).indexOf(language) !== -1) {
        i18n.global.locale = language;
    } else {
        // app.$router.push({
        //     name: 'NotFound',
        //     params: {pathMatch: router.path.substring(1).split('/')},
        //     query: router.query,
        //     hash: router.hash,
        // })
    }

    next();
});

const app = createApp(App);

app.use(store);
app.use(router);
app.use(i18n);
app.config.globalProperties._httpRequest = _httpRequest;
app.config.globalProperties._const = Const;

app.mount('#app');

