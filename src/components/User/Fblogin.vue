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
  mounted() {
    initSdk();
  },
  methods: {
    fbLogin() {
      this.processApi = true;
      if (window.FB) {
        window.FB.login(
          function(response) {
            this.processApi = false;
            console.log(response.authResponse.accessToken);
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
