import './bootstrap';
import { createApp } from 'vue';
import AppComponent from './App.vue';
import router from './router/index';
import i18n, { loadLocaleMessages } from './i18n';

const app = createApp({
    components:{
        AppComponent,

    }
});
app.use(router);
// app.mount('#app');
app.use(i18n);

loadLocaleMessages('en').then(() => {
    app.mount('#app');
}).catch((error) => {
    console.error('Error loading default locale messages:', error);
    app.mount('#app'); // Mount app even if locale messages fail to load
});
