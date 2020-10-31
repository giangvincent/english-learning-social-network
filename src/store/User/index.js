import mutations from "./mutations";
import actions from "./actions";

export default {
  state: {
    token: null,
    user: {},
    uploadedPosts: [],
    baggedPosts: []
  },
  mutations: mutations,
  actions: actions
};
