<template>
  <div
    class="mx-0 border-t-2 shadow-xl rounded-lg mb-6 tracking-wide w-full relative bg-white overflow-hidden"
    v-if="enable"
  >
    <div class="w-full p-3 font-bold">
      <h1>{{ postData.subject }}</h1>
    </div>
    <CatsAndTags :postData="postData"></CatsAndTags>
    <!-- End relation label -->
    <!-- card indicator -->
    <div
      ref="frontCard"
      class="flex flex-col m-2 shadow rounded"
      :class="{
        'slide-in-right block': !currentBackCard,
        hidden: currentBackCard
      }"
    >
      <div
        class="mx-auto bg-color-black"
        v-for="(image, imgIndex) in postData.content[currentCardIndex].images"
        :key="`content.images.${imgIndex}`"
      >
        <img v-if="image !== ''" class="w-full" :src="rootUrl + image" />
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
        <button
          v-if="
            typeof postData.audios !== 'undefined' &&
              typeof postData.audios[0] !== 'undefined' &&
              postData.audios[0] !== ''
          "
          class="p-1 ml-3 mb-2 flex items-center rounded-lg border-2 hover:border-gray-600 py-2 border-gray-300 bg-white"
          @click="playAudio(postData.audios[0])"
        >
          <svg
            class="w-8"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z"
              clip-rule="evenodd"
            />
          </svg>
          <div class="px-1 text-black font-bold text-normal">
            Nghe Audio
          </div>
        </button>
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
      class="flex flex-col m-2 shadow rounded"
      :class="{
        'flip-in-ver-right block': currentBackCard,
        hidden: !currentBackCard
      }"
    >
      <div
        class="mx-auto bg-color-black"
        v-for="(image, imgIndex) in postData.content[currentCardIndex]
          .flipImages"
        :key="`content.images.${imgIndex}`"
      >
        <img v-if="image !== ''" class="w-full" :src="rootUrl + image" />
      </div>
      <!-- End media -->
      <section>
        <div class="ql-container ql-snow" style="height: auto; border: none">
          <div
            class="ql-editor"
            v-html="postData.content[currentCardIndex].flipContentHtml"
            style="height: auto;"
          ></div>
        </div>
        <button
          v-if="
            typeof postData.flipAudios !== 'undefined' &&
              typeof postData.flipAudios[0] !== 'undefined' &&
              postData.flipAudios[0] !== ''
          "
          class="p-1 ml-3 mb-2 flex items-center rounded-lg border-2 hover:border-gray-600 py-2 border-gray-300 bg-white"
          @click="playAudio(postData.flipAudios[0])"
        >
          <svg
            class="w-8"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z"
              clip-rule="evenodd"
            />
          </svg>
          <div class="px-1 text-black font-bold text-normal">
            Nghe Audio
          </div>
        </button>
      </section>
      <!-- End content text -->
      <div class="px-3 pb-4 flex flex-row" v-if="!resetEnable">
        <div
          class="flex flex-wrap content-center justify-center text-md md:text-lg font-semibold py-2 border-gray-600 focus:outline-none rounded-lg border-2 w-3/4 min-h-1"
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
      <div class="px-3 pb-4 flex flex-row" v-if="resetEnable">
        <button
          class="md:text-lg font-semibold text-white rounded-lg btn-hover gradient-black w-1/4 flex justify-center items-center min-h-1 mx-auto"
          @click="resetLearning()"
        >
          Học lại
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
      detailPostType="flash-card"
      :author="postData.author"
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
import { Howl, Howler } from "howler";
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
      enable: true,
      shortTimer: "",
      currentCardIndex: 0,
      currentBackCard: false,
      currentAnswer: null,
      resetEnable: false,
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
        if (typeof res[0] !== "undefined") {
          self.postData = res[0];
          self.postData.content = self.postData.content.sort(
            () => Math.random() - 0.5
          );
          self.shortTimer = self.evaluateTime(self.postData.datetime);
        } else self.enable = false;
      })
      .catch(err => {
        console.log(err);
        self.enable = false;
      });
  },
  methods: {
    ...mapActions(["ReqInteract", "FinishPostLearnt"]),
    reviewBackCard() {
      this.currentBackCard = true;
      let self = this;
      if (this.currentCardIndex >= this.postData.content.length - 1) {
        this.resetEnable = true;
        this.FinishPostLearnt(this.pid)
          .then(res => {
            console.log("finish learning this post", res);
            self.$toast.info("Thanks for learnt.");
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
    },
    resetLearning() {
      this.resetEnable = false;
      this.postData.content = this.postData.content.sort(
        () => Math.random() - 0.5
      );
      this.currentCardIndex = 0;
      this.currentBackCard = false;
      this.currentAnswer = null;
    },
    playAudio(file_path) {
      var sound = new Howl({
        src: this.rootUrl + file_path,
        format: ["mp3"],
        html5: true
      });
      sound.play();
    }
  }
};
</script>
