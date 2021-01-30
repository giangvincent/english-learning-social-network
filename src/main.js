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

import webPush from "./webPush.js";
import firebase from "firebase/app";
import "@firebase/messaging";
var firebaseConfig = {
  apiKey: "AIzaSyAfJNI6MBwvOGKkUylFrcQbZu467f6lgKs",
  authDomain: "thatgood.firebaseapp.com",
  projectId: "thatgood",
  storageBucket: "thatgood.appspot.com",
  messagingSenderId: "677986354646",
  appId: "1:677986354646:web:543a144ac2c0407644d077",
  measurementId: "G-WE9SEJKBB1"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();
console.log(messaging);
messaging
  .getToken({
    vapidKey:
      "BIwxpOTrY3jyIW1thOw0UGRtQf17g4QtDZg-0aYF8XICQFk7MgwRK4adZfYLFIjEbmhITYOq56U1AP4ns1Xke6I"
  })
  .then(currentToken => {
    if (currentToken) {
      console.log(currentToken);
    } else {
      // Show permission request UI
      console.log(
        "No registration token available. Request permission to generate one."
      );
      // ...
    }
  })
  .catch(err => {
    console.log("An error occurred while retrieving token. ", err);
    // ...
  });

Vue.config.productionTip = false;
Vue.use(VueMasonry);
Vue.use(VueToast, {
  // One of the options
  position: "top-right"
});
if (process.env.NODE_ENV === "development") {
  store.commit("URL_DEV");
}

if (helperFunc.isLocalStorage()) {
  try {
    let user_token = JSON.parse(
      localStorage.getItem("thatsgood_info_user_token")
    );
    let user = JSON.parse(localStorage.getItem("thatsgood_info_user"));

    let browser_unique =
      localStorage.getItem("thatsgood_info_browser_unique") || false;
    if (user_token && user) {
      // console.log(user_token, user);
      user.notification_conn =
        typeof user.notification_conn === "object"
          ? user.notification_conn
          : JSON.parse(user.notification_conn);
      store.commit("SET_USER", user);
      store.commit("SET_TOKEN", user_token);
      store.dispatch("LoadNotification");
      if (
        !webPush.checkBrowserRegistered(user.notification_conn, browser_unique)
      ) {
        setTimeout(() => {
          var r = window.confirm(
            "Trình duyệt này chưa cho phép thông báo. Bạn có muốn kich hoạt không?"
          );
          if (r) {
            webPush.initSW();
          }
        }, 1000);
      }
    }
    let welcomeEnable = localStorage.getItem("thatsgood_info_welcomeEnable");
    if (!welcomeEnable) {
      Vue.$toast.info("Chào mừng bạn đã đến Thatsgood.");
      localStorage.setItem("thatsgood_info_welcomeEnable", true);
      store.commit("SET_WELCOME", true);
    }
  } catch (err) {
    console.log(err);
  }
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
