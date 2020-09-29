<template>
  <div class="w-full my-6 md:px-6 lg:px-8 py-20 md:py-10 md:w-6/12 mx-auto">
    <section v-for="(item, index) in itemArray" :key="'post-' + index">
      <post v-if="item.type == 'normalPost'"></post>
      <flash-card v-if="item.type == 'flashCard'"></flash-card>
      <quiz></quiz>
      <!-- <quiz v-if="item.type == 'quiz'"></quiz> -->
    </section>
  </div>
  <!-- END Feed grid -->
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
