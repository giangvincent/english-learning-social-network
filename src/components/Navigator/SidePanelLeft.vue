<template>
  <div class="md:block">
    <div
      class="bg-black bg-opacity-50 fixed z-40 md:z-30 top-0 bottom-0 left-0 right-0 "
      :class="{ hidden: !showPanelLeft }"
      @click="toggle_left_panel()"
    ></div>
    <!-- shade -->

    <section
      class="bg-white transform md:transform-none ease-in-out transition-all duration-300 translate-x-0  fixed top-0 bottom-0 z-50 md:z-30 w-64 md:w-1/5 lg:w-1/6 -translate-x-full"
      :class="{ '-translate-x-full': !showPanelLeft }"
    >
      <nav
        class="md:bg-none shadow-2xl md:shadow-none md:pt-16 mb-20 overflow-y-scroll"
        style="height: calc(100vh - 5rem)"
      >
        <div class="py-4 md:py-0 px-1 xl:px-4 min min-h-full">
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
      <footer-component></footer-component>
    </section>
  </div>
  <!-- Slide panel left -->
</template>

<script>
import TagRoute from "@/components/Navigator/TagRoute.vue";
import FooterComponent from "@/components/Footer.vue";
import { mapMutations, mapState } from "vuex";

export default {
  name: "side-panel-left",
  data() {
    return {};
  },
  components: {
    TagRoute,
    FooterComponent
  },
  computed: {
    ...mapState(["showPanelLeft", "tags"])
  },
  methods: {
    ...mapMutations(["toggle_left_panel"])
  }
};
</script>

<style></style>
