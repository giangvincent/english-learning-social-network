import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store/";
import "./registerServiceWorker";

import "@/assets/css/tailwind.css";
import "@/assets/css/main.css";
import helperFunc from "./helperFunc";

import VueMasonry from "vue-masonry-css";
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

Vue.config.productionTip = false;
Vue.use(VueMasonry);
Vue.use(VueToast, {
  // One of the options
  position: "top-right"
});

if (helperFunc.isLocalStorage()) {
  try {
    let user_token = JSON.parse(localStorage.getItem("user_token"));
    let user = JSON.parse(localStorage.getItem("user"));
    if (user_token && user) {
      // console.log(user_token, user);
      store.commit("SET_USER", user);
      store.commit("SET_TOKEN", user_token);
      store.dispatch("LoadNotification");
    }
    let welcomeEnable = localStorage.getItem("welcomeEnable");
    if (!welcomeEnable) {
      Vue.$toast.info("Chào mừng bạn đã đến Thatsgood.");
      localStorage.setItem("welcomeEnable", true);
      store.commit("SET_WELCOME", true);
    }
  } catch (err) {
    console.log(err);
  }
}

if (process.env.NODE_ENV === "development") {
  store.commit("URL_DEV");
}

Vue.mixin({
  methods: helperFunc
});

Vue.component("ToCreator", () =>
  import("@/components/Navigator/ToCreationBtn.vue")
);
Vue.component("MainNavigation", () =>
  import("@/components/MainNavigation.vue")
);
Vue.component("SidePanelLeft", () =>
  import("@/components/Navigator/SidePanelLeft.vue")
);
Vue.component("SidePanelRight", () =>
  import("@/components/Navigator/SidePanelRight.vue")
);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
