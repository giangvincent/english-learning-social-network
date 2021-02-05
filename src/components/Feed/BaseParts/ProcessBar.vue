<template>
  <div class="py-2 px-2 border-t-2 border-gray-400">
    <button
      class="font-semibold text-white rounded-lg btn-hover flex justify-center items-center mx-auto bg-gray-900 px-3 py-1 mb-3"
      @click="unLearn"
    >
      Bỏ lưu
    </button>
    <fieldset class="border-2 border-b-0 border-gray-700 pt-2">
      <legend
        class="mx-2 text-xs font-bold rounded-lg bg-gray-700 text-white p-1"
      >
        Ngày học
      </legend>
      <ul class="flex flex-wrap ">
        <li
          class="w-1/4 mt-5 relative flex items-center justify-center"
          v-for="(date, index) in datesArray"
          :key="'datesArray' + index"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
            class="w-6 absolute top-0 -m-3 rounded-full bg-white border-2 border-gray-700"
            :class="{
              'text-white': typeof dataProgress[index] === 'undefined'
            }"
          >
            <path
              fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd"
            ></path>
          </svg>
          <div class="border-t-2 border-gray-700 pt-3 w-full text-center">
            Ngày {{ date }}
          </div>
        </li>
      </ul>
    </fieldset>
  </div>
  <!-- End interaction for user -->
</template>

<script>
import { mapState, mapActions, mapMutations } from "vuex";
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
      defaultLength: 8,
      dataProgress: []
    };
  },
  computed: {
    ...mapState({
      user: state => state.user.user,
      baggedPosts: state => state.user.baggedPosts
    })
  },
  mounted() {
    this.fibonacciDates();
    this.loadProgressData();
  },
  methods: {
    ...mapActions(["ReqInteract"]),
    ...mapMutations(["setBaggedPosts"]),
    loadProgressData() {
      let fileProgress =
        "/content/progress/" + this.user.id + "_" + this.post_id + ".json";
      let self = this;
      if (this.isExist(fileProgress))
        fetch(fileProgress)
          .then(res => res.json())
          .then(res => {
            console.log(res);
            self.dataProgress = res;
          })
          .catch(err => console.log(err));
    },
    unLearn() {
      let newBaggedPosts = this.baggedPosts;
      for (let index = 0; index < this.baggedPosts.length; index++) {
        if (this.baggedPosts[index].pid === this.post_id) {
          newBaggedPosts.splice(index, 1);
        }
      }
      this.setBaggedPosts(newBaggedPosts);
      var self = this;
      setTimeout(function() {
        self.ReqInteract({
          post_id: self.post_id,
          interact: "un-bagged"
        });
      }, 500);
    },
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
