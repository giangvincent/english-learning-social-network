<template>
  <div class="md:block">
    <div
      class="bg-black bg-opacity-50 fixed z-40 md:z-30 top-0 bottom-0 left-0 right-0 "
      :class="{ hidden: !showPanelRight }"
      @click="toggle_right_panel()"
    ></div>
    <!-- shade -->
    <section
      class="bg-white transform md:transform-none ease-in-out transition-all duration-300 fixed top-0 bottom-0 right-0 z-50 md:z-30 h-screen md:pt-16 overflow-y-scroll"
      :class="{
        'w-0': !showPanelRight,
        'w-64 md:w-1/5 lg:w-1/6': showPanelRight
      }"
    >
      <nav class="md:bg-none min min-h-full shadow-2xl md:shadow-none">
        <div class="px-1 xl:px-4">
          <ul class="flex flex-col w-full">
            <li
              class="m-2 md:my-2"
              v-for="(notify, index) in notification"
              :key="'notification-' + index"
            >
              <router-link
                :to="`/p/post/${notify.pid}?from=notification`"
                class="flex flex-row items-center p-2 xl:px-4 rounded-lg border-2 border-gray-400 font-semibold"
                v-if="notify.type === 'normalPost'"
              >
                {{ notify.subject }}
              </router-link>
              <router-link
                :to="`/p/flash-card/${notify.pid}?from=notification`"
                class="flex flex-row items-center p-2 xl:px-4 rounded-lg border-2 border-gray-400 font-semibold"
                v-if="notify.type === 'flashCard'"
              >
                {{ notify.subject }}
              </router-link>
              <router-link
                :to="`/p/quiz/${notify.pid}?from=notification`"
                class="flex flex-row items-center p-2 xl:px-4 rounded-lg border-2 border-gray-400 font-semibold"
                v-if="notify.type === 'quiz'"
              >
                {{ notify.subject }}
              </router-link>
            </li>
          </ul>
        </div>
      </nav>
    </section>
  </div>
  <!-- Slide panel left -->
</template>

<script>
import { mapMutations, mapState } from "vuex";

export default {
  name: "side-panel-left",
  data() {
    return {};
  },
  components: {},
  computed: {
    ...mapState({
      showPanelRight: state => state.showPanelRight,
      notification: state => state.user.notification
    })
  },
  methods: {
    ...mapMutations(["toggle_right_panel"])
  }
};
</script>
