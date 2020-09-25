export default {
  Toggle_popupEditor: function(state) {
    state.popupEditor = !state.popupEditor;
  },
  CHANGE_TAB: function(state, payload) {
    state.currentTab = payload;
  },
  SET_PAGE: function(state, payload) {
    state.currentPage = payload;
  }
};
