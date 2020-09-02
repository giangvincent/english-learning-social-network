<template>
  <div class="my-6 md:px-6 lg:px-8 py-20">
    <feed-item v-for="item in items" :key="item"></feed-item>
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
  data() {
    return {
      items: [1, 2, 3],
      Numlist: 10,
    };
  },
};
</script>