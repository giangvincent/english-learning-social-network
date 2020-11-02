<template>
  <div>
    <main-navigation></main-navigation>
    <side-panel-left></side-panel-left>
    <side-panel-right></side-panel-right>
    <div class="py-24 md:py-16">
      <main-feed :itemArray="currentFeed"></main-feed>
    </div>
    <to-creator></to-creator>
  </div>
</template>

<script>
// @ is an alias to /src
import MainFeed from "@/components/Feed/Main.vue";
import { mapActions, mapState } from "vuex";

export default {
  name: "tag-feed",
  components: {
    MainFeed
  },
  data() {
    return {
      items: []
    };
  },
  computed: {
    ...mapState(["currentFeed"])
  },
  watch: {
    "$route.params.name": function(val, oldVal) {
      this.LOAD_FEED_TAG(val);
    }
  },
  mounted() {
    this.LOAD_FEED_TAG(this.$route.params.name);
  },
  methods: {
    ...mapActions(["LOAD_FEED_TAG"])
  }
};
</script>
