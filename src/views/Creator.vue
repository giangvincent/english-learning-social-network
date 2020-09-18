<template>
  <div>
    <simpleTopNav></simpleTopNav>

    <div class="my-6 md:px-6 lg:px-8 pb-20 mx-auto px-3">
      <div class="mx-auto max-w-lg">
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Danh mục</span>
          <form-select :selectData="categories" @changeSelectData="changeCategory"></form-select>
        </div>
        <!-- pickup category -->
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Loại bài viết</span>
          <div class="sm:rounded shadow">
            <div class="w-full mx-auto flex text-center font-bold">
              <div
                @click="changePostType('article')"
                class="w-1/3 py-3 cursor-pointer"
                :class="{'border-b-2 border-gray-900': postType == 'article'}"
              >Bài viết</div>
              <div
                @click="changePostType('flashCard')"
                class="w-1/3 py-3 cursor-pointer"
                :class="{'border-b-2 border-gray-900': postType == 'flashCard'}"
              >Flash Cards</div>
              <div
                @click="changePostType('quiz')"
                class="w-1/3 py-3 cursor-pointer"
                :class="{'border-b-2 border-gray-900': postType == 'quiz'}"
              >Câu đố</div>
            </div>
            <!-- END topbar lvl1 -->
          </div>
        </div>
        <!-- Choose post type -->

        <article v-if="postType == 'article'"></article>
        <flash-card v-if="postType == 'flashCard'"></flash-card>
        <quiz v-if="postType == 'quiz'"></quiz>

        <tags></tags>

        <button
          class="mt-3 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
          @click="submitContent"
        >
          <svg
            class="text-white w-5 inline"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
            />
          </svg>
          Đăng bài
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import formSelect from "@/components/Form/Select.vue";
import simpleTopNav from "@/components/Navigator/SimpleTopNav.vue";
import tags from "@/components/Creator/Tag.vue";
import Article from "@/components/Creator/Article.vue";
import FlashCard from "@/components/Creator/FlashCard.vue";
import Quiz from "@/components/Creator/Quiz.vue";

export default {
  name: "creator",
  components: {
    simpleTopNav,
    formSelect,
    tags,
    Article,
    FlashCard,
    Quiz,
  },
  data() {
    return {
      postType: "article",
      categories: [
        { title: "Từ vựng", desc: "Thêm cách học từ mới nè", id: 1 },
        { title: "Luyện nghe", desc: "Video hoặc audio để luyện nghe", id: 2 },
        { title: "Ngữ pháp", desc: "Ngữ pháp cũng quan trọng lắm", id: 3 },
      ],
      category: 0,
    };
  },
  mounted() {},
  methods: {
    changePostType(type) {
      this.postType = type;
    },
    changeCategory(index) {
      console.log(index);
      this.category = index;
    },
    submitContent() {
      /* let content = this.editor.root.innerHTML;
      console.log(content); */
    },
  },
  beforeDestroy() {},
};
</script>
