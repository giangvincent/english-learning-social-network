<template>
  <div>
    <main-navigation></main-navigation>
    <main-feed></main-feed>
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
};
</script>
