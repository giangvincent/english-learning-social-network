<template>
  <nav id="header" class="bg-white w-full z-20 top-0 fixed shadow">
    <div
      class="w-full mx-auto flex flex-wrap items-center mt-0 px-4 justify-between sm:justify-center"
    >
      <label for="menu-toggle" class="cursor-pointer md:hidden block py-2">
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
        <router-link
          to="/auth/login"
          class="inline-block no-underline hover:text-black"
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
        </router-link>
      </div>
    </div>
    <!-- End topbar lvl0 -->
    <div class="w-full mx-auto flex text-center font-bold block md:hidden">
      <a
        class="w-1/3 py-3"
        :class="{ 'border-b-2 border-gray-900': currentTab === 'vocabulary' }"
        @click="navigate('vocabulary')"
        >Từ vựng</a
      >
      <a
        class="w-1/3 py-3"
        :class="{ 'border-b-2 border-gray-900': currentTab === 'listen' }"
        @click="navigate('listen')"
        >Nghe</a
      >
      <a
        class="w-1/3 py-3"
        :class="{ 'border-b-2 border-gray-900': currentTab === 'article' }"
        @click="navigate('article')"
        >Bài viết</a
      >
    </div>
    <!-- END topbar lvl1 -->
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
    return {};
  },
  computed: {
    ...mapState({
      currentTab: state => state.currentTab
    })
  },
  mounted() {
    if (
      typeof this.$route.params.name !== "undefined" &&
      this.$route.params.name !== this.currentTab
    ) {
      this.CHANGE_TAB(this.$route.params.name);
    }
  },
  methods: {
    ...mapMutations(["CHANGE_TAB"]),
    navigate(goto) {
      this.CHANGE_TAB(goto);
      this.$router.push("/" + goto);
    }
  }
};
</script>
