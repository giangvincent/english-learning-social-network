<template>
  <div>
    <main-navigation></main-navigation>
    <side-panel-left></side-panel-left>
    <div class="flex">
      <div class="hidden md:block md:w-1/5"></div>
      <div class="my-6 md:px-6 lg:px-8 md:w-4/5 pt-16">
        <div class="sm:rounded sm:rounded-t-lg shadow bg-white">
          <div
            class="h-40 w-full overflow-hidden bg-center bg-cover relative bg-color-black"
            style="background-image: url(/assets/images/default.jpg)"
          >
            <label
              class="m-1 absolute bg-gray-600 font-semibold h-6 p-1 right-0 rounded-full text-center text-white text-xs top-0 w-6"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                /></svg
            ></label>
          </div>
          <!-- End cover image -->

          <div class="flex justify-center -mt-8">
            <div class="-mt-3 relative">
              <img
                src="@/assets/images/default_avatar.jpg"
                class="rounded-full border-solid border-white border-2"
              />
              <label
                class="absolute bg-gray-600 font-semibold h-6 p-1 right-0 rounded-full text-center text-white text-xs top-0 w-6"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                  /></svg
              ></label>
            </div>
          </div>
          <!-- End avatar image -->
          <div class="text-center px-3 pb-6 pt-2">
            <h3 class="font-bold text-2xl">Olivia Dunham</h3>
            <p class="mt-2 text-grey-dark">
              Hello, i'm from another the other side!
            </p>
          </div>
          <!-- End bio -->

          <div class="w-full mx-auto flex text-center font-bold">
            <router-link
              :to="{
                name: 'user-page',
                params: { id: 123 },
              }"
              class="w-1/3 py-3"
              replace
              :class="{
                'border-b-2 border-gray-900':
                  typeof $route.query.cur === 'undefined',
              }"
              >Đã đăng</router-link
            >
            <router-link
              :to="{
                name: 'user-page',
                params: { id: 123 },
                query: { cur: 'saved' },
              }"
              replace
              class="w-1/3 py-3"
              :class="{
                'border-b-2 border-gray-900': $route.query.cur === 'saved',
              }"
              >Đang học</router-link
            >
            <router-link
              :to="{
                name: 'user-page',
                params: { id: 123 },
                query: { cur: 'setting' },
              }"
              class="w-1/3 py-3"
              replace
              :class="{
                'border-b-2 border-gray-900': $route.query.cur === 'setting',
              }"
              >Cài đặt</router-link
            >
          </div>
          <!-- END topbar lvl1 -->
        </div>
      </div>
    </div>

    <!-- User info -->

    <user-created v-if="typeof $route.query.cur === 'undefined'"></user-created>
    <saved-post v-if="$route.query.cur === 'saved'"></saved-post>
    <setting v-if="$route.query.cur === 'setting'"></setting>
    <to-creator></to-creator>
  </div>
</template>

<script>
// @ is an alias to /src
import { mapState, mapMutations } from "vuex";
import MainNavigation from "@/components/MainNavigation.vue";
import SidePanelLeft from "@/components/Navigator/SidePanelLeft.vue";
import ToCreator from "@/components/Navigator/ToCreationBtn.vue";

import SavedPost from "@/components/User/SavedPost.vue";
import UserCreated from "@/components/User/UserCreated.vue";
import Setting from "@/components/User/Setting.vue";

export default {
  name: "home",
  components: {
    MainNavigation,
    ToCreator,
    SidePanelLeft,
    SavedPost,
    UserCreated,
    Setting,
  },
  data() {
    return {
      items: [],
    };
  },
  mounted() {
    this.SET_PAGE("user");
  },
  methods: {
    ...mapMutations(["SET_PAGE"]),
  },
};
</script>
