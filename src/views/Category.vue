<template>
  <div>
    <main-navigation></main-navigation>
    <main-feed :itemArray="items"></main-feed>
  </div>
</template>

<script>
// @ is an alias to /src
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
  watch: {
    "$route.params.name": function (val, oldVal) {
      this.resetContent();
    },
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
    },
  },
};
</script>
