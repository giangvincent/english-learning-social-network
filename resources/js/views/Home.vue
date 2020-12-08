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
import { mapState, mapMutations, mapActions } from "vuex";
import InfiniteLoading from "vue-infinite-loading";
import MainFeed from "../components/Feed/Main.vue";

export default {
    name: "home",
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
        ...mapState(["currentFeed", "currentPage"])
    },
    mounted() {
        this.CHANGE_TAB("home");
        this.SET_CURRENTFEED([]);
        this.SET_PAGE(1);
        // this.LOAD_HOME();
    },
    methods: {
        ...mapActions(["LOAD_HOME"]),
        ...mapMutations(["CHANGE_TAB", "SET_PAGE", "SET_CURRENTFEED"]),
        infiniteHandler($state) {
            var self = this;
            this.LOAD_HOME()
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
