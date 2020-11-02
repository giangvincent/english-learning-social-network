<template>
  <div
    class="py-2 px-2 border-t-2 border-gray-400 flex content-center flex-wrap"
  >
    <div
      class="w-1/5 py-2 rounded-lg hover:bg-gray-300 flex flex-col items-center justify-center flex-wrap font-bold relative"
      @click="saveClick"
    >
      <bagged-icon :saved="saved"></bagged-icon>
      <span :class="{ 'text-green-500': !saved, 'text-red-500': saved }">{{
        saved ? "Bỏ học" : "Học"
      }}</span>
      <label
        class="m-1 absolute bg-color-blue font-semibold right-0 rounded-full text-center text-white text-xs top-0 numberIndicator"
        v-if="indicatorNum.nums_bagged > 0"
        >{{ indicatorNum.nums_bagged }}</label
      >
    </div>
    <!-- saved icon -->
    <div
      class="w-1/5 py-2 rounded-lg hover:bg-gray-300 flex flex-col items-center justify-center flex-wrap font-bold relative"
      @click="goodClick"
    >
      <good-voted :goodVoted="goodVoted"></good-voted>
      <span :class="{ 'color-blue': goodVoted }">{{
        goodVoted ? "Good" : "Good?"
      }}</span>
      <label
        class="m-1 absolute bg-color-blue font-semibold right-0 rounded-full text-center text-white text-xs top-0 numberIndicator"
        v-if="indicatorNum.nums_good > 0"
        >{{ indicatorNum.nums_good }}</label
      >
    </div>
    <!-- good icon -->

    <div
      class="w-1/5 py-2 rounded-lg hover:bg-gray-300 flex flex-col items-center justify-center flex-wrap font-bold relative"
      @click="badClick"
    >
      <bad-voted :badVoted="badVoted"></bad-voted>
      <span :class="{ 'color-blue': badVoted }">{{
        badVoted ? "Bad" : "Bad?"
      }}</span>
      <label
        class="m-1 absolute bg-color-blue font-semibold right-0 rounded-full text-center text-white text-xs top-0 numberIndicator"
        v-if="indicatorNum.nums_bad > 0"
        >{{ indicatorNum.nums_bad }}</label
      >
    </div>
    <!-- bad icon -->

    <div
      class="w-1/5 py-2 rounded-lg hover:bg-gray-300 flex flex-col items-center justify-center flex-wrap font-bold color-blue"
    >
      <svg
        class="w-8 sm:w-12 md:w-10 mx-auto"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
        />
      </svg>
      <span>Share</span>
    </div>
    <!-- Share icon -->

    <div
      class="w-1/5 py-2 rounded-lg hover:bg-gray-300 flex flex-col items-center justify-center flex-wrap font-bold text-black-600 relative"
    >
      <svg
        class="w-8 sm:w-12 md:w-10 mx-auto"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
        />
      </svg>
      <span>Khác</span>
      <div class="shareHolder absolute"></div>
    </div>
    <!-- More icon -->
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
    post_id: Number,
    indicatorNum: Object,
  },
  components: {
    BadVoted,
    GoodVoted,
    BaggedIcon,
  },
  data() {
    return {
      saved: false,
      goodVoted: false,
      badVoted: false,
    };
  },
  methods: {
    ...mapActions(["ReqInteract"]),
    saveClick() {
      this.saved = !this.saved;
      console.log(this.post_id);
      if (this.post_id < 1) {
        return;
      }
      var self = this;
      setTimeout(function () {
        self.ReqInteract({ post_id: self.post_id, interact: "bagged" });
      }, 500);
    },
    goodClick() {
      this.goodVoted = !this.goodVoted;
      var self = this;
      setTimeout(function () {
        self.ReqInteract({ post_id: self.post_id, interact: "good" });
      }, 500);
    },
    badClick() {
      this.badVoted = !this.badVoted;
      var self = this;
      setTimeout(function () {
        self.ReqInteract({ post_id: self.post_id, interact: "bad" });
      }, 500);
    },
  },
};
</script>
