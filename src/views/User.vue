<template>
  <div>
    <main-navigation></main-navigation>
    <side-panel-left></side-panel-left>
    <div class="my-6 md:px-6 lg:px-8 md:w-6/12 pt-16 mx-auto">
      <div class="sm:rounded sm:rounded-t-lg shadow">
        <div
          class="h-40 w-full overflow-hidden bg-center bg-cover"
          style="background-image: url(../assets/images/default.jpg)"
        ></div>
        <!-- End cover image -->

        <div class="flex justify-center -mt-8">
          <img
            src="@/assets/images/default_avatar.jpg"
            class="rounded-full border-solid border-white border-2 -mt-3"
          />
        </div>
        <!-- End avatar image -->
        <div class="text-center px-3 pb-6 pt-2">
          <h3 class="text-black text-sm bold font-sans">Olivia Dunham</h3>
          <p class="mt-2 font-sans font-light text-grey-dark">
            Hello, i'm from another the other side!
          </p>
        </div>
        <!-- End bio -->

        <div class="w-full mx-auto flex text-center font-bold">
          <a href="user.html" class="w-1/3 py-3 border-b-2 border-gray-900"
            >Đã đăng</a
          >
          <a href="#" class="w-1/3 py-3">Đă lưu</a>
          <a href="user-setting.html" class="w-1/3 py-3">Cài đặt</a>
        </div>
        <!-- END topbar lvl1 -->
      </div>
    </div>
    <!-- User info -->

    <main-feed :itemArray="items"></main-feed>
    <to-creator></to-creator>
  </div>
</template>

<script>
// @ is an alias to /src
import { mapState, mapMutations } from "vuex";
import MainNavigation from "@/components/MainNavigation.vue";
import SidePanelLeft from "@/components/Navigator/SidePanelLeft.vue";
import MainFeed from "@/components/Feed/Main.vue";
import ToCreator from "@/components/Navigator/ToCreationBtn.vue";

export default {
  name: "home",
  components: {
    MainNavigation,
    MainFeed,
    ToCreator,
    SidePanelLeft
  },
  data() {
    return {
      items: []
    };
  },
  mounted() {
    var self = this;
    setTimeout(() => {
      var rand = Math.floor(Math.random() * 10 + 1);
      console.log(rand);
      for (let i = 0; i < rand; i++) {
        self.items.push(i);
      }
    }, 500);
    this.SET_PAGE("user");
  },
  methods: {
    ...mapMutations(["SET_PAGE"])
  }
};
</script>
