export default {
  SET_current_action: function(state, payload) {
    state.currentAction = payload;
  },
  SET_edit_post_id: function(state, payload) {
    state.editPostId = payload;
  }
};
