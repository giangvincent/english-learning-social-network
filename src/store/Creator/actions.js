export default {
  Upload_image: async function ({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("base64", payload);
    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/upload-image", {
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
              res(result.data);
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
  SUBMIT_POST: function ({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("cat_id", payload.cat_id);
    data.append("post_type", payload.postType);
    data.append("subject", payload.subject);
    data.append("content", payload.postContent);
    data.append("user", payload.user);
    data.append("tags", payload.tags);
    let url = rootState.apiUrl + "/create-post";

    if (state.currentAction === "edit" && state.editPostId !== null) {
      data.append("pid", state.editPostId);
      url = rootState.apiUrl + "/update-post";
    }

    return new Promise((res, rej) => {
      fetch(url, {
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
          console.log(data);
          if (typeof data.status !== "undefined") {
            let successData = data;
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
  REQ_DEL_POST: function ({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("pid", payload);

    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/delete-post", {
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
          console.log(data);
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

  REQ_REPORT_POST: function ({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("pid", payload);

    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/report-post", {
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
          console.log(data);
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
  callForGoogleAudio: function ({ state, commit }, payload) {

  }
};
