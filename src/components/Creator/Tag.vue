<template>
  <div class="py-1">
    <span class="px-1  text-gray-600">Gắn Tag</span>
    <input
      placeholder="Tên của Tag"
      type="text"
      class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
      v-model="curTag"
      v-on:keyup.enter="createHashtag()"
    />
    <div class="py-3">
      <span
        v-for="(tag, index) in tags"
        :key="'tag-' + index"
        class="bg-color-purple font-bold inline-block m-1 pr-8 px-2 py-1 relative rounded-full text-white text-xs"
      >
        #{{ tag }}
        <svg
          @click="removeTag(index)"
          class="absolute inline text-white w-5 cursor-pointer"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          style="top: 3px; right: 1px"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
      </span>
    </div>
  </div>
  <!-- Ending Tag -->
</template>

<script>
export default {
  name: "tags",
  props: {
    tags: Array
  },
  data() {
    return {
      curTag: ""
    };
  },
  mounted() {},
  methods: {
    removeTag(index) {
      this.tags.splice(index, 1);
      this.$emit("updateTags", this.tags);
    },
    createHashtag() {
      if (this.curTag !== "") {
        this.curTag = this.curTag.replace(/\s+/g, " ");
        this.curTag = this.curTag.toLowerCase().trim();

        this.tags.push(this.curTag);
        this.curTag = "";
        this.$emit("updateTags", this.tags);
      }
    }
  }
};
</script>
