import mutations from "./mutations";
import actions from "./actions";

export default {
  state: {
    token: null,
    user: {},
    uploadedPosts: [],
    baggedPosts: [],
    notification: []
  },
  mutations: mutations,
  actions: actions
};
