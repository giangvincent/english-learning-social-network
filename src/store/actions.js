export default {
  LOAD_TAGS: function({ state, commit }) {
    fetch("/content/tags.json")
      .then(res => res.json())
      .then(res => {
        console.log(res);
        commit("SET_TAGS", res);
      })
      .catch(err => console.log(err));
  },
  LOAD_CATEGORIES: function({ state, commit }) {
    fetch("/content/categories.json")
      .then(res => res.json())
      .then(res => {
        console.log(res);
        commit("SET_CATEGORIES", res);
      })
      .catch(err => console.log(err));
  },
  LOAD_HOME: function({ state, commit }) {
    fetch(state.apiUrl + "/feed-home")
      .then(res => res.json())
      .then(res => {
        console.log(res.data);
        commit("SET_CURRENTFEED", res.data);
      })
      .catch(err => console.log(err));
  },
  LOAD_FEED_CAT: function({ state, commit }, cat) {
    fetch(state.apiUrl + "/feed-category/" + cat)
      .then(res => res.json())
      .then(res => {
        console.log(res.data);
        commit("SET_CURRENTFEED", res.data);
      })
      .catch(err => console.log(err));
  },
  LOAD_FEED_TAG: function({ state, commit }, tag) {
    fetch(state.apiUrl + "/feed-tag/" + tag)
      .then(res => res.json())
      .then(res => {
        console.log(res.data);
        commit("SET_CURRENTFEED", res.data);
      })
      .catch(err => console.log(err));
  }
};
