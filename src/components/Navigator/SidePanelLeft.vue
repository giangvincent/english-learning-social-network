<template>
  <div class="md:block">
    <div
      class="bg-black bg-opacity-50 fixed z-40 md:z-30 top-0 bottom-0 left-0 right-0 "
      :class="{ hidden: !showPanelLeft }"
      @click="toggle_left_panel()"
    ></div>
    <!-- shade -->

    <section
      class="bg-white transform md:transform-none ease-in-out transition-all duration-300 translate-x-0 fixed top-0 bottom-0 z-50 md:z-30 w-64 md:w-1/5 lg:w-1/6"
      :class="{ '-translate-x-full': !showPanelLeft }"
    >
      <nav
        class="md:bg-none shadow-2xl md:shadow-none md:pt-16 mb-20 overflow-y-scroll"
        :style="customStyle"
      >
        <div class="py-4 md:py-0 px-1 xl:px-4 min min-h-full">
          <div class="flec">
            <label class="flex mb-4 items-center relative w-full">
              <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="w-4 h-4 absolute text-gray-500 ml-2"
              >
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
              <input
                class="py-2 pr-4 pl-8  w-full bg-gray-300 focus:bg-white focus:border-transparent form-input rounded shadow focus:shadow-none text-gray-900 w-56"
                type="text"
                placeholder="Search..."
              />
            </label>
          </div>
          <ul class="flex flex-col w-full">
            <li
              class="flex font-medium text-sm text-gray-600 px-4 py-2 uppercase border-b-2"
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
      customStyle: "height: calc(100vh - 5rem)"
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
    ...mapMutations(["toggle_left_panel"])
  },
  mounted() {
    // console.log(this.footerHeight);
  }
};
</script>

<style></style>
