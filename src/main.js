import { createApp, defineAsyncComponent } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import './registerServiceWorker';

import '@/assets/css/tailwind.css';
import '@/assets/css/main.css';
import helperFunc from './helperFunc';

import VueMasonry from 'vue-masonry-css';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import webPush from './webPush.js';
import { installToast } from './plugins/toast';

const app = createApp(App);

app.use(store);
app.use(router);
app.use(VueMasonry);
app.use(VueToast, {
  position: 'top-right',
});

const toast = installToast(app);

if (process.env.NODE_ENV === 'development') {
  store.commit('URL_DEV');
}

if (helperFunc.isLocalStorage()) {
  try {
    const user_token = JSON.parse(
      localStorage.getItem('thatsgood_info_user_token')
    );
    const user = JSON.parse(localStorage.getItem('thatsgood_info_user'));

    const browser_unique =
      localStorage.getItem('thatsgood_info_browser_unique') || false;
    if (user_token && user) {
      user.notification_conn =
        typeof user.notification_conn === 'object'
          ? user.notification_conn
          : JSON.parse(user.notification_conn);
      store.commit('SET_USER', user);
      store.commit('SET_TOKEN', user_token);
      store.dispatch('LoadNotification');
      if (!webPush.checkBrowserRegistered(user.notification_conn, browser_unique)) {
        setTimeout(() => {
          const allowNotification = window.confirm(
            'Trình duyệt này chưa cho phép thông báo. Bạn có muốn kich hoạt không?'
          );
          if (allowNotification) {
            webPush.initSW();
          }
        }, 1000);
      }
    }
    const welcomeEnable = localStorage.getItem('thatsgood_info_welcomeEnable');
    if (!welcomeEnable) {
      toast.info('Chào mừng bạn đã đến Thatsgood.');
      localStorage.setItem('thatsgood_info_welcomeEnable', true);
      store.commit('SET_WELCOME', true);
    }
  } catch (err) {
    console.log(err);
  }
}

app.mixin({
  methods: helperFunc,
});

app.component(
  'ToCreator',
  defineAsyncComponent(() => import('@/components/Navigator/ToCreationBtn.vue'))
);
app.component(
  'MainNavigation',
  defineAsyncComponent(() => import('@/components/MainNavigation.vue'))
);
app.component(
  'SidePanelLeft',
  defineAsyncComponent(() => import('@/components/Navigator/SidePanelLeft.vue'))
);
app.component(
  'SidePanelRight',
  defineAsyncComponent(() => import('@/components/Navigator/SidePanelRight.vue'))
);

app.mount('#app');
