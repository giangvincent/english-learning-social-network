<template>
  <nav id="header" class="w-full z-40 top-0 fixed">
    <div
      class="absolute bg-white w-full mx-auto flex flex-wrap items-center mt-0 px-4 justify-between sm:justify-center z-10 md:shadow"
      :class="{ shadow: !showNavbar }"
    >
      <label
        for="menu-toggle"
        class="cursor-pointer md:hidden block py-2"
        @click="toggle_left_panel"
      >
        <svg
          class="fill-current text-gray-900"
          xmlns="http://www.w3.org/2000/svg"
          width="20"
          height="20"
          viewBox="0 0 20 20"
        >
          <title>menu</title>
          <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
        </svg>
      </label>
      <input class="hidden" type="checkbox" id="menu-toggle" />

      <div
        class="hidden md:flex md:items-center w-full order-3 md:order-1 md:w-1/3"
      >
        <desktop-nav></desktop-nav>
      </div>

      <div class="order-1 md:order-2 md:w-1/3 flex justify-center py-2">
        <logo></logo>
      </div>

      <div class="order-2 md:order-3 flex md:w-1/3 flex-wrap justify-end">
        <div
          class="inline-block no-underline ml-2 relative"
          title="User"
          @click="userMenu()"
        >
          <div class="rounded-full flex overflow-hidden">
            <img
              :src="
                user.avatar
                  ? rootUrl + user.avatar
                  : '/assets/images/default_avatar.jpg'
              "
              alt="profilepic"
              width="28px"
              height="28px"
              style="width: 28px; height: 28px"
            />
            <label
              class="-m-2 absolute bg-color-blue font-semibold right-0 rounded-full text-center text-white text-xs top-0 numberIndicator"
              v-show="notification.length > 0"
              >{{
                notification.length > 10 ? "9+" : notification.length
              }}</label
            >
          </div>
          <!-- User icon -->
        </div>
      </div>
    </div>
    <!-- End top bar lvl0 -->
    <div
      class="absolute mt-10 w-full mx-auto flex text-center font-bold block md:hidden bg-white z-0 shadow"
      :class="{ 'slide-out-top': !showNavbar, 'slide-in-top': showNavbar }"
    >
      <a
        class="w-1/3 py-3"
        :class="{ 'border-b-2 border-gray-900': currentTab === cat.slug }"
        v-for="(cat, index) in categories"
        :key="`cat-${index}-${cat.slug}`"
        @click="navigate(cat.slug)"
        >{{ cat.name }}</a
      >
    </div>
    <!-- END top bar lvl1 -->
  </nav>
</template>
<script>
import { mapState, mapMutations } from "vuex";
import Logo from "./Logo";
import DesktopNav from "./Navigator/DesktopTopNav";
export default {
  name: "main-navigatior",
  components: {
    Logo,
    DesktopNav
  },
  data() {
    return {
      userUploaded: "/auth/login",
      userBagged: "/auth/login",
      userSetting: "/auth/login",
      userLogout: "/auth/logout",
      showNavbar: true,
      showUserMenu: false,
      lastScrollPosition: 0
    };
  },
  watch: {
    user: {
      handler: function(val) {
        if (this.user.id) {
          this.userUploaded = "/u/" + this.user.id;
          this.userBagged = "/u/" + this.user.id + "?cur=saved";
          this.userSetting = "/u/" + this.user.id + "?cur=setting";
        }
      },
      deep: true
    }
  },
  computed: {
    ...mapState({
      currentTab: state => state.currentTab,
      user: state => state.user.user,
      categories: state => state.categories,
      notification: state => state.user.notification,
      rootUrl: state => state.rootUrl
    })
  },
  mounted() {
    window.addEventListener("scroll", this.onScroll);
    if (this.user.id) {
      this.userUploaded = "/u/" + this.user.id;
      this.userBagged = "/u/" + this.user.id + "?cur=saved";
      this.userSetting = "/u/" + this.user.id + "?cur=setting";
    }
    if (
      typeof this.$route.params.name !== "undefined" &&
      this.$route.params.name !== this.currentTab
    ) {
      this.CHANGE_TAB(this.$route.params.name);
    }
  },
  methods: {
    ...mapMutations(["CHANGE_TAB", "toggle_left_panel", "toggle_right_panel"]),
    navigate(goto) {
      this.CHANGE_TAB(goto);
      this.$router.push("/" + goto);
    },
    userMenu() {
      if (this.user.id) {
        this.toggle_right_panel();
      } else {
        this.$router.push("/auth/login");
      }
    },
    onScroll() {
      const currentScrollPosition =
        window.pageYOffset || document.documentElement.scrollTop;
      if (currentScrollPosition < 0) {
        return;
      } // Stop executing this function if the difference between
      // current scroll position and last scroll position is less than some offset
      if (Math.abs(currentScrollPosition - this.lastScrollPosition) < 60) {
        return;
      }
      this.showNavbar = currentScrollPosition < this.lastScrollPosition;
      this.lastScrollPosition = currentScrollPosition;
    }
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.onScroll);
  }
};
</script>
