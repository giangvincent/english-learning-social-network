<template>
  <div class="md:block">
    <div
      class="fixed top-0 bottom-0 left-0 right-0 z-40 bg-black bg-opacity-50 md:z-30 "
      :class="{ hidden: !showPanelLeft }"
      @click="toggle_left_panel()"
    ></div>
    <!-- shade -->

    <section
      class="fixed top-0 bottom-0 z-50 w-64 transition-all duration-300 ease-in-out transform bg-white md:transform-none md:z-30 md:w-1/5 lg:w-1/6"
      :class="{ '-translate-x-full': !showPanelLeft, 'translate-x-0': showPanelLeft }"
    >
      <nav
        class="mb-20 overflow-y-scroll shadow-2xl md:bg-none md:shadow-none md:pt-16"
        :style="customStyle"
      >
        <div class="min-h-full px-1 py-4 md:py-0 xl:px-4 min">
          <div class="flec">
            <label class="relative flex items-center w-full mb-4">
              <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="absolute w-4 h-4 ml-2 text-gray-500"
              >
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
              <input
                class="w-56 w-full py-2 pl-8 pr-4 text-gray-900 bg-gray-300 rounded shadow focus:bg-white focus:border-transparent form-input focus:shadow-none"
                type="text"
                placeholder="Tìm kiếm..."
                ref="search"
                v-model="searchText"
                v-on:keyup.enter="search"
              />
            </label>
          </div>
          <ul class="flex flex-col w-full">
            <li
              class="flex px-4 py-2 text-sm font-medium text-gray-600 uppercase border-b-2"
            >
              Tags
            </li>
            <li
              class="my-px"
              v-for="(tag, index) in tags"
              :key="`tag-${index}_${tag.slug}`"
            >
              <tag-route
                :text="tag.name"
                :router="`/tag/${tag.slug}`"
                :numPost="tag.posts"
              ></tag-route>
            </li>
          </ul>
        </div>
      </nav>
      <footer-info @getHeight="footerHeight = $event"></footer-info>
    </section>
  </div>
  <!-- Slide panel left -->
</template>

<script>
import TagRoute from "@/components/Navigator/TagRoute.vue";
import FooterInfo from "@/components/FooterInfo.vue";
import { mapMutations, mapState } from "vuex";

export default {
  name: "side-panel-left",
  data() {
    return {
      footerHeight: 0,
      customStyle: "height: calc(100vh - 5rem)",
      searchText: ""
    };
  },
  components: {
    TagRoute,
    FooterInfo
  },
  computed: {
    ...mapState(["showPanelLeft", "tags"])
  },
  watch: {
    footerHeight: function(val) {
      this.customStyle = "height: calc(100vh - " + (val + 50) + "px)";
    }
  },
  methods: {
    ...mapMutations(["toggle_left_panel"]),
    search() {
      this.$router.push("/s/" + encodeURIComponent(this.searchText));
    }
  },
  mounted() {
    // console.log(this.footerHeight);
  }
};
</script>

<style></style>
