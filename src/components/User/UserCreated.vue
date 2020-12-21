<template>
  <div>
    <main-feed :itemArray="uploadedPosts"></main-feed>
    <infinite-loading @infinite="infiniteHandler">
      <div slot="spinner">Loading...</div>
      <div slot="no-more">No more message</div>
      <div slot="no-results">No results message</div>
    </infinite-loading>
  </div>
</template>

<script>
import MainFeed from "@/components/Feed/Main.vue";
import { mapActions, mapMutations, mapState } from "vuex";
import InfiniteLoading from "vue-infinite-loading";

export default {
  name: "user-post-created",
  components: {
    MainFeed,
    InfiniteLoading
  },
  data() {
    return {
      userId: 0,
      uploadedPosts: [],
      items: []
    };
  },
  computed: {
    ...mapState({
      currentPage: state => state.currentPage
    })
  },
  mounted() {
    this.userId = this.$route.params.id;
    this.SET_PAGE(1);
  },
  methods: {
    ...mapActions(["GetUploadedPosts"]),
    ...mapMutations(["SET_PAGE", "setUploadedPosts"]),
    infiniteHandler($state) {
      var self = this;
      this.GetUploadedPosts(this.userId)
        .then(content => {
          self.uploadedPosts.push(...content.data);
          self.SET_PAGE(self.currentPage + 1);
          if (content.data.length >= 10) {
            $state.loaded();
          } else {
            $state.complete();
          }
        })
        .catch(e => console.log(e));
    }
  }
};
</script>
