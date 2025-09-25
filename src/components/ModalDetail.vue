<template>
  <div>
    <simpleTopNav></simpleTopNav>
    <post v-if="item.type == 'normalPost'"></post>
    <flash-card></flash-card>
    <quiz v-if="item.type == 'quiz'"></quiz>
  </div>
</template>

<script>
import simpleTopNav from "@/components/Navigator/SimpleTopNav.vue";
import Post from "./Post.vue";
import FlashCard from "./FlashCard.vue";
import Quiz from "./Quiz.vue";

export default {
  name: "detail content",
  components: {
    simpleTopNav,
    Post,
    FlashCard,
    Quiz
  },
  data() {
    return {};
  }
};
</script>
