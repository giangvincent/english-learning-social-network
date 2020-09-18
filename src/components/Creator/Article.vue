<template>
  <div>
    <div class="py-1">
      <span class="px-1 text-sm text-gray-600">Nội dung</span>
      <content-editor></content-editor>
    </div>
    <!-- text content editor -->

    <image-preview></image-preview>
  </div>
</template>

<script>
import ContentEditor from "@/components/Form/ContentEditor.vue";
import ImagePreview from "@/components/Form/ImagePreview.vue";
export default {
  name: "article",
  components: {
    ContentEditor,
    ImagePreview,
  },
  data() {
    return {};
  },
};
</script>
