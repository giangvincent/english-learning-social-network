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
import Comment from "@/components/Feed/BaseParts/CommentSection.vue";
import { mapActions } from "vuex";

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
    return {};
  },
  mounted() {
    console.log(this.$route.query);
    if (
      typeof this.$route.query.from !== "undefined" &&
      this.$route.query.from === "notification"
    ) {
      this.SeenNotification(this.$route.params.slug);
    }
  },
  methods: {
    ...mapActions(["SeenNotification"])
  }
};
</script>
