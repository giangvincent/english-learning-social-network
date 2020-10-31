<template>
  <div class="-mt-16"><main-feed :itemArray="uploadedPosts"></main-feed></div>
</template>

<script>
import MainFeed from "@/components/Feed/Main.vue";
import { mapActions, mapState } from "vuex";

export default {
  name: "user-post-created",
  components: {
    MainFeed,
  },
  data() {
    return {
      items: [],
    };
  },
  computed: {
    ...mapState({
      uploadedPosts: (state) => state.user.uploadedPosts,
    }),
  },
  mounted() {
    this.GetUploadedPosts();
  },
  methods: {
    ...mapActions(["GetUploadedPosts"]),
  },
};
</script>
