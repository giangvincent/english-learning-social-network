<template>
  <button
    class="w-full bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-4 focus:outline-none focus:shadow-outline rounded-lg"
    type="button"
    @click="fbLogin"
  >
    <span v-if="!processApi"> Đăng nhập với Facebook </span>
    <div v-if="processApi">
      <loading-icon></loading-icon>
    </div>
  </button>
</template>

<script>
const FACEBOOK_SCRIPT_ID = "facebook-jssdk";
function handleLoadError(error) {
  console.error(
    new URIError(`The script ${error.target.src} didn't load correctly.`)
  );
}
function initSdk(locale = "vi_VN") {
  return new Promise((resolve, reject) => {
    // prettier-ignore
    window.fbAsyncInit = function() {
        window.FB.init({
        appId: '838730860251375',
        autoLogAppEvents : true,
        xfbml: true,
        version: 'v9.0'
        })
        resolve(window.FB)
    }; // eslint-disable-line
    /* eslint-disable */
    // prettier-ignore
    (function (d, s, id) {
        const fjs = d.getElementsByTagName(s)[0]
        if (d.getElementById(id)) { return; }
        const js = d.createElement(s); js.id = id
        js.src = `//connect.facebook.net/${locale}/sdk.js`
        js.onerror = error => { handleLoadError(error); reject(error) } // non-facebook line
        fjs.parentNode.insertBefore(js, fjs)
    }(document, 'script', FACEBOOK_SCRIPT_ID))
    /* eslint-enable */
  });
}
import LoadingIcon from "@/components/Icons/LoadingAnimate.vue";
import { mapMutations, mapState } from "vuex";
export default {
  name: "fb-login",
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
    initSdk();
  },
  methods: {
    ...mapMutations(["SET_TOKEN", "SET_USER"]),
    fbLogin() {
      this.processApi = true;
      let self = this;
      if (window.FB) {
        window.FB.login(
          function(response) {
            console.log(response);
            var data = new FormData();
            data.append("social_token", response.authResponse.accessToken);
            data.append("user_id", response.authResponse.UserId);
            fetch(self.apiUrl + "/social-login/facebook", {
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
                      "user",
                      JSON.stringify(successData.user)
                    );
                    localStorage.setItem(
                      "user_token",
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
          },
          { scope: "email", return_scopes: true }
        );
      } else {
        initSdk().then(() => this.fbLogin());
      }
    }
  }
};
</script>
