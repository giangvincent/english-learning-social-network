export default {
  SET_TOKEN: function (state, payload) {
    state.token = payload;
  },
  SET_USER: function (state, payload) {
    state.user = payload;
  },
  setUploadedPosts: function (state, payload) {
    state.uploadedPosts = payload
  },
  setBaggedPosts: function (state, payload) {
    state.baggedPosts = payload
  }
};
