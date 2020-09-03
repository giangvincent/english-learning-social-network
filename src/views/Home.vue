<template>
  <div>
    <main-navigation></main-navigation>
    <main-feed :itemArray="items"></main-feed>
  </div>
</template>

<script>
// @ is an alias to /src
import { mapState, mapMutations } from "vuex";
import MainNavigation from "@/components/MainNavigation.vue";
import MainFeed from "@/components/Feed/Main.vue";

export default {
  name: "home",
  components: {
    MainNavigation,
    MainFeed,
  },
  data() {
    return {
      items: [],
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
    ...mapMutations(["CHANGE_TAB"]),
  },
};
</script>
