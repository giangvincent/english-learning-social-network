<template>
  <div>
    <div class="flashCards" v-for="(card, index) in flashCards" :key="'flash-card-'+ index"></div>
  </div>
</template>

<script>
import ContentEditor from "@/components/Form/ContentEditor.vue";
import ImagePreview from "@/components/Form/ImagePreview.vue";
export default {
  name: "flash-card",
  components: {
    ContentEditor,
    ImagePreview,
  },
  data() {
    return {
      flashCards: [{ content: "", flip: "" }],
    };
  },
};
</script>