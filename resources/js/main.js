import { createApp, defineAsyncComponent } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import './registerServiceWorker';
import helperFunc from './helperFunc';
import VueMasonry from 'vue-masonry-css';

import '../css/tailwind.css';
import '../css/main.css';
import '../css/app.css';

if (helperFunc.isLocalStorage()) {
    try {
        const userToken = JSON.parse(localStorage.getItem('user_token'));
        const user = JSON.parse(localStorage.getItem('user'));
        if (userToken && user) {
            store.commit('SET_USER', user);
            store.commit('SET_TOKEN', userToken);
            store.dispatch('LoadNotification');
        }
    } catch (err) {
        console.log(err);
    }
}

const app = createApp(App);

app.mixin({
    methods: helperFunc,
});

app.component('ToCreator', defineAsyncComponent(() => import('./components/Navigator/ToCreationBtn.vue')));
app.component('MainNavigation', defineAsyncComponent(() => import('./components/MainNavigation.vue')));
app.component('SidePanelLeft', defineAsyncComponent(() => import('./components/Navigator/SidePanelLeft.vue')));
app.component('SidePanelRight', defineAsyncComponent(() => import('./components/Navigator/SidePanelRight.vue')));

app.use(store);
app.use(router);
app.use(VueMasonry);

app.mount('#app');
