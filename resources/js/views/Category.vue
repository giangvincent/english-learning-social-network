<template>
    <div>
        <main-navigation></main-navigation>
        <side-panel-left></side-panel-left>
        <side-panel-right></side-panel-right>
        <div class="py-24 md:py-16">
            <main-feed :itemArray="currentFeed"></main-feed>
            <infinite-loading @infinite="infiniteHandler">
                <div slot="spinner">Loading...</div>
                <div slot="no-more">No more message</div>
                <div slot="no-results">No results message</div>
            </infinite-loading>
        </div>
        <to-creator></to-creator>
    </div>
</template>

<script>
// @ is an alias to /src
import MainFeed from "../components/Feed/Main.vue";
import { mapActions, mapMutations, mapState } from "vuex";
import InfiniteLoading from "vue-infinite-loading";

export default {
    name: "cat-feed",
    components: {
        MainFeed,
        InfiniteLoading
    },
    data() {
        return {
            items: []
        };
    },
    watch: {
        "$route.params.name": function(val, oldVal) {
            console.log(val, oldVal);
            this.SET_CURRENTFEED([]);
            this.SET_PAGE(1);
            this.infiniteHandler();
        }
    },
    computed: {
        ...mapState(["currentFeed", "currentPage"])
    },
    mounted() {
        this.SET_CURRENTFEED([]);
        this.SET_PAGE(1);
    },
    methods: {
        ...mapActions(["LOAD_FEED_CAT"]),
        ...mapMutations(["SET_PAGE", "SET_CURRENTFEED"]),
        infiniteHandler($state) {
            var self = this;
            this.LOAD_FEED_CAT(this.$route.params.name)
                .then(content => {
                    var feedData = self.currentFeed;
                    feedData.push(...content.data);
                    self.SET_CURRENTFEED(feedData);
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
