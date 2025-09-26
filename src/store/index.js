import { createStore } from 'vuex';
import mutations from './mutations';
import actions from './actions';

import creator from './Creator';
import user from './User';

export default createStore({
  state: {
    rootUrl: 'https://english-learning-social-network-backend.ddev.site',
    apiUrl: 'https://api.english-learning-social-network-backend.ddev.site/v1',
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
