<template>
    <div>
        <main-feed :itemArray="baggedPosts"></main-feed>
        <infinite-loading ref="infiniteLoading" @infinite="infiniteHandler">
            <template #spinner>Loading...</template>
            <template #no-more>No more message</template>
            <template #no-results>No results message</template>
        </infinite-loading>
    </div>
</template>

<script>
import MainFeed from "../Feed/Main.vue";
import { mapActions, mapMutations, mapState } from "vuex";
import InfiniteLoading from '../Common/InfiniteLoading.vue';

export default {
    name: "user-post-saved",
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
            baggedPosts: state => state.user.baggedPosts,
            currentPage: state => state.currentPage
        })
    },
    mounted() {
        this.setBaggedPosts([]);
        this.SET_PAGE(1);
        this.$nextTick(() => {
            this.$refs.infiniteLoading?.reset();
        });
    },
    methods: {
        ...mapActions(["GetBaggedPosts"]),
        ...mapMutations(["SET_PAGE", "setBaggedPosts"]),
        infiniteHandler($state = { loaded: () => {}, complete: () => {} }) {
            var self = this;
            this.GetBaggedPosts()
                .then(content => {
                    var feedData = self.baggedPosts;
                    feedData.push(...content.data);
                    self.setBaggedPosts(feedData);
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
