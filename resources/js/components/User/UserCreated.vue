<template>
    <div>
        <main-feed :itemArray="uploadedPosts"></main-feed>
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
        this.$nextTick(() => {
            this.$refs.infiniteLoading?.reset();
        });
    },
    methods: {
        ...mapActions(["GetUploadedPosts"]),
        ...mapMutations(["SET_PAGE", "setUploadedPosts"]),
        infiniteHandler($state = { loaded: () => {}, complete: () => {} }) {
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
