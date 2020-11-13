<template>
  <div class="py-2 px-2 border-t-2 border-gray-400">
    <ul class="flex flex-wrap">
      <li class="w-1/6 mt-5 relative flex items-center justify-center">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
          class="w-6 absolute top-0 -m-3"
        >
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd"
          ></path>
        </svg>
        <div class="border-t-2 border-gray-800 pt-3 w-full text-center">
          Ngày 1
        </div>
      </li>
      <li class="w-1/6 mt-5 relative flex items-center justify-center">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
          class="w-6 absolute top-0 -m-3"
        >
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd"
          ></path>
        </svg>
        <div class="border-t-2 border-gray-800 pt-3 w-full text-center">
          Ngày 1
        </div>
      </li>
      <li class="w-1/6 mt-5 relative flex items-center justify-center">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
          class="w-6 absolute top-0 -m-3"
        >
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd"
          ></path>
        </svg>
        <div class="border-t-2 border-gray-800 pt-3 w-full text-center">
          Ngày 1
        </div>
      </li>
      <li class="w-1/6 mt-5 relative flex items-center justify-center">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
          class="w-6 absolute top-0 -m-3"
        >
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd"
          ></path>
        </svg>
        <div class="border-t-2 border-gray-800 pt-3 w-full text-center">
          Ngày 1
        </div>
      </li>
      <li class="w-1/6 mt-5 relative flex items-center justify-center">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
          class="w-6 absolute top-0 -m-3"
        >
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd"
          ></path>
        </svg>
        <div class="border-t-2 border-gray-800 pt-3 w-full text-center">
          Ngày 1
        </div>
      </li>
      <li class="w-1/6 mt-5 relative flex items-center justify-center">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
          class="w-6 absolute top-0 -m-3"
        >
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd"
          ></path>
        </svg>
        <div class="border-t-2 border-gray-800 pt-3 w-full text-center">
          Ngày 1
        </div>
      </li>
    </ul>
  </div>
  <!-- End interaction for user -->
</template>

<script>
import { mapActions } from "vuex";
import BaggedIcon from "@/components/Icons/BaggedIcon.vue";
import GoodVoted from "@/components/Icons/GoodVoted.vue";
import BadVoted from "@/components/Icons/BadVoted.vue";
export default {
  name: "interaction-pack",
  props: {
    post_id: Number
  },
  components: {},
  data() {
    return {};
  },
  methods: {
    ...mapActions([""])
  }
};
</script>
