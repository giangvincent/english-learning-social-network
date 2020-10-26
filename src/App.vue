<template>
  <div id="app" :class="{ 'overflow-y-hidden h-screen': popupEditor }">
    <router-view />
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";

export default {
  computed: {
    ...mapState({
      popupEditor: state => state.popupEditor
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
