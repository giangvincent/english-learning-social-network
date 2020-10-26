<template>
  <div class="hidden md:block">
    <div
      class="bg-black bg-opacity-50 fixed z-30 top-0 bottom-0 left-0 right-0 md:hidden"
    ></div>
    <!-- shade -->
    <section
      class="bg-white transform md:transform-none ease-in-out transition-all duration-300 translate-x-0 -translate-x-full fixed top-0 bottom-0 z-30 w-64 md:w-1/5 lg:w-1/6 h-screen md:pt-16"
    >
      <nav class="md:bg-none min min-h-full shadow-2xl md:shadow-none">
        <div class="px-1 xl:px-4">
          <ul class="flex flex-col w-full">
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
    </section>
  </div>
  <!-- Slide panel left -->
</template>

<script>
import TagRoute from "@/components/Navigator/TagRoute.vue";
import { mapState } from "vuex";

export default {
  name: "side-panel-left",
  data() {
    return {};
  },
  components: {
    TagRoute
  },
  computed: {
    ...mapState(["tags"])
  }
};
</script>
