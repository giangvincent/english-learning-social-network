<template>
  <div class="w-full my-6 md:px-6 lg:px-8 py-20 md:py-10 md:w-6/12 mx-auto">
    <feed-item v-for="item in itemArray" :key="item"></feed-item>
  </div>
  <!-- END Feed grid -->
</template>

<script>
import feedItem from "./ImageItem";
export default {
  name: "feed-template",
  components: {
    feedItem,
  },
  props: {
    itemArray: Array,
  },
  data() {
    return {
      items: [],
      Numlist: 10,
    };
  },
  mouted() {},
};
</script>