<template>
  <div>
    <main-navigation></main-navigation>
    <side-panel-left></side-panel-left>
    <main-feed :itemArray="currentFeed"></main-feed>
    <to-creator></to-creator>
  </div>
</template>

<script>
// @ is an alias to /src
import { mapState, mapMutations, mapActions } from "vuex";
import MainNavigation from "@/components/MainNavigation.vue";
import SidePanelLeft from "@/components/Navigator/SidePanelLeft.vue";
import MainFeed from "@/components/Feed/Main.vue";
import ToCreator from "@/components/Navigator/ToCreationBtn.vue";

export default {
  name: "home",
  components: {
    MainNavigation,
    MainFeed,
    ToCreator,
    SidePanelLeft
  },
  data() {
    return {
      items: []
    };
  },
  computed: {
    ...mapState(["currentFeed"])
  },
  mounted() {
    this.CHANGE_TAB("home");
    var self = this;
    this.LOAD_HOME();
  },
  methods: {
    ...mapActions(["LOAD_HOME"]),
    ...mapMutations(["CHANGE_TAB"])
  }
};
</script>
