<template>
  <button
    class="w-full bg-red-700 hover:bg-red-800 text-white font-bold py-2 px-4 focus:outline-none focus:shadow-outline rounded-lg"
    type="button"
    @click="GgLogin"
  >
    <span v-if="!processApi"> Đăng nhập với Google </span>
    <div v-if="processApi">
      <loading-icon></loading-icon>
    </div>
  </button>
</template>

<script>
var googleAuth = (function() {
  function installClient() {
    var apiUrl = "https://apis.google.com/js/api.js";
    return new Promise(resolve => {
      var script = document.createElement("script");
      script.src = apiUrl;
      script.onreadystatechange = script.onload = function() {
        if (!script.readyState || /loaded|complete/.test(script.readyState)) {
          setTimeout(function() {
            resolve();
          }, 500);
        }
      };
      document.getElementsByTagName("head")[0].appendChild(script);
    });
  }

  function initClient(config) {
    return new Promise((resolve, reject) => {
      window.gapi.load("auth2", () => {
        window.gapi.auth2
          .init(config)
          .then(() => {
            resolve(window.gapi);
          })
          .catch(error => {
            reject(error);
          });
      });
    });
  }

  function Auth() {
    if (!(this instanceof Auth)) return new Auth();
    this.GoogleAuth = null; /* window.gapi.auth2.getAuthInstance() */
    this.isAuthorized = false;
    this.isInit = false;
    this.prompt = null;
    this.isLoaded = function() {
      /* eslint-disable */
      console.warn(
        'isLoaded() will be deprecated. You can use "this.$gAuth.isInit"'
      );
      return !!this.GoogleAuth;
    };

    this.load = (config, prompt) => {
      installClient()
        .then(() => {
          return initClient(config);
        })
        .then(gapi => {
          this.GoogleAuth = gapi.auth2.getAuthInstance();
          this.isInit = true;
          this.prompt = prompt;
          this.isAuthorized = this.GoogleAuth.isSignedIn.get();
        })
        .catch(error => {
          console.error(error);
        });
    };

    this.signIn = (successCallback, errorCallback) => {
      return new Promise((resolve, reject) => {
        if (!this.GoogleAuth) {
          if (typeof errorCallback === "function") errorCallback(false);
          reject(false);
          return;
        }
        this.GoogleAuth.signIn()
          .then(googleUser => {
            if (typeof successCallback === "function")
              successCallback(googleUser);
            this.isAuthorized = this.GoogleAuth.isSignedIn.get();
            resolve(googleUser);
          })
          .catch(error => {
            if (typeof errorCallback === "function") errorCallback(error);
            reject(error);
          });
      });
    };

    this.getAuthCode = (successCallback, errorCallback) => {
      return new Promise((resolve, reject) => {
        if (!this.GoogleAuth) {
          if (typeof errorCallback === "function") errorCallback(false);
          reject(false);
          return;
        }
        this.GoogleAuth.grantOfflineAccess({ prompt: this.prompt })
          .then(function(resp) {
            if (typeof successCallback === "function")
              successCallback(resp.code);
            resolve(resp.code);
          })
          .catch(function(error) {
            if (typeof errorCallback === "function") errorCallback(error);
            reject(error);
          });
      });
    };

    this.signOut = (successCallback, errorCallback) => {
      return new Promise((resolve, reject) => {
        if (!this.GoogleAuth) {
          if (typeof errorCallback === "function") errorCallback(false);
          reject(false);
          return;
        }
        this.GoogleAuth.signOut()
          .then(() => {
            if (typeof successCallback === "function") successCallback();
            this.isAuthorized = false;
            resolve(true);
          })
          .catch(error => {
            if (typeof errorCallback === "function") errorCallback(error);
            reject(error);
          });
      });
    };
  }

  return new Auth();
})();

import LoadingIcon from "@/components/Icons/LoadingAnimate.vue";
import { mapMutations, mapState } from "vuex";
export default {
  name: "google-login",
  components: {
    LoadingIcon
  },
  data() {
    return {
      processApi: false
    };
  },
  computed: {
    ...mapState({
      apiUrl: state => state.apiUrl
    })
  },
  mounted() {
    const gauthOption = {
      clientId:
        "677986354646-pr792putvnj08m3ign03h92n5o2ep5to.apps.googleusercontent.com",
      scope: "profile email",
      prompt: "select_account"
    };
    googleAuth.load(gauthOption, prompt);
  },
  methods: {
    ...mapMutations(["SET_TOKEN", "SET_USER"]),
    GgLogin() {
      this.processApi = true;
      let self = this;
      googleAuth.signIn().then(googleUser => {
        this.processApi = false;
        // console.log(googleUser);
        let id_token = googleUser.getAuthResponse().id_token;
        // console.log(id_token);
        let data = new FormData();
        data.append("social_token", id_token);
        fetch(self.apiUrl + "/social-login/google", {
          method: "POST",
          body: data
        })
          .then(function(res) {
            return res.json();
          })
          .then(function(data) {
            // console.log(data);
            if (typeof data.success !== "undefined") {
              let successData = data.success;
              if (self.isLocalStorage()) {
                localStorage.setItem(
                  "thatsgood_info_user",
                  JSON.stringify(successData.user)
                );
                localStorage.setItem(
                  "thatsgood_info_user_token",
                  JSON.stringify(successData.token)
                );
              }
              self.SET_TOKEN(successData.token);
              self.SET_USER(successData.user);
              self.$router.go(-1);
            } else {
              console.log(data.error);
            }
          })
          .catch(err => {
            console.log(err);
          });
      });
    }
  }
};
</script>
