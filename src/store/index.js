import { createStore } from 'vuex';
import mutations from './mutations';
import actions from './actions';

import creator from './Creator';
import user from './User';

export default createStore({
  state: {
    rootUrl: 'https://backend.thatsgood.info',
    apiUrl: 'https://backend.thatsgood.info/api',
    popupEditor: false,
    currentTab: 'home',
    currentPage: 1,
    currentFeed: [],
    tags: [],
    categories: [],
    posts: [],
    showPanelRight: false,
    showPanelLeft: false,
    welcomeEnable: false,
  },
  mutations,
  actions,
  modules: {
    creator,
    user,
  },
});
