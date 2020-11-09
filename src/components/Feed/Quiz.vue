<template>
  <div
    class="md:mx-2 border-t-2 shadow-xl rounded-lg mb-6 tracking-wide w-full bg-white"
  >
    <div class="w-full flex justify-between p-3">
      <div class="flex">
        <router-link
          :to="`/u/${postData.author.id}`"
          class="rounded-full h-8 w-8 flex overflow-hidden"
        >
          <img
            :src="
              postData.author.avatar
                ? postData.author.avatar
                : '/assets/images/default_avatar.jpg'
            "
            alt="profilepic"
          />
        </router-link>
        <router-link
          :to="`/u/${postData.author.id}`"
          class="ml-2 font-bold flex content-center flex-wrap"
        >
          {{ postData.author.full_name }}
        </router-link>
      </div>
      <router-link
        :to="`/p/quiz/${pid}`"
        class="flex text-xs cursor-pointer content-center flex-wrap text-gray-500"
      >
        {{ shortTimer }} trước
      </router-link>
    </div>
    <!-- End author info parts -->

    <div class="px-3 pb-4" v-html="postData.content[0].contentHtml"></div>
    <!-- End content text -->
    <div class="mx-auto bg-color-black mb-4">
      <img
        v-for="(image, imgIndex) in postData.content[0].images"
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
            !postData.content[0].correctAnswers.includes(index) &&
            (!answered || numAnswer !== index),
          'border-black': answered && numAnswer === index,
          'bg-white': !postData.content[0].correctAnswers.includes(index),
          'border-green-800 bg-green-400':
            reviewCorrectAns &&
            postData.content[0].correctAnswers.includes(numAnswer) &&
            numAnswer === index,
          'border-red-700 bg-red-400':
            reviewCorrectAns &&
            !postData.content[0].correctAnswers.includes(numAnswer) &&
            numAnswer !== index
        }"
        v-for="(answer, index) in postData.content[0].answers"
        :key="'answers-' + index"
        @click="pickAnswer(index)"
      >
        <div class="px-2">{{ answer }}</div>
      </div>
    </div>

    <div class="px-3 pb-4">
      <router-link
        :to="`/${postData.category.slug}`"
        class="inline-block rounded-min text-gray-600 bg-gray-100 px-2 py-1 text-xs font-bold mr-3"
        >{{ postData.category.name }}</router-link
      >
      <router-link
        :to="`/tag/${tag.slug}`"
        v-for="(tag, tagIndex) in postData.tags"
        :key="`tag-${tagIndex}`"
        class="inline-block rounded-full text-white bg-color-purple px-2 py-1 text-xs font-bold mr-1"
        >{{ tag.name }}</router-link
      >
    </div>
    <!-- End relation label -->
    <interaction-pack
      :post_id="postData.id"
      :indicatorNum="interactIndicatorNumber"
    ></interaction-pack>
  </div>
</template>

<script>
import { mapState } from "vuex";
import interactionPack from "./InteractionPack";
export default {
  name: "feed-quiz",
  props: {
    pid: String
  },
  components: {
    interactionPack
  },
  data() {
    return {
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
          avatar: ""
        },
        content: [
          {
            contentHtml: "",

            images: [],
            answers: [],
            correctAnswers: []
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
        self.shortTimer = this.evaluateTime(self.postData.datetime);
      })
      .catch(err => console.log(err));
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
    }
  }
};
</script>
