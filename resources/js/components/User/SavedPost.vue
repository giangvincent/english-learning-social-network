<template>
    <div>
        <main-feed :itemArray="baggedPosts"></main-feed>
        <infinite-loading @infinite="infiniteHandler">
            <div slot="spinner">Loading...</div>
            <div slot="no-more">No more message</div>
            <div slot="no-results">No results message</div>
        </infinite-loading>
    </div>
</template>

<script>
import MainFeed from "../Feed/Main.vue";
import { mapActions, mapMutations, mapState } from "vuex";
import InfiniteLoading from "vue-infinite-loading";

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
    },
    methods: {
        ...mapActions(["GetBaggedPosts"]),
        ...mapMutations(["SET_PAGE", "setBaggedPosts"]),
        infiniteHandler($state) {
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
