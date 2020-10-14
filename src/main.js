import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store/";
import "./registerServiceWorker";

import "@/assets/css/tailwind.css";
import "@/assets/css/main.css";

Vue.config.productionTip = false;
function isLocalStorage() {
  var mod = "modernizr";
  try {
    localStorage.setItem(mod, mod);
    localStorage.removeItem(mod);
    return true;
  } catch (e) {
    return false;
  }
}
if (isLocalStorage()) {
  try {
    let user_token = JSON.parse(localStorage.getItem("user_token"));
    let user = JSON.parse(localStorage.getItem("user"));
    if (user_token && user) {
      console.log(user_token, user);
      store.commit("SET_USER", user);
      store.commit("SET_TOKEN", user_token);
    }
  } catch (err) {
    console.log(err);
  }
}

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
