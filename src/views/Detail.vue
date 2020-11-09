<template>
  <div>
    <simpleTopNav></simpleTopNav>
    <div class="my-6 md:px-6 lg:px-8 pb-20 mx-auto px-3">
      <div class="mx-auto max-w-lg">
        <post
          :pid="$route.params.slug"
          v-if="$route.params.type == 'post'"
        ></post>
        <flash-card
          :pid="$route.params.slug"
          v-if="$route.params.type == 'flash-card'"
        ></flash-card>
        <quiz
          :pid="$route.params.slug"
          v-if="$route.params.type == 'quiz'"
        ></quiz>
        <comment></comment>
      </div>
    </div>
  </div>
</template>

<script>
import simpleTopNav from "@/components/Navigator/SimpleTopNav.vue";
import Post from "@/components/Feed/Post.vue";
import FlashCard from "@/components/Feed/FlashCard.vue";
import Quiz from "@/components/Feed/Quiz.vue";
import Comment from "@/components/Feed/CommentSection.vue";

export default {
  name: "detail-page",
  components: {
    simpleTopNav,
    Post,
    FlashCard,
    Quiz,
    Comment
  },
  data() {
    return {
      item: {
        type: "flashCard"
      }
    };
  }
};
</script>
