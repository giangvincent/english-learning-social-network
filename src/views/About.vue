<template>
  <div>
    <simpleTopNav></simpleTopNav>
    <div class="my-6 md:px-6 lg:px-8 pb-20 mx-auto px-3">
      <div class="mx-auto max-w-lg">
        <component v-bind:is="asyncComponent" :page="$route.params.page">
          <!-- component changes when vm.currentView changes! -->
        </component>
      </div>
    </div>
  </div>
</template>

<script>
import simpleTopNav from "@/components/Navigator/SimpleTopNav.vue";
export default {
  name: "otherpage",
  components: {
    simpleTopNav,
    Faqs: () => import("@/components/Others/faqs.vue"),
    Contact: () => import("@/components/Others/Contact.vue"),
    BuyCoffee: () => import("@/components/Others/BuyCoffeePage.vue"),
    StaticContent: () => import("@/components/Others/StaticContent.vue")
  },
  data() {
    return {
      asyncComponent: "StaticContent"
    };
  },
  mounted() {
    if (this.$route.params.page === "contact") {
      this.asyncComponent = "Contact";
    } else if (this.$route.params.page === "faqs") {
      this.asyncComponent = "faqs";
    } else if (this.$route.params.page === "buy-coffee") {
      this.asyncComponent = "BuyCoffee";
    } else {
      this.asyncComponent = "StaticContent";
    }
  }
};
</script>
