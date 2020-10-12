import Vue from "vue";
import Vuex from "vuex";
import mutations from "./mutations";
import actions from "./actions";

import creator from "./Creator";
import user from "./User";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    apiUrl: 'http://thatsgood-backend.local/api',
    popupEditor: false,
    currentTab: "home",
    currentPage: ""
  },
  mutations: mutations,
  actions: actions,
  modules: {
    creator,
    user
  }
});
