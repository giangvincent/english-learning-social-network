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
      items: []
    };
  },
  computed: {
    ...mapState({
      uploadedPosts: state => state.user.uploadedPosts,
      currentPage: state => state.currentPage
    })
  },
  mounted() {
    this.setUploadedPosts([]);
    this.SET_PAGE(1);
  },
  methods: {
    ...mapActions(["GetUploadedPosts"]),
    ...mapMutations(["SET_PAGE", "setUploadedPosts"]),
    infiniteHandler($state) {
      var self = this;
      this.GetUploadedPosts()
        .then(content => {
          var feedData = self.uploadedPosts;
          feedData.push(...content.data);
          self.setUploadedPosts(feedData);
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
