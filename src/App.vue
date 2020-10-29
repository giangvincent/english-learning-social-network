<template>
  <div
    id="app"
    :class="{
      'overflow-y-hidden h-screen':
        popupEditor || showPanelLeft || showPanelRight
    }"
  >
    <router-view />
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";

export default {
  computed: {
    ...mapState({
      popupEditor: state => state.popupEditor,
      showPanelLeft: state => state.showPanelLeft,
      showPanelRight: state => state.showPanelRight
    })
  },
  mounted() {
    this.LOAD_TAGS();
    this.LOAD_CATEGORIES();
  },
  methods: {
    ...mapMutations(["SET_USER", "SET_TOKEN"]),
    ...mapActions(["LOAD_TAGS", "LOAD_CATEGORIES"])
  }
};
</script>
