export default {
    LOGIN: function (state, payload) {
        var data = new FormData();
        data.append("email", payload.email);
        data.append("password", payload.password);

        fetch(state.apiUrl + "/login",
            {
                method: "POST",
                body: data
            })
            .then(function (res) { return res.json(); })
            .then(function (data) { alert(JSON.stringify(data)) })
    },
    REGISTER: function (state, payload) {
        var data = new FormData();
        data.append("email", payload.email);
        data.append("password", payload.password);

        fetch(state.apiUrl + "/login",
            {
                method: "POST",
                body: data
            })
            .then(function (res) { return res.json(); })
            .then(function (data) { alert(JSON.stringify(data)) })
    }
};
