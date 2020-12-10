<template>
  <div
    class="mx-0 border-t-2 shadow-xl rounded-lg mb-6 tracking-wide w-full relative bg-white"
  >
    <div class="w-full p-3 font-bold">
      <h1>{{ postData.subject }}</h1>
    </div>
    <CatsAndTags :postData="postData"></CatsAndTags>
    <!-- End relation label -->
    <!-- card indicator -->
    <div
      ref="frontCard"
      class=" flex flex-col m-2 shadow rounded"
      :class="{
        'flip-in-ver-right block': !currentBackCard,
        hidden: currentBackCard
      }"
    >
      <div class="mx-auto bg-color-black">
        <img
          v-for="(image, imgIndex) in postData.content[currentCardIndex].images"
          :key="`content.images.${imgIndex}`"
          class="w-full"
          :src="rootUrl + image"
        />
      </div>
      <!-- End media -->
      <section>
        <div class="ql-snow" style="height: auto; border: none">
          <div
            class="ql-editor"
            v-html="postData.content[currentCardIndex].contentHtml"
            style="height: auto"
          ></div>
        </div>
      </section>
      <!-- End content text -->
      <div class="px-3 pb-4 flex w-full">
        <input
          placeholder="Nội dung mặt sau"
          type="text"
          class="text-md block px-3 py-2 rounded-lg border-2 border-gray-300 placeholder-gray-600 focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none w-3/4"
          v-model="currentAnswer"
          @keydown.enter="reviewBackCard"
        />
        <button
          class="md:text-lg font-semibold text-white rounded-lg btn-hover gradient-black w-1/4 flex justify-center items-center"
          @click="reviewBackCard()"
        >
          Review
        </button>
      </div>
      <!-- Review back card -->
    </div>
    <!-- front card -->

    <div
      ref="backCard"
      class=" flex flex-col m-2 shadow rounded"
      :class="{
        'flip-in-ver-right block': currentBackCard,
        hidden: !currentBackCard
      }"
    >
      <div class="mx-auto bg-color-black">
        <img
          v-for="(image, imgIndex) in postData.content[currentCardIndex]
            .flipImages"
          :key="`content.images.${imgIndex}`"
          class="w-full"
          :src="rootUrl + image"
        />
      </div>
      <!-- End media -->
      <section>
        <div class="ql-container ql-snow" style="border: none">
          <div
            class="ql-editor"
            v-html="postData.content[currentCardIndex].flipContentHtml"
          ></div>
        </div>
      </section>
      <!-- End content text -->
      <div class="px-3 pb-4 flex flex-row">
        <div
          class="flex flex-wrap content-center justify-center text-md md:text-lg font-semibold py-2 border-gray-600 focus:outline-none rounded-lg border-2 w-3/4"
        >
          {{ currentAnswer }}
        </div>
        <button
          class="md:text-lg font-semibold text-white rounded-lg btn-hover gradient-black w-1/4 flex justify-center items-center"
          @click="toNextCard()"
        >
          Next
        </button>
      </div>
      <!-- Review back card -->
    </div>
    <!-- Back card -->

    <div class="mb-4 flex cursor-pointer justify-center items-center flex-wrap">
      <div
        class="bg-gray-700 border-2 border-white text-white text-center font-bold rounded-full py-1 px-3"
      >
        Card {{ currentCardIndex + 1 }}/{{ postData.content.length }}
      </div>
    </div>

    <author
      :postData="postData"
      :shortTimer="shortTimer"
      detailPostType="flash-card"
      :pid="pid"
    ></author>
    <!-- End author info parts -->
    <interaction-pack
      v-if="
        ($route.name === 'user-page' && !$route.query.cur) ||
          $route.name !== 'user-page'
      "
      :post_id="pid"
      :indicatorNum="interactIndicatorNumber"
      :interactOb="postData.interact"
    ></interaction-pack>

    <process-bar
      v-if="$route.name === 'user-page' && $route.query.cur === 'saved'"
      :post_id="pid"
    ></process-bar>
  </div>
</template>

<script>
import "quill/dist/quill.snow.css";
import { mapActions, mapState } from "vuex";
// import slideImages from "./SlideImages";

import CatsAndTags from "./BaseParts/CatsAndTags";
import Author from "./BaseParts/AuthorPart";
export default {
  name: "Feed-flash-card",
  props: {
    pid: String
  },
  components: {
    ProcessBar: () => import("./BaseParts/ProcessBar"),
    interactionPack: () => import("./BaseParts/InteractionPack"),
    CatsAndTags,
    Author
  },
  data() {
    return {
      shortTimer: "",
      currentCardIndex: 0,
      currentBackCard: false,
      currentAnswer: null,
      postData: {
        id: 0,
        pid: "",
        author: {
          id: 1,
          full_name: "loading",
          nick_name: "loading",
          avatar: ""
        },
        subject: "",
        content: [
          {
            contentHtml: "",
            images: [],
            flipContentHtml: "",
            flipImages: []
          }
        ],
        category: {
          id: 1,
          name: "loading",
          slug: "loading"
        },
        tags: [],
        nums_bagged: 0,
        nums_good: 0,
        nums_bad: 0
      },
      interactIndicatorNumber: {
        nums_bagged: 0,
        nums_good: 0,
        nums_bad: 0
      }
    };
  },
  computed: {
    ...mapState({
      rootUrl: state => state.rootUrl
    })
  },
  watch: {
    postData: {
      handler: function(val) {
        this.interactIndicatorNumber.nums_bagged = this.postData.nums_bagged;
        this.interactIndicatorNumber.nums_good = this.postData.nums_good;
        this.interactIndicatorNumber.nums_bad = this.postData.nums_bad;
      },
      deep: true
    }
  },
  mounted() {
    var self = this;
    fetch("/content/posts/" + this.pid + ".json")
      .then(res => res.json())
      .then(res => {
        // console.log(res);
        self.postData = res[0];
        self.postData.content = self.postData.content.sort(
          () => Math.random() - 0.5
        );
        self.shortTimer = self.evaluateTime(self.postData.datetime);
      })
      .catch(err => console.log(err));
  },
  methods: {
    ...mapActions(["ReqInteract", "FinishPostLearnt"]),
    reviewBackCard() {
      this.currentBackCard = true;
      this.ReqInteract({ post_id: this.pid, interact: "bagged" });
      if (this.currentCardIndex >= this.postData.content.length - 1) {
        this.FinishPostLearnt(this.pid)
          .then(res => {
            console.log("finish learning this post", res);
          })
          .catch(error => console.log(error));
      }
    },
    toNextCard() {
      this.currentBackCard = false;
      this.currentAnswer = null;
      this.currentCardIndex =
        this.currentCardIndex < this.postData.content.length - 1
          ? this.currentCardIndex + 1
          : this.currentCardIndex;
    }
  }
};
</script>
