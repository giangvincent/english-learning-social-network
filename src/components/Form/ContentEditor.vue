<template>
  <div :id="'editor-container-' + contentIndex" class="overflow-y-auto">
    <div
      :id="'editor-' + contentIndex"
      class="editor h-64 rounded-b-lg border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
    ></div>
  </div>
</template>

<script>
import Quill from "quill";
import "quill/dist/quill.snow.css";

export default {
  name: "content-editor",
  props: {
    contentIndex: String
  },
  data() {
    return {
      editor: null
    };
  },
  watch: {
    contentIndex: function(newVal, oldVal) {
      console.log("reinit Editor");
      this.initEditor();
    }
  },
  mounted() {
    console.log(this.contentIndex);
    this.initEditor();
  },
  methods: {
    initEditor() {
      var toolbarOptions = [
        ["bold", "italic", "underline", "strike"], // toggled buttons
        ["blockquote", "code-block"],

        [{ header: 1 }, { header: 2 }], // custom button values
        [{ list: "ordered" }, { list: "bullet" }],
        [{ script: "sub" }, { script: "super" }], // superscript/subscript
        [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
        [{ direction: "rtl" }], // text direction

        [{ size: ["small", false, "large", "huge"] }], // custom dropdown
        [{ header: [1, 2, 3, 4, 5, 6, false] }],

        [{ color: [] }, { background: [] }], // dropdown with defaults from theme
        [{ font: [] }],
        [{ align: [] }],

        ["clean"] // remove formatting button
      ];

      var content =
        '<h2>This is a Heading H2</h2><p><span class="ql-size-small">this is a small with </span><span class="ql-size-small" style="color: rgb(230, 0, 0);">COLOR TEXT</span></p><p class="ql-align-center"><span class="ql-size-large ql-font-monospace">This is a large Text with </span><span class="ql-size-large ql-font-monospace" style="background-color: rgb(255, 255, 102);">background</span></p>';

      this.editor = new Quill("#editor-" + this.contentIndex, {
        modules: {
          toolbar: toolbarOptions
        },
        scrollingContainer: "#editor-container-" + this.contentIndex,
        theme: "snow"
      });

      console.log(content);
      const delta = this.editor.clipboard.convert(content);
      console.log(delta);
      this.editor.setContents(delta);
    }
  }
};
</script>
