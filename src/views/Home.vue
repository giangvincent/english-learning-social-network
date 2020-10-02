<template>
  <div>
    <main-navigation></main-navigation>
    <side-panel-left></side-panel-left>
    <main-feed :itemArray="items"></main-feed>
    <to-creator></to-creator>
  </div>
</template>

<script>
// @ is an alias to /src
import { mapState, mapMutations } from "vuex";
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
  mounted() {
    this.CHANGE_TAB("home");
    var self = this;
    setTimeout(() => {
      var rand = Math.floor(Math.random() * 10);
      console.log(rand);
      for (let i = 0; i < rand; i++) {
        self.items.push(i);
      }
    }, 500);
  },
  methods: {
    ...mapMutations(["CHANGE_TAB"])
  }
};
</script>
