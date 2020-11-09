<template>
  <div id="app">
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
  watch: {
    popupEditor: function(val) {
      document.body.style.overflowY = val ? "hidden" : "unset";
    },
    showPanelLeft: function(val) {
      document.body.style.overflowY = val ? "hidden" : "unset";
    },
    showPanelRight: function(val) {
      document.body.style.overflowY = val ? "hidden" : "unset";
    }
  },
  methods: {
    ...mapMutations(["SET_USER", "SET_TOKEN"]),
    ...mapActions(["LOAD_TAGS", "LOAD_CATEGORIES"])
  }
};
</script>
