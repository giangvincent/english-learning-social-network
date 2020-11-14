<template>
  <div
    class="md:mx-2 border-t-2 shadow-xl rounded-lg mb-6 tracking-wide w-full bg-white"
  >
    <div class="w-full p-3 font-bold">
      <h4>{{ postData.subject }}</h4>
    </div>
    <CatsAndTags :postData="postData"></CatsAndTags>
    <div ref="quizContent" class="flex flex-col m-2 shadow rounded">
      <section>
        <div class="ql-snow" style="height: auto; border: none">
          <div
            class="ql-editor"
            v-html="postData.content[currentQuizIndex].contentHtml"
            style="height: auto"
          ></div>
        </div>
      </section>

      <!-- End content text -->
      <div class="mx-auto bg-color-black mb-4">
        <img
          v-for="(image, imgIndex) in postData.content[currentQuizIndex].images"
          :key="`content.images.${imgIndex}`"
          class="w-full"
          :src="rootUrl + image"
        />
      </div>
      <!-- End media -->

      <div class="py-3 text-sm">
        <span class="px-2">Các đáp án là :</span>
        <div
          class="flex justify-start cursor-pointer text-md rounded-lg border-2 hover:border-gray-600 py-2 m-2"
          :class="{
            'border-gray-300':
              !postData.content[currentQuizIndex].correctAnswers.includes(
                index
              ) &&
              (!answered || numAnswer !== index),
            'border-black': answered && numAnswer === index,
            'bg-white': !postData.content[
              currentQuizIndex
            ].correctAnswers.includes(index),
            'border-green-800 bg-green-400':
              reviewCorrectAns &&
              postData.content[currentQuizIndex].correctAnswers.includes(
                numAnswer
              ) &&
              numAnswer === index,
            'border-red-700 bg-red-400':
              reviewCorrectAns &&
              !postData.content[currentQuizIndex].correctAnswers.includes(
                numAnswer
              ) &&
              numAnswer !== index,
          }"
          v-for="(answer, index) in postData.content[currentQuizIndex].answers"
          :key="'answers-' + index"
          @click="pickAnswer(index)"
        >
          <div class="px-2">{{ answer }}</div>
        </div>
      </div>
    </div>

    <div class="mb-4 flex cursor-pointer justify-center items-center flex-wrap">
      <div
        class="bg-gray-700 border-2 border-white text-white text-center font-bold rounded-full py-1 px-3"
      >
        Quiz {{ currentQuizIndex + 1 }}/{{ postData.content.length }}
      </div>
      <button
        class="md:text-lg font-semibold text-white rounded-lg btn-hover gradient-black w-1/4 flex justify-center items-center py-1"
        @click="toNextQuiz()"
        v-show="reviewCorrectAns"
      >
        Next
      </button>
    </div>

    <author
      :postData="postData"
      :shortTimer="shortTimer"
      detailPostType="quiz"
      :pid="pid"
    ></author>
    <!-- End author info parts -->
    <interaction-pack
      v-if="$route.name !== 'user-page' && $route.query.cur !== 'saved'"
      :post_id="postData.id"
      :indicatorNum="interactIndicatorNumber"
    ></interaction-pack>

    <process-bar
      v-if="$route.name === 'user-page' && $route.query.cur === 'saved'"
      :post_id="postData.id"
    ></process-bar>
  </div>
</template>

<script>
import { mapState } from "vuex";
import interactionPack from "./InteractionPack";
import ProcessBar from "./ProcessBar";
import CatsAndTags from "./CatsAndTags";
import Author from "./AuthorPart";
export default {
  name: "feed-quiz",
  props: {
    pid: String,
  },
  components: {
    ProcessBar,
    interactionPack,
    CatsAndTags,
    Author,
  },
  data() {
    return {
      currentQuizIndex: 0,
      reviewCorrectAns: false,
      answered: false,
      numAnswer: null,
      shortTimer: "",
      postData: {
        id: 0,
        author: {
          id: 1,
          full_name: "loading",
          nick_name: "loading",
          avatar: "",
        },
        subject: "",
        content: [
          {
            contentHtml: "",
            contentOrigin: { ops: [] },
            images: [],
            answers: [],
            correctAnswers: [],
          },
        ],
        category: {
          id: 1,
          name: "loading",
          slug: "loading",
        },
        tags: [],
        nums_bagged: 0,
        nums_good: 0,
        nums_bad: 0,
      },
      interactIndicatorNumber: {
        nums_bagged: 0,
        nums_good: 0,
        nums_bad: 0,
      },
    };
  },
  computed: {
    ...mapState({
      rootUrl: (state) => state.rootUrl,
    }),
  },
  watch: {
    postData: {
      handler: function (val) {
        this.interactIndicatorNumber.nums_bagged = this.postData.nums_bagged;
        this.interactIndicatorNumber.nums_good = this.postData.nums_good;
        this.interactIndicatorNumber.nums_bad = this.postData.nums_bad;
      },
      deep: true,
    },
  },
  mounted() {
    var self = this;
    fetch("/content/posts/" + this.pid + ".json")
      .then((res) => res.json())
      .then((res) => {
        console.log(res);
        self.postData = res[0];
        self.postData.content = self.postData.content.sort(
          () => Math.random() - 0.5
        );
        self.shortTimer = self.evaluateTime(self.postData.datetime);
      })
      .catch((err) => console.log(err));
  },
  methods: {
    pickAnswer(index) {
      if (!this.answered) {
        this.answered = true;
        this.numAnswer = index;
        var self = this;
        setTimeout(() => {
          self.reviewCorrectAns = true;
        }, 1000);
      }
    },
    toNextQuiz() {
      this.reviewCorrectAns = false;
      this.answered = false;
      this.numAnswer = null;
      this.currentQuizIndex =
        this.currentQuizIndex < this.postData.content.length - 1
          ? this.currentQuizIndex + 1
          : this.currentQuizIndex;
    },
  },
};
</script>
