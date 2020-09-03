
<template>
  <nav>
    <ul class="md:flex items-center font-bold pt-4 md:pt-0">
      <li class="py-2" :class="{'border-b-2 border-gray-900': currentTab === 'vocabulary'}">
        <a
          class="inline-block no-underline hover:text-black py-2 px-4"
          @click="navigate('vocabulary')"
        >Từ vựng</a>
      </li>
      <li class="py-2" :class="{'border-b-2 border-gray-900': currentTab === 'listen'}">
        <a
          class="inline-block no-underline hover:text-black py-2 px-4"
          @click="navigate('listen')"
        >Nghe</a>
      </li>
      <li class="py-2" :class="{'border-b-2 border-gray-900': currentTab === 'article'}">
        <a
          class="inline-block no-underline hover:text-black py-2 px-4"
          @click="navigate('article')"
        >Bài viết</a>
      </li>
    </ul>
  </nav>
</template>

<script>
import { mapState, mapMutations } from "vuex";

export default {
  computed: {
    ...mapState({
      currentTab: (state) => state.currentTab,
    }),
  },
  methods: {
    ...mapMutations(["CHANGE_TAB"]),
    navigate(goto) {
      this.CHANGE_TAB(goto);
      this.$router.push("/" + goto);
    },
  },
};
</script>