<template>
  <div>
    <main-navigation></main-navigation>
    <side-panel-left></side-panel-left>
    <side-panel-right></side-panel-right>
    <div class="py-24 md:py-16">
      <main-feed :itemArray="currentFeed" />
      <InfiniteLoading ref="infiniteLoading" @infinite="infiniteHandler">
        <template #spinner>Loading...</template>
        <template #no-more>No more message</template>
        <template #no-results>No results message</template>
      </InfiniteLoading>
    </div>
    <to-creator></to-creator>
  </div>
</template>

<script>
import MainFeed from '@/components/Feed/Main.vue';
import { mapActions, mapMutations, mapState } from 'vuex';
import InfiniteLoading from '@/components/common/InfiniteLoading.vue';

export default {
  name: 'tag-feed',
  components: {
    MainFeed,
    InfiniteLoading,
  },
  watch: {
    '$route.params.name'() {
      this.SET_CURRENTFEED([]);
      this.SET_PAGE(1);
      this.$nextTick(() => {
        this.$refs.infiniteLoading?.reset();
      });
    },
  },
  computed: {
    ...mapState(['currentFeed', 'currentPage']),
  },
  mounted() {
    this.SET_CURRENTFEED([]);
    this.SET_PAGE(1);
  },
  methods: {
    ...mapActions(['LOAD_FEED_TAG']),
    ...mapMutations(['SET_PAGE', 'SET_CURRENTFEED']),
    infiniteHandler($state) {
      this.LOAD_FEED_TAG(this.$route.params.name)
        .then((content) => {
          const items = Array.isArray(content) ? content : [];
          if (items.length > 0) {
            const feedData = [...this.currentFeed, ...items];
            this.SET_CURRENTFEED(feedData);
            this.SET_PAGE(this.currentPage + 1);
          }
          if (items.length >= 10) {
            $state.loaded();
            return;
          }
          if (items.length > 0) {
            $state.loaded();
          }
          const showNoResults = this.currentFeed.length === 0;
          $state.complete(showNoResults);
        })
        .catch((e) => {
          console.log(e);
          $state.complete(this.currentFeed.length === 0);
        });
    },
  },
};
</script>
