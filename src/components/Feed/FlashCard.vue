<template>
  <div
    class="md:mx-2 border-t-2 shadow-xl rounded-lg mb-6 tracking-wide w-full relative bg-white"
  >
    <div class="w-full p-3 font-bold">
      <h2>{{ postData.subject }}</h2>
    </div>
    <CatsAndTags :postData="postData"></CatsAndTags>
    <!-- End relation label -->
    <!-- card indicator -->
    <div
      ref="frontCard"
      :class="{ block: !currentBackCard, hidden: currentBackCard }"
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
      <div class="px-3 pb-4 flex flex-row">
        <input
          placeholder="Nội dung mặt sau"
          type="text"
          class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          v-model="currentAnswer"
          @keydown.enter="reviewBackCard"
        />
        <button
          class="flex-1 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
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
      :class="{ block: currentBackCard, hidden: !currentBackCard }"
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
          class="flex flex-wrap content-center justify-center text-md px-3 py-2 rounded-lg w-full border-2 bg-white border-gray-600 focus:outline-none"
        >
          {{ currentAnswer }}
        </div>
        <button
          class="flex-1 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
          @click="toNextCard()"
        >
          Next
        </button>
      </div>
      <!-- Review back card -->
    </div>
    <!-- Back card -->

    <div
      class=" mb-4 flex cursor-pointer justify-center items-center flex-wrap"
    >
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
      :post_id="postData.id"
      :indicatorNum="interactIndicatorNumber"
    ></interaction-pack>
  </div>
</template>

<script>
import "quill/dist/quill.snow.css";
import { mapState } from "vuex";
// import slideImages from "./SlideImages";
import interactionPack from "./InteractionPack";
import CatsAndTags from "./CatsAndTags";
import Author from "./AuthorPart";
export default {
  name: "Feed-flash-card",
  props: {
    pid: String
  },
  components: {
    interactionPack,
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
        console.log(res);
        self.postData = res[0];
        self.shortTimer = self.evaluateTime(self.postData.datetime);
      })
      .catch(err => console.log(err));
  },
  methods: {
    reviewBackCard() {
      this.currentBackCard = true;
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
