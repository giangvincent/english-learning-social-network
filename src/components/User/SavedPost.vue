<template>
  <main-feed :itemArray="baggedPosts"></main-feed>
</template>

<script>
import MainFeed from "@/components/Feed/Main.vue";
import { mapActions, mapState } from "vuex";

export default {
  name: "user-post-saved",
  components: {
    MainFeed
  },
  data() {
    return {
      items: []
    };
  },
  computed: {
    ...mapState({
      baggedPosts: state => state.user.baggedPosts
    })
  },
  mounted() {
    this.GetBaggedPosts();
  },
  methods: {
    ...mapActions(["GetBaggedPosts"])
  }
};
</script>
