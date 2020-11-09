<template>
  <div>
    <fieldset
      class="relative my-2 p-3 border-2 border-blue-900 rounded-lg bg-white"
      v-for="(paragraph, index) in paragraphs"
      :key="'paragraph-' + index"
    >
      <legend class="mx-2 font-bold rounded-lg bg-blue-900 text-white p-2">
        Đoạn {{ index + 1 }}
      </legend>
      <div
        class="absolute right-0 rounded-full w-10 -mr-3 -mt-10"
        @click="removeParagraph(index)"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
            clip-rule="evenodd"
          />
        </svg>
      </div>
      <div class="py-1">
        <span class="px-1  text-gray-600">Nội dung</span>
        <content-editor
          :contentHtml="paragraph.contentHtml"
          :contentOrigin="paragraph.contentOrigin"
          :paraIndex="index.toString()"
          @updateContent="updateContent"
        ></content-editor>
      </div>
      <!-- text content editor -->

      <image-preview
        @updateImages="updateImages"
        :paraIndex="index"
      ></image-preview>
    </fieldset>
    <div class="flex justify-center">
      <button
        class="float-right font-semibold text-white rounded-lg px-3 py-2 btn-hover bg-color-black"
        @click="addParagraph()"
      >
        Thêm đoạn mới
      </button>
    </div>
  </div>
</template>

<script>
import ContentEditor from "@/components/Form/ContentEditor.vue";
import ImagePreview from "@/components/Form/ImagePreview.vue";
export default {
  name: "article-content",
  components: {
    ContentEditor,
    ImagePreview
  },
  data() {
    return {
      paragraphs: [{ contentHtml: "", contentOrigin: { ops: [] }, images: [] }]
    };
  },
  watch: {
    paragraphs: {
      handler(val) {
        this.$emit("changeContent", this.paragraphs);
      },
      deep: true
    }
  },
  methods: {
    removeParagraph(index) {
      this.paragraphs.splice(index, 1);
    },
    addParagraph() {
      this.paragraphs.push({
        contentHtml: "",
        contentOrigin: { ops: [] },
        images: []
      });
    },
    updateContent(content, paraIndex) {
      paraIndex = parseInt(paraIndex);
      this.paragraphs[paraIndex].contentHtml = content.html;
      this.paragraphs[paraIndex].contentOrigin = content.origin;
    },
    updateImages(images, paraIndex) {
      // console.log(images, paraIndex);
      this.paragraphs[paraIndex].images = images;
    }
  }
};
</script>
