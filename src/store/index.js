import Vue from "vue";
import Vuex from "vuex";
import mutations from "./mutations";
import actions from "./actions";

import creator from "./Creator";
import user from "./User";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    rootUrl: "https://thatsgood.info",
    apiUrl: "https://api.thatsgood.info",
    popupEditor: false,
    currentTab: "home",
    currentPage: 1,
    currentFeed: [],
    tags: [],
    categories: [],
    posts: [],
    showPanelRight: false,
    showPanelLeft: false,
    welcomeEnable: false
  },
  mutations: mutations,
  actions: actions,
  modules: {
    creator,
    user
  }
});
