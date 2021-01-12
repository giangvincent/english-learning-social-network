<template>
  <div
    class="mx-0 border-t-2 shadow-xl rounded-lg mb-10 tracking-wide w-full bg-white"
    v-if="enable"
  >
    <div class="w-full p-3 font-bold">
      <h1>{{ postData.subject }}</h1>
    </div>
    <CatsAndTags :postData="postData"></CatsAndTags>
    <!-- End relation label -->
    <div :class="{ 'max-post-view': readmore }">
      <div
        v-for="(content, index) in postData.content"
        :key="`PostData-${index}`"
      >
        <div
          class="mx-auto bg-color-black"
          v-for="(image, imgIndex) in content.images"
          :key="`content.images.${imgIndex}`"
        >
          <img v-if="image !== ''" class="w-full" :src="image" />
        </div>
        <!-- End media -->
        <section>
          <div class="ql-snow" style="height: auto; border: none">
            <div
              class="ql-editor"
              style="height: auto"
              v-html="content.contentHtml"
            ></div>
          </div>
          <button
            v-if="
              typeof content.audios !== 'undefined' &&
                typeof content.audios[0] !== 'undefined' &&
                content.audios[0] !== ''
            "
            class="p-1 ml-3 mb-2 flex items-center rounded-lg border-2 hover:border-gray-600 py-2 border-gray-300 bg-white"
            @click="playAudio(content.audios[0])"
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
      </div>
    </div>
    <span
      class="px-3 text-blue-600 underline"
      v-if="readmore"
      @click="readmore = false"
      >... Show more</span
    >
    <span
      class="px-3 text-blue-600 underline"
      v-if="!readmore && numberString > 400"
      @click="readmore = true"
      >Show less</span
    >
    <button
      class="font-semibold text-white rounded-lg w-1/4 flex justify-center items-center py-1 my-1 mx-auto bg-gray-600 hover:bg-gray-800"
      v-if="this.user.id"
      @click="checkLearnt()"
    >
      Đã đọc hết
    </button>
    <author
      :postData="postData"
      :shortTimer="shortTimer"
      detailPostType="post"
      :pid="pid"
    ></author>
    <!-- End author info parts -->
    <interaction-pack
      v-if="
        ($route.name === 'user-page' && !$route.query.cur) ||
          $route.name !== 'user-page'
      "
      :post_id="pid"
      detailPostType="post"
      :author="postData.author"
      :indicatorNum="interactIndicatorNumber"
      :interactOb="postData.interact"
    ></interaction-pack>

    <process-bar
      v-if="$route.name === 'user-page' && $route.query.cur === 'saved'"
      :post_id="pid"
    ></process-bar>
  </div>
  <!-- END post -->
</template>

<script>
import { Howl, Howler } from "howler";
import { mapActions, mapState } from "vuex";
// import slideImages from "./SlideImages";
import interactionPack from "./BaseParts/InteractionPack";
import ProcessBar from "./BaseParts/ProcessBar";
import CatsAndTags from "./BaseParts/CatsAndTags";
import Author from "./BaseParts/AuthorPart";

export default {
  name: "image-item",
  props: {
    pid: String
  },
  components: {
    ProcessBar,
    interactionPack,
    CatsAndTags,
    Author
  },
  data() {
    return {
      readmore: false,
      numberString: 0,
      enable: true,
      shortTimer: "",
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
            contentHtml: "<p>loading...</p>",
            images: []
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
      rootUrl: state => state.rootUrl,
      user: state => state.user.user
    })
  },
  watch: {
    postData: {
      handler: function(val) {
        this.interactIndicatorNumber.nums_bagged =
          this.postData.nums_bagged !== null ? this.postData.nums_bagged : 0;
        this.interactIndicatorNumber.nums_good =
          this.postData.nums_good !== null ? this.postData.nums_good : 0;
        this.interactIndicatorNumber.nums_bad =
          this.postData.nums_bad !== null ? this.postData.nums_bad : 0;
      },
      deep: true
    }
  },
  mounted() {
    var self = this;
    fetch("/content/posts/" + this.pid + ".json")
      .then(res => res.json())
      .then(res => {
        if (typeof res[0] !== "undefined") {
          self.postData = res[0];
          self.shortTimer = self.evaluateTime(self.postData.datetime);
          self.checkReadmore();
        } else self.enable = false;
      })
      .catch(err => {
        console.log(err);
        self.enable = false;
      });
  },
  methods: {
    ...mapActions(["FinishPostLearnt"]),
    checkReadmore() {
      this.postData.content.forEach(content => {
        this.numberString += content.contentHtml.length;
      });

      if (this.numberString > 400) this.readmore = true;
    },
    checkLearnt() {
      let self = this;
      this.FinishPostLearnt(this.pid)
        .then(res => {
          console.log("finish learning this post", res);
          self.$toast.info("Thanks for learnt.");
        })
        .catch(error => console.log(error));
    },
    playAudio(text) {
      var sound = new Howl({
        src:
          "/content/audios/" +
          text
            .toLowerCase()
            .replace(/[^\w ]+/g, "")
            .replace(/ +/g, "-") +
          ".mp3",
        format: ["mp3"],
        html5: true
      });
      sound.play();
    }
  }
};
</script>

<style>
.max-post-view {
  max-height: 15rem;
  overflow: hidden;
}
</style>
