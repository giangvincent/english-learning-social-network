<template>
  <div class="fixed bottom-0 right-0 m-3 md:m-6">
    <button
      class="w-12 h-12 md:w-16 md:h-16 rounded-full shadow md:shadow-2xl text-white bg-color-blue btn-hover gradient-black"
      @click="toCreator"
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
          d="M12 6v6m0 0v6m0-6h6m-6 0H6"
        />
      </svg>
    </button>
  </div>
</template>

<script>
export default {
  name: "to-creator-btn",
  methods: {
    toCreator() {
      this.$router.replace("/creator");
    }
  }
};
</script>
