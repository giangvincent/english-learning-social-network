<template>
  <div>
    <div class="paragraph" v-for="(paragraph, index) in paragraphs" :key="'paragraph-'+ index">
      <div class="py-1">
        <span class="px-1 text-sm text-gray-600">Nội dung</span>
        <content-editor></content-editor>
      </div>
      <!-- text content editor -->

      <image-preview></image-preview>
    </div>
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
    return {
      paragraphs: [{ content: "", images: [] }],
    };
  },
};
</script>
