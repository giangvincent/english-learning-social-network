<template>
  <div
    class="md:mx-2 border-t-2 shadow-xl rounded-lg mb-6 tracking-wide w-full relative bg-white"
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
      <div class="flex cursor-pointer items-center flex-wrap">
        <div
          class="bg-gray-700 border-2 border-white text-white text-center font-bold rounded-full p-1 mx-2"
        >
          Card {{ currentCardIndex + 1 }}/{{ postData.content.length }}
        </div>
        <router-link
          :to="`/p/${pid}`"
          class="flex text-xs cursor-pointer content-center flex-wrap text-gray-500"
        >
          {{ shortTimer }} trước
        </router-link>
      </div>
    </div>
    <!-- End author info parts -->

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
        <div class="ql-container ql-snow" style="height: auto; border: none">
          <div
            class="ql-editor"
            v-html="postData.content[currentCardIndex].contentHtml"
            style="height: auto"
          ></div>
        </div>
      </section>
      <!-- End content text -->
      <div class="px-3 pb-4 flex flex-row">
        <textarea
          placeholder="Nội dung mặt sau"
          type="text"
          class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          v-model="currentAnswer"
          @keydown.enter="reviewBackCard"
        ></textarea>
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
          Next Card
        </button>
      </div>
      <!-- Review back card -->
    </div>
    <!-- Back card -->

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
    <interaction-pack :post_id="postData.id"></interaction-pack>
  </div>
</template>

<script>
import "quill/dist/quill.snow.css";
import { mapState } from "vuex";
// import slideImages from "./SlideImages";
import interactionPack from "./InteractionPack";
export default {
  name: "Feed-flash-card",
  props: {
    pid: String,
  },
  components: {
    interactionPack,
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
          avatar: "",
        },
        content: [
          {
            contentHtml: "",
            images: [],
            flipContentHtml: "",
            flipImages: [],
          },
        ],
        category: {
          id: 1,
          name: "loading",
          slug: "loading",
        },
        tags: [],
      },
    };
  },
  computed: {
    ...mapState({
      rootUrl: (state) => state.rootUrl,
    }),
  },
  mounted() {
    var self = this;
    fetch("/content/posts/" + this.pid + ".json")
      .then((res) => res.json())
      .then((res) => {
        console.log(res);
        self.postData = res[0];
        self.shortTimer = this.evaluateTime(self.postData.datetime);
      })
      .catch((err) => console.log(err));
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
    },
  },
};
</script>
