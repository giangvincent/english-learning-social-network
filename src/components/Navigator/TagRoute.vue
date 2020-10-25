<template>
  <router-link
    :to="router"
    class="flex flex-row items-center px-2 xl:px-4 rounded-lg"
  >
    <span class="flex items-center justify-center">
      <svg
        class="w-6 h-6"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"
        />
      </svg>
    </span>
    <span class="m-2">{{ text }}</span>
    <span
      class="flex items-center justify-center text-sm font-semibold bg-gray-100 h-6 px-2 rounded-full ml-auto"
      >{{ numberDisplay }}</span
    >
  </router-link>
</template>

<script>
export default {
  name: "tag-route",
  props: {
    text: String,
    numPost: Number,
    router: String,
  },
  data() {
    return {
      numberDisplay: "0",
    };
  },
  mounted() {
    this.numberDisplay =
      this.numPost > 99 ? String(this.numPost) + "+" : String(this.numPost);
  },
};
</script>