<template>
  <div>
    <main-navigation></main-navigation>
    <side-panel-left></side-panel-left>
    <side-panel-right></side-panel-right>
    <main-feed :itemArray="items"></main-feed>
    <to-creator></to-creator>
  </div>
</template>

<script>
// @ is an alias to /src
import MainFeed from "@/components/Feed/Main.vue";

export default {
  name: "cat-feed",
  components: {
    MainFeed
  },
  data() {
    return {
      items: []
    };
  },
  watch: {
    "$route.params.name": function(val, oldVal) {
      this.resetContent();
    }
  },
  mounted() {
    this.resetContent();
  },
  methods: {
    resetContent() {
      var self = this;
      this.$set(this, "items", []);
      setTimeout(() => {
        var rand = Math.floor(Math.random() * 20 + 1);
        console.log(rand);
        for (let i = 0; i < rand; i++) {
          self.items.push(i);
        }
      }, 500);
    }
  }
};
</script>
