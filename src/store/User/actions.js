export default {
  LoadNotification: function ({ rootState, state, commit }) {
    if (rootState.user && rootState.user.token) {
      fetch(rootState.apiUrl + "/get-notification", {
        method: "GET",
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + rootState.user.token
        }
      })
        .then(res => res.json())
        .then(res => {
          // console.log(res);
          let dayNow = new Date().toDateString();
          let dayCur = 0;
          let notificationData = [];
          for (let index = 0; index < res.length; index++) {
            dayCur = new Date(res[index].date).toDateString();
            if (dayCur == dayNow) {
              notificationData.push(res[index]);
            }
          }
          rootState.user.notification = notificationData;
        })
        .catch(err => {
          console.log(err);
        });
    }
  },
  CHECK_EMAIL: function ({ rootState }, payload) {
    let data = new FormData();
    data.append("email", payload);

    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/reset-password", {
        method: "POST",
        body: data
      }).then(function (res) {
        return res.json()
      }).then(function (data) {
        if (typeof data.success !== "undefined") {
          let successData = data.success;
          res(successData);
        } else {
          rej(data.error);
        }
      }).catch(err => {
        rej(err)
      })
    })
  },
  UPDATE_RESET_PASS: function ({ rootState }, payload) {
    let data = new FormData();
    data.append("email", payload.email);
    data.append("token", payload.token)
    data.append('password', payload.password)
    data.append('password_confirmation', payload.password_confirmation)

    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/update-reset-password", {
        method: "POST",
        body: data
      }).then(function (res) {
        return res.json()
      }).then(function (data) {
        if (data.status) {
          res(data.message);
        } else {
          rej(data);
        }
      }).catch(err => {
        rej(err)
      })
    })
  },
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
          // console.log(data);
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
    data.append("birthday", payload.birthday);
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
    return new Promise((response, reject) => {
      fetch(
        rootState.apiUrl +
        "/uploaded-posts/" +
        payload +
        "?page=" +
        rootState.currentPage,
        {
          method: "GET",
          headers: {
            Accept: "application/json"
          }
        }
      )
        .then(function (res) {
          return res.json();
        })
        .then(function (res) {
          response(res);
        })
        .catch(err => {
          reject(err);
        });
    });
  },

  GetBaggedPosts: function ({ rootState, state, commit }, payload) {
    return new Promise((response, reject) => {
      fetch(rootState.apiUrl + "/bagged-posts?page=" + rootState.currentPage, {
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
          response(res);
        })
        .catch(err => {
          reject(err);
        });
    });
  },
  ReqInteract: function ({ rootState, state, commit }, payload) {
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
      .then(function (res) {
        return res.json();
      })
      .then(function (res) {
        // console.log(res)
        // TODO: Add interact data to current post
      })
      .catch(err => {
        console.log(err);
      });
  },
  LoadUserInfo: function ({ rootState, state, commit }, payload) {
    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/user-detail/" + payload, {
        method: "GET",
        headers: {
          Accept: "application/json"
        }
      })
        .then(function (res) {
          return res.json();
        })
        .then(function (data) {
          if (typeof data.success !== "undefined") {
            let successData = data.success;
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
  ChangeAvatar: function ({ rootState, state, commit }, payload) {
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
        .then(function (response) {
          return response.json();
        })
        .then(
          function (result) {
            if (result.success) {
              res(1);
            } else {
              rej(result.message);
            }
          },
          function (e) {
            rej(e.messages);
          }
        );
    });
  },
  ChangeCover: function ({ rootState, state, commit }, payload) {
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
        .then(function (response) {
          return response.json();
        })
        .then(
          function (result) {
            if (result.success) {
              res(1);
            } else {
              rej(result.message);
            }
          },
          function (e) {
            rej(e.messages);
          }
        );
    });
  },
  UpdateInfo: function ({ rootState, state, commit }, payload) {
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
        .then(function (res) {
          return res.json();
        })
        .then(function (data) {
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
  ChangePassword: function ({ rootState, state, commit }, payload) {
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
        .then(function (res) {
          return res.json();
        })
        .then(function (result) {
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
  UpdateNotificationConn: function ({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("notification_conn", JSON.stringify(payload.notification_conn));
    // data.append("socials_conn", JSON.stringify(payload.socials_conn));
    data.append("socials_conn", JSON.stringify({}));

    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/update-notification-conn", {
        method: "POST",
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + rootState.user.token
        },
        body: data
      })
        .then(function (res) {
          return res.json();
        })
        .then(function (result) {
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
  },
  FinishPostLearnt: function ({ rootState, state, commit }, payload) {
    if (rootState.user && rootState.user.token) {
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
          .then(function (res) {
            return res.json();
          })
          .then(function (result) {
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
  },
  SeenNotification: function ({ rootState, state, commit }, payload) {
    if (rootState.user && rootState.user.token) {
      fetch(rootState.apiUrl + "/seen-notification/" + payload, {
        method: "get",
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + rootState.user.token
        }
      })
        .then(res => {
          console.log(res);
        })
        .catch(err => console.log(err));
    }
  }
};
