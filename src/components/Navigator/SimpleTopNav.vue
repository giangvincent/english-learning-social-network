<template>
  <!--Nav-->
  <nav id="header" class="bg-white w-full shadow">
    <div
      class="w-full container mx-auto flex flex-wrap items-center mt-0 px-4 justify-between sm:justify-center"
    >
      <label
        for="menu-toggle"
        class="sm:w-1/2 cursor-pointer py-2"
        @click="$router.go(-1)"
      >
        <svg
          class="color-black fill-current w-5"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M10 19l-7-7m0 0l7-7m-7 7h18"
          />
        </svg>
      </label>

      <div class="order-1 md:order-2 sm:w-1/2 flex justify-center py-2">
        <logo></logo>
      </div>
    </div>
  </nav>
</template>

<script>
import logo from "../Logo.vue";
export default {
  name: "simpleTopNav",
  components: {
    logo
  }
};
</script>
