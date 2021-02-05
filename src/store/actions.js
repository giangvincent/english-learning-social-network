import helperFunc from "../helperFunc";
import Vue from "vue";

export default {
  LOAD_TAGS: function ({ state, commit }) {
    fetch("/content/tags.json")
      .then(res => res.json())
      .then(res => {
        // console.log(res);
        commit("SET_TAGS", res);
      })
      .catch(err => console.log(err));
  },
  LOAD_CATEGORIES: function ({ state, commit }) {
    fetch("/content/categories.json")
      .then(res => res.json())
      .then(res => {
        // console.log(res);
        commit("SET_CATEGORIES", res);
      })
      .catch(err => console.log(err));
  },
  LOAD_HOME: function ({ state, commit }) {
    return new Promise((response, reject) => {
      // fetch(state.apiUrl + "/feed-home?page=" + state.currentPage)
      fetch("/content/feed/home-" + state.currentPage + ".json")
        .then(res => res.json())
        .then(res => {
          response(res);
        })
        .catch(err => reject(err));
    });
  },
  LOAD_SEARCH: function ({ state, commit }, payload) {
    var query = encodeURIComponent(payload);
    return new Promise((response, reject) => {
      fetch(state.apiUrl + "/search/" + query + "?page=" + state.currentPage)
        .then(res => res.json())
        .then(res => {
          response(res);
        })
        .catch(err => reject(err));
    });
  },
  LOAD_FEED_CAT: function ({ state, commit }, cat) {
    return new Promise((response, reject) => {
      /* fetch(
        state.apiUrl + "/feed-category/" + cat + "?page=" + state.currentPage
      ) */
      fetch("/content/feed/category-" + cat + "-" + state.currentPage + ".json")
        .then(res => res.json())
        .then(res => {
          response(res);
        })
        .catch(err => reject(err));
    });
  },
  LOAD_FEED_TAG: function ({ state, commit }, tag) {
    return new Promise((response, reject) => {
      fetch(state.apiUrl + "/feed-tag/" + tag + "?page=" + state.currentPage)
        .then(res => res.json())
        .then(res => {
          response(res);
        })
        .catch(err => reject(err));
    });
  },
  SAVE_WEBPUSH: function ({ state, commit, dispatch }, pushSubscription) {
    pushSubscription = JSON.parse(pushSubscription);
    var data = new FormData();
    data.append("endpoint", pushSubscription.endpoint);
    data.append("keys_auth", pushSubscription.keys.auth);
    data.append("keys_p256dh", pushSubscription.keys.p256dh);
    fetch(state.apiUrl + "/save-webpush", {
      method: "POST",
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + state.user.token
      },
      body: data
    })
      .then(function (res) {
        return res.json();
      })
      .then(function (result) {
        if (result.success && !result.error) {
          let browserUnique = helperFunc.randStr();
          let user = state.user.user;
          user.notification_conn.browser.keysArr.push(browserUnique);
          commit("SET_USER", user);
          dispatch("UpdateNotificationConn", user);
          localStorage.setItem("thatsgood_info_browser_unique", browserUnique);
          localStorage.setItem("thatsgood_info_user", JSON.stringify(user));
          Vue.$toast.success("Kích hoạt thông báo cho trình duyệt thành công.");
        } else {
          console.log(result.error);
        }
      })
      .catch(err => {
        console.log(err);
      });
  }
};
