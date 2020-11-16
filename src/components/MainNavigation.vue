<template>
  <nav id="header" class="w-full z-40 top-0 fixed">
    <div
      class="absolute bg-white w-full mx-auto flex flex-wrap items-center mt-0 px-4 justify-between sm:justify-center z-10"
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
          class="inline-block no-underline hover:text-black relative"
          title="Thông báo"
          @click="toggle_right_panel"
        >
          <label
            class="-m-2 absolute bg-color-blue font-semibold right-0 rounded-full text-center text-white text-xs top-0 numberIndicator"
            >9+</label
          >
          <svg
            class="hover:text-black"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            width="24"
            height="24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
            />
          </svg>
          <!-- Notify icon -->
        </div>
        <router-link
          :to="userNavigateUrl"
          class="inline-block no-underline hover:text-black ml-2"
          title="User"
        >
          <svg
            class="fill-current hover:text-black"
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
          >
            <circle fill="none" cx="12" cy="7" r="3" />
            <path
              d="M12 2C9.243 2 7 4.243 7 7s2.243 5 5 5 5-2.243 5-5S14.757 2 12 2zM12 10c-1.654 0-3-1.346-3-3s1.346-3 3-3 3 1.346 3 3S13.654 10 12 10zM21 21v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h2v-1c0-2.757 2.243-5 5-5h4c2.757 0 5 2.243 5 5v1H21z"
            />
          </svg>
          <!-- User icon -->
        </router-link>
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
      userNavigateUrl: "/auth/login",
      showNavbar: true,
      lastScrollPosition: 0
    };
  },
  watch: {
    user: {
      handler: function(val) {
        if (this.user.id) {
          this.userNavigateUrl = "/u/" + this.user.id;
        }
      },
      deep: true
    }
  },
  computed: {
    ...mapState({
      currentTab: state => state.currentTab,
      user: state => state.user.user,
      categories: state => state.categories
    })
  },
  mounted() {
    window.addEventListener("scroll", this.onScroll);
    if (this.user.id) {
      this.userNavigateUrl = "/u/" + this.user.id;
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

<style>
.slide-out-top {
  -webkit-animation: slide-out-top 0.5s cubic-bezier(0.55, 0.085, 0.68, 0.53)
    both;
  animation: slide-out-top 0.5s cubic-bezier(0.55, 0.085, 0.68, 0.53) both;
}

.slide-in-top {
  -webkit-animation: slide-in-top 0.5s cubic-bezier(0.55, 0.085, 0.68, 0.53)
    both;
  animation: slide-in-top 0.5s cubic-bezier(0.55, 0.085, 0.68, 0.53) both;
}
@-webkit-keyframes slide-out-top {
  0% {
    margin-top: 2.5rem;
  }
  100% {
    margin-top: -2.5rem;
  }
}
@keyframes slide-out-top {
  0% {
    margin-top: 2.5rem;
  }
  100% {
    margin-top: -2.5rem;
  }
}

@-webkit-keyframes slide-in-top {
  0% {
    margin-top: -2.5rem;
  }
  100% {
    margin-top: 2.5rem;
  }
}
@keyframes slide-in-top {
  0% {
    margin-top: -2.5rem;
  }
  100% {
    margin-top: 2.5rem;
  }
}
</style>
