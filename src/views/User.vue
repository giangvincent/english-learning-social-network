<template>
  <div>
    <main-navigation></main-navigation>

    <div class="sm:rounded sm:rounded-t-lg shadow max-w-sm md:px-6 lg:px-8 pt-16">
      <div
        class="h-40 w-full overflow-hidden bg-center bg-cover"
        style="background-image: url(images/default.jpg)"
      ></div>
      <!-- End cover image -->

      <div class="flex justify-center -mt-8">
        <img
          src="images/default_avatar.jpg"
          class="rounded-full border-solid border-white border-2 -mt-3"
        />
      </div>
      <!-- End avatar image -->
      <div class="text-center px-3 pb-6 pt-2">
        <h3 class="text-black text-sm bold font-sans">Olivia Dunham</h3>
        <p class="mt-2 font-sans font-light text-grey-dark">Hello, i'm from another the other side!</p>
      </div>
      <!-- End bio -->

      <div class="w-full mx-auto flex text-center font-bold">
        <a href="user.html" class="w-1/3 py-3 border-b-2 border-gray-900">Đã đăng</a>
        <a href="#" class="w-1/3 py-3">Đă lưu</a>
        <a href="user-setting.html" class="w-1/3 py-3">Cài đặt</a>
      </div>
      <!-- END topbar lvl1 -->
    </div>
    <!-- User info -->

    <main-feed></main-feed>
  </div>
</template>

<script>
import MainNavigation from "@/components/MainNavigation.vue";
export default {
  components: {
    MainNavigation,
    MainFeed,
  },
};
</script>