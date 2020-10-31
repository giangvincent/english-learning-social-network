export default {
  LOGIN: function ({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("email", payload.email);
    data.append("password", payload.password);
    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/login", {
        method: "POST",
        body: data
      })
        .then(function (res) {
          return res.json();
        })
        .then(function (data) {
          console.log(data);
          if (typeof data.success !== "undefined") {
            let successData = data.success;
            commit("SET_TOKEN", successData.token);
            commit("SET_USER", successData.user);
            res(successData);
          } else {
            rej(data.error);
          }
        })
        .catch(err => {
          rej(err);
        });
    });
  },
  REGISTER: function ({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("nick_name", payload.nick_name);
    data.append("full_name", payload.full_name);
    data.append("email", payload.email);
    data.append("password", payload.password);
    data.append("c_password", payload.c_password);

    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/register", {
        method: "POST",
        body: data
      })
        .then(function (res) {
          return res.json();
        })
        .then(function (data) {
          console.log(data);
          let successData = data;
          commit("SET_TOKEN", successData.token);
          commit("SET_USER", successData.user);
          res(successData);
        })
        .catch(err => {
          rej(err);
        });
    });
  },
  GetUploadedPosts: function ({ rootState, state, commit }, payload) {
    fetch(rootState.apiUrl + "/uploaded-posts", {
      method: "GET",
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + rootState.user.token
      }
    })
      .then(function (res) {
        return res.json();
      })
      .then(function (res) {

        commit("setUploadedPosts", res.data);

      })
      .catch(err => {
        console.log(err)
      });
  },

  GetBaggedPosts: function ({ rootState, state, commit }, payload) {
    fetch(rootState.apiUrl + "/bagged-posts", {
      method: "GET",
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + rootState.user.token
      }
    })
      .then(function (res) {
        return res.json();
      })
      .then(function (res) {
        commit("setBaggedPosts", res.data);
      })
      .catch(err => {
        console.log(err);
      });
  },
};
