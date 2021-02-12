<template>
  <div>
    <div
      class="fb-comments"
      :data-href="'https://thatsgood.info/p/' + url.type + '/' + url.slug"
      data-width="100%"
      data-numposts="10"
    ></div>
  </div>
</template>

<script>
export default {
  name: "Facebook-Comments",
  props: {
    url: Object,
  },
  created: function () {
    window.fbAsyncInit = function () {
      FB.init({
        appId: "838730860251375",
        autoLogAppEvents: true,
        xfbml: true,
        version: "v9.0",
      });
    };

    (function (d, s, id) {
      var js,
        fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v9.0";
      fjs.parentNode.insertBefore(js, fjs);
    })(document, "script", "facebook-jssdk");
  },
  mounted() {
    // this.$nextTick(() => {
    //   window.FB.XFBML.parse();
    // });
  },
};
</script>