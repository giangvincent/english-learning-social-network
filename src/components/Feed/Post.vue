<template>
  <div
    class="md:mx-2 border-t-2 shadow-xl rounded-lg mb-6 tracking-wide w-full bg-white"
  >
    <div class="w-full p-3 font-bold">
      <h4>{{ postData.subject }}</h4>
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
      <div class="px-3 py-4" v-html="content.contentHtml"></div>
      <!-- End content text -->
    </div>

    <author
      :postData="postData"
      :shortTimer="shortTimer"
      detailPostType="post"
      :pid="pid"
    ></author>
    <!-- End author info parts -->
    <interaction-pack
      :post_id="postData.id"
      :indicatorNum="interactIndicatorNumber"
    ></interaction-pack>
  </div>
  <!-- END post -->
</template>

<script>
import { mapState } from "vuex";
// import slideImages from "./SlideImages";
import interactionPack from "./InteractionPack";
import CatsAndTags from "./CatsAndTags";
import Author from "./AuthorPart";

export default {
  name: "image-item",
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
    fetch("/content/posts/" + this.pid + ".json")
      .then(res => res.json())
      .then(res => {
        console.log(res);
        self.postData = res[0];
        self.shortTimer = self.evaluateTime(self.postData.datetime);
      })
      .catch(err => console.log(err));
  }
};
</script>
