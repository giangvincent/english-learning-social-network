<template>
  <div>
    <main-feed :itemArray="baggedPosts" />
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
  name: 'user-post-saved',
  components: {
    MainFeed,
    InfiniteLoading,
  },
  data() {
    return {
      items: [],
    };
  },
  computed: {
    ...mapState({
      baggedPosts: (state) => state.user.baggedPosts,
      currentPage: (state) => state.currentPage,
    }),
  },
  mounted() {
    this.setBaggedPosts([]);
    this.SET_PAGE(1);
  },
  methods: {
    ...mapActions(['GetBaggedPosts']),
    ...mapMutations(['SET_PAGE', 'setBaggedPosts']),
    infiniteHandler($state) {
      this.GetBaggedPosts()
        .then((content) => {
          const items = Array.isArray(content?.data) ? content.data : [];
          if (items.length > 0) {
            const feedData = [...this.baggedPosts, ...items];
            this.setBaggedPosts(feedData);
            this.SET_PAGE(this.currentPage + 1);
          }
          if (items.length >= 10) {
            $state.loaded();
            return;
          }
          if (items.length > 0) {
            $state.loaded();
          }
          const showNoResults = this.baggedPosts.length === 0;
          $state.complete(showNoResults);
        })
        .catch((e) => {
          console.log(e);
          $state.complete(this.baggedPosts.length === 0);
        });
    },
  },
};
</script>
