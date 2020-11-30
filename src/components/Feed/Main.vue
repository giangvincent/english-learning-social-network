<template>
  <div class="flex">
    <div class="hidden md:block md:w-1/5"></div>
    <div class="w-full md:w-4/5 my-6 md:px-6 lg:px-8  mx-2 md:mx-0">
      <masonry :cols="{ default: 2, 1024: 1 }" :gutter="20">
        <div v-for="(item, index) in itemArray" :key="'post-' + index">
          <post :pid="item.pid" v-if="item.type == 'normalPost'"></post>
          <flash-card
            :pid="item.pid"
            v-if="item.type == 'flashCard'"
          ></flash-card>
          <quiz :pid="item.pid" v-if="item.type == 'quiz'"></quiz>
          <!-- <quiz v-if="item.type == 'quiz'"></quiz> -->
        </div>
      </masonry>
    </div>
    <!-- END Feed grid -->
  </div>
</template>

<script>
import Post from "./Post";
import FlashCard from "./FlashCard";
import Quiz from "./Quiz";
export default {
  name: "feed-template",
  components: {
    Post,
    FlashCard,
    Quiz
  },
  props: {
    itemArray: Array
  },
  data() {
    return {
      items: [],
      Numlist: 10
    };
  },
  mouted() {}
};
</script>
