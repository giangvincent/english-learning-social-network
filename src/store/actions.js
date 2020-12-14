export default {
  LOAD_TAGS: function({ state, commit }) {
    fetch(state.rootUrl + "get-json/tags")
      .then(res => res.json())
      .then(res => {
        console.log(res);
        commit("SET_TAGS", res);
      })
      .catch(err => console.log(err));
  },
  LOAD_CATEGORIES: function({ state, commit }) {
    fetch(state.rootUrl + "get-json/categories")
      .then(res => res.json())
      .then(res => {
        console.log(res);
        commit("SET_CATEGORIES", res);
      })
      .catch(err => console.log(err));
  },
  LOAD_HOME: function({ state, commit }) {
    return new Promise((response, reject) => {
      fetch(state.apiUrl + "/feed-home?page=" + state.currentPage)
        .then(res => res.json())
        .then(res => {
          response(res);
        })
        .catch(err => reject(err));
    });
  },
  LOAD_FEED_CAT: function({ state, commit }, cat) {
    return new Promise((response, reject) => {
      fetch(
        state.apiUrl + "/feed-category/" + cat + "?page=" + state.currentPage
      )
        .then(res => res.json())
        .then(res => {
          response(res);
        })
        .catch(err => reject(err));
    });
  },
  LOAD_FEED_TAG: function({ state, commit }, tag) {
    return new Promise((response, reject) => {
      fetch(state.apiUrl + "/feed-tag/" + tag + "?page=" + state.currentPage)
        .then(res => res.json())
        .then(res => {
          response(res);
        })
        .catch(err => reject(err));
    });
  }
};
