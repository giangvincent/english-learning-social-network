export default {
  LOGIN: function({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("email", payload.email);
    data.append("password", payload.password);
    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/login", {
        method: "POST",
        body: data
      })
        .then(function(res) {
          return res.json();
        })
        .then(function(data) {
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
  REGISTER: function({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("nick_name", payload.nick_name);
    data.append("full_name", payload.full_name);
    data.append("birthday", payload.birthday);
    data.append("email", payload.email);
    data.append("password", payload.password);
    data.append("c_password", payload.c_password);

    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/register", {
        method: "POST",
        body: data
      })
        .then(function(res) {
          return res.json();
        })
        .then(function(data) {
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
  GetUploadedPosts: function({ rootState, state, commit }, payload) {
    return new Promise((response, reject) => {
      fetch(
        rootState.apiUrl + "/uploaded-posts?page=" + rootState.currentPage,
        {
          method: "GET",
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + rootState.user.token
          }
        }
      )
        .then(function(res) {
          return res.json();
        })
        .then(function(res) {
          response(res);
        })
        .catch(err => {
          reject(err);
        });
    });
  },

  GetBaggedPosts: function({ rootState, state, commit }, payload) {
    return new Promise((response, reject) => {
      fetch(rootState.apiUrl + "/bagged-posts?page=" + rootState.currentPage, {
        method: "GET",
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + rootState.user.token
        }
      })
        .then(function(res) {
          return res.json();
        })
        .then(function(res) {
          response(res);
        })
        .catch(err => {
          reject(err);
        });
    });
  },
  ReqInteract: function({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("post_id", payload.post_id);
    data.append("interact", payload.interact);
    fetch(rootState.apiUrl + "/req-interact", {
      method: "POST",
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + rootState.user.token
      },
      body: data
    })
      .then(function(res) {
        return res.json();
      })
      .then(function(res) {
        // console.log(res)
        // TODO: Add interact data to current post
      })
      .catch(err => {
        console.log(err);
      });
  },
  LoadUserInfo: function({ rootState, state, commit }) {
    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/user-detail", {
        method: "GET",
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + rootState.user.token
        }
      })
        .then(function(res) {
          return res.json();
        })
        .then(function(data) {
          if (typeof data.success !== "undefined") {
            let successData = data.success;
            commit("SET_USER", successData);
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
  ChangeAvatar: function({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("avatar", payload);
    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/change-avatar", {
        method: "POST",
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + rootState.user.token
        },
        body: data
      })
        .then(function(response) {
          return response.json();
        })
        .then(
          function(result) {
            if (result.success) {
              res(result.data);
            } else {
              rej(result.message);
            }
          },
          function(e) {
            rej(e.messages);
          }
        );
    });
  },
  ChangeCover: function({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("cover_image", payload);
    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/change-cover", {
        method: "POST",
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + rootState.user.token
        },
        body: data
      })
        .then(function(response) {
          return response.json();
        })
        .then(
          function(result) {
            if (result.success) {
              res(result.data);
            } else {
              rej(result.message);
            }
          },
          function(e) {
            rej(e.messages);
          }
        );
    });
  },
  UpdateInfo: function({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("full_name", payload.full_name);
    data.append("nick_name", payload.nick_name);
    data.append("bio", payload.bio);
    data.append("birthday", payload.birthday);

    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/update-info", {
        method: "POST",
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + rootState.user.token
        },
        body: data
      })
        .then(function(res) {
          return res.json();
        })
        .then(function(data) {
          if (data.success) {
            res(data);
          } else {
            rej(data);
          }
        })
        .catch(err => {
          rej(err);
        });
    });
  },
  ChangePassword: function({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("cur_password", payload.cur_password);
    data.append("password", payload.password);
    data.append("c_password", payload.c_password);

    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/change-password", {
        method: "POST",
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + rootState.user.token
        },
        body: data
      })
        .then(function(res) {
          return res.json();
        })
        .then(function(result) {
          if (result.success) {
            res(result);
          } else {
            rej(result);
          }
        })
        .catch(err => {
          rej(err);
        });
    });
  },
  UpdateNotificationConn: function() {},
  FinishPostLearnt: function({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("post_id", payload);

    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/update-learning-progress", {
        method: "POST",
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + rootState.user.token
        },
        body: data
      })
        .then(function(res) {
          return res.json();
        })
        .then(function(result) {
          if (result) {
            res(result);
          } else {
            rej(result);
          }
        })
        .catch(err => {
          rej(err);
        });
    });
  }
};
