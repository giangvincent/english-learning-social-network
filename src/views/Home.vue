<template>
  <div>
    <main-navigation></main-navigation>
    <side-panel-left></side-panel-left>
    <side-panel-right></side-panel-right>
    <div class="py-24 md:py-16">
      <main-feed :itemArray="currentFeed" />
      <InfiniteLoading @infinite="infiniteHandler">
        <template #spinner>Loading...</template>
        <template #no-more>No more message</template>
        <template #no-results>No results message</template>
      </InfiniteLoading>
    </div>

    <to-creator></to-creator>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex';
import InfiniteLoading from '@/components/common/InfiniteLoading.vue';
import MainFeed from '@/components/Feed/Main.vue';

export default {
  name: 'home',
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
    ...mapState(['currentFeed', 'currentPage', 'welcomeEnable']),
  },
  mounted() {
    this.CHANGE_TAB('home');
    this.SET_CURRENTFEED([]);
    this.SET_PAGE(1);
  },
  methods: {
    ...mapActions(['LOAD_HOME']),
    ...mapMutations([
      'CHANGE_TAB',
      'SET_PAGE',
      'SET_CURRENTFEED',
      'SET_WELCOME',
    ]),
    infiniteHandler($state) {
      this.LOAD_HOME()
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
