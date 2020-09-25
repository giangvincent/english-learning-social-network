<template>
  <div id="app" :class="{ 'overflow-y-hidden h-screen': popupEditor }">
    <router-view />
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      popupEditor: state => state.popupEditor
    })
  }
};
</script>
