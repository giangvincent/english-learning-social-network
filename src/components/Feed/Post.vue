<template>
  <div
    class="mx-0 border-t-2 shadow-xl rounded-lg mb-6 tracking-wide w-full bg-white"
    v-if="enable"
  >
    <div class="w-full p-3 font-bold">
      <h1>{{ postData.subject }}</h1>
    </div>
    <CatsAndTags :postData="postData"></CatsAndTags>
    <!-- End relation label -->

    <div
      v-for="(content, index) in postData.content"
      :key="`PostData-${index}`"
    >
      <div class="mx-auto bg-color-black">
        <img
          v-for="(image, imgIndex) in content.images"
          :key="`content.images.${imgIndex}`"
          class="w-full"
          :src="rootUrl + image"
        />
      </div>
      <!-- End media -->
      <section>
        <div class="ql-snow" style="height: auto; border: none">
          <div class="ql-editor" style="height: auto">
            <read-more
              more-str="Đọc hết"
              :text="content.contentHtml"
              link="#"
              less-str="Che đi"
              :max-chars="700"
            ></read-more>
          </div>
        </div>
      </section>

      <!-- End content text -->
    </div>
    <button
      class="font-semibold text-white rounded-lg w-1/4 flex justify-center items-center py-1 mx-auto bg-gray-600 hover:bg-gray-800"
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
            images: [""]
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
    fetch(this.rootUrl + "get-json/post/" + this.pid)
      .then(res => res.json())
      .then(res => {
        if (typeof res[0] !== "undefined") {
          self.postData = res[0];
          self.shortTimer = self.evaluateTime(self.postData.datetime);
        } else self.enable = false;
      })
      .catch(err => {
        console.log(err);
        self.enable = false;
      });
  },
  methods: {
    ...mapActions(["FinishPostLearnt"]),
    checkLearnt() {
      let self = this;
      this.FinishPostLearnt(this.pid)
        .then(res => {
          console.log("finish learning this post", res);
          self.$toast.info("Thanks for learnt.");
        })
        .catch(error => console.log(error));
    }
  }
};
</script>
