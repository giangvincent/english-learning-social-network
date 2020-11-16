<template>
  <div class="py-2 px-2 border-t-2 border-gray-400">
    <ul class="flex flex-wrap border-l-2 border-r-2 border-gray-900">
      <li
        class="w-1/4 mt-5 relative flex items-center justify-center"
        v-for="(date, index) in datesArray"
        :key="'datesArray' + index"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
          class="w-6 absolute top-0 -m-3 rounded-full bg-white border-2 border-gray-900 text-white"
        >
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd"
          ></path>
        </svg>
        <div class="border-t-2 border-gray-800 pt-3 w-full text-center">
          Ngày {{ date }}
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
    post_id: String
  },
  components: {},
  data() {
    return {
      datesArray: [1],
      datesIndex: 0,
      defaultLength: 8
    };
  },
  mounted() {
    this.fibonacciDates();
  },
  methods: {
    ...mapActions([""]),
    fibonacciDates() {
      if (this.datesIndex >= this.defaultLength - 1) {
        return false;
      }
      let nextDate =
        this.datesIndex === 0
          ? this.datesArray[this.datesIndex] + this.datesArray[this.datesIndex]
          : this.datesArray[this.datesIndex] +
            this.datesArray[this.datesIndex - 1];
      this.datesArray.push(nextDate);
      this.datesIndex++;
      return this.fibonacciDates();
    }
  }
};
</script>
