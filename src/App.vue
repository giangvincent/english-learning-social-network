<template>
  <div id="app" :class="{ 'overflow-y-hidden h-screen': popupEditor }">
    <router-view />
  </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";

export default {
  computed: {
    ...mapState({
      popupEditor: state => state.popupEditor
    })
  },
  mouted() {},
  methods: {
    ...mapMutations(["SET_USER", "SET_TOKEN"])
  }
};
</script>
