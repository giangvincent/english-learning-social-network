export default {
  SUBMIT_POST: function ({ rootState, state, commit }, payload) {
    var data = new FormData();
    data.append("cat_id", payload.cat_id);
    data.append("post_type", payload.postType);
    data.append("content", payload.postContent);
    data.append("user", payload.user);

    return new Promise((res, rej) => {
      fetch(rootState.apiUrl + "/create-post", {
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
  }
};
