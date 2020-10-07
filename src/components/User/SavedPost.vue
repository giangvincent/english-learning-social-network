<template>
  <div class="-mt-16"><main-feed :itemArray="items"></main-feed></div>
</template>

<script>
import MainFeed from "@/components/Feed/Main.vue";

export default {
  name: "user-post-saved",
  components: {
    MainFeed
  },
  data() {
    return {
      items: []
    };
  },
  mounted() {
    var self = this;
    setTimeout(() => {
      var rand = Math.floor(Math.random() * 10 + 1);
      console.log(rand);
      for (let i = 0; i < rand; i++) {
        self.items.push(i);
      }
    }, 500);
  }
};
</script>
