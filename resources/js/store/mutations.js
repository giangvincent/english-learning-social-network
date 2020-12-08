export default {
  Toggle_popupEditor: function(state) {
    state.popupEditor = !state.popupEditor;
  },
  toggle_left_panel: function(state) {
    state.showPanelLeft = !state.showPanelLeft;
  },
  toggle_right_panel: function(state) {
    state.showPanelRight = !state.showPanelRight;
  },
  CHANGE_TAB: function(state, payload) {
    state.currentTab = payload;
  },
  SET_PAGE: function(state, payload) {
    state.currentPage = payload;
  },
  SET_CURRENTFEED: function(state, payload) {
    state.currentFeed = payload;
  },
  SET_TAGS: function(state, payload) {
    state.tags = payload;
  },
  SET_CATEGORIES: function(state, payload) {
    state.categories = payload;
  }
};
