<template>
  <div>
    <main-feed :itemArray="uploadedPosts" />
    <InfiniteLoading @infinite="infiniteHandler">
      <template #spinner>Loading...</template>
      <template #no-more>No more message</template>
      <template #no-results>No results message</template>
    </InfiniteLoading>
  </div>
</template>

<script>
import MainFeed from '@/components/Feed/Main.vue';
import { mapActions, mapMutations, mapState } from 'vuex';
import InfiniteLoading from '@/components/common/InfiniteLoading.vue';

export default {
  name: 'user-post-created',
  components: {
    MainFeed,
    InfiniteLoading,
  },
  data() {
    return {
      userId: 0,
      uploadedPosts: [],
      items: [],
    };
  },
  computed: {
    ...mapState({
      currentPage: (state) => state.currentPage,
    }),
  },
  mounted() {
    this.userId = this.$route.params.id;
    this.SET_PAGE(1);
  },
  methods: {
    ...mapActions(['GetUploadedPosts']),
    ...mapMutations(['SET_PAGE', 'setUploadedPosts']),
    infiniteHandler($state) {
      this.GetUploadedPosts(this.userId)
        .then((content) => {
          const items = Array.isArray(content?.data) ? content.data : [];
          if (items.length > 0) {
            this.uploadedPosts.push(...items);
            this.SET_PAGE(this.currentPage + 1);
          }
          if (items.length >= 10) {
            $state.loaded();
            return;
          }
          if (items.length > 0) {
            $state.loaded();
          }
          const showNoResults = this.uploadedPosts.length === 0;
          $state.complete(showNoResults);
        })
        .catch((e) => {
          console.log(e);
          $state.complete(this.uploadedPosts.length === 0);
        });
    },
  },
};
</script>
