<template>
  <nav>
    <ul class="md:flex items-center font-bold pt-4 md:pt-0 whitespace-no-wrap">
      <li
        class="py-2"
        :class="{ 'border-b-2 border-gray-900': currentTab === cat.slug }"
        v-for="(cat, index) in categories"
        :key="`cat-${index}-${cat.slug}`"
      >
        <a
          class="inline-block no-underline hover:text-black py-2 px-4"
          @click="navigate(cat.slug)"
          >{{ cat.name }}</a
        >
      </li>
    </ul>
  </nav>
</template>

<script>
import { mapState, mapMutations } from "vuex";

export default {
  computed: {
    ...mapState({
      currentTab: state => state.currentTab,
      categories: state => state.categories
    })
  },
  methods: {
    ...mapMutations(["CHANGE_TAB"]),
    navigate(goto) {
      this.CHANGE_TAB(goto);
      this.$router.push("/" + goto);
    }
  }
};
</script>
