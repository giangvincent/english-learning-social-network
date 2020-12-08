import mutations from "./mutations";
import actions from "./actions";

export default {
  state: {
    currentAction: "create",
    editPostId: null
  },
  mutations: mutations,
  actions: actions
};
