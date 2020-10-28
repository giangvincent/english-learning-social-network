<template>
  <div :id="'editor-container-' + paraIndex">
    <div
      :id="'editor-' + paraIndex"
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
    paraIndex: String,
    contentHtml: String,
    contentOrigin: Object,
  },
  data() {
    return {
      editor: null,
    };
  },
  watch: {
    paraIndex: function (newVal, oldVal) {
      console.log("reinit Editor");
      this.initEditor();
    },
  },
  mounted() {
    console.log("para index: ", this.paraIndex);
    this.initEditor();
  },
  methods: {
    initEditor() {
      var toolbarOptions = [
        ["bold", "italic", "underline", "strike"], // toggled buttons
        ["blockquote", "link", "video"],

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

        ["clean"], // remove formatting button
      ];

      this.editor = new Quill("#editor-" + this.paraIndex, {
        modules: {
          toolbar: toolbarOptions,
        },
        scrollingContainer: "#editor-container-" + this.paraIndex,
        theme: "snow",
        height: 200,
      });

      const importContent = this.editor.clipboard.convert(this.contentHtml);
      console.log(this.contentOrigin);
      this.editor.setContents(importContent);
      var self = this;
      this.editor.on("text-change", function (delta, oldDelta, source) {
        /* if (source == "api") {
          console.log("An API call triggered this change.");
        } else if (source == "user") {
          console.log("A user action triggered this change.");
        } */
        let contentChanged = {
          html: self.editor.root.innerHTML,
          origin: self.editor.getContents(),
        };
        // console.log(delta, self.editor.root.innerHTML);
        self.$emit("updateContent", contentChanged, self.paraIndex);
      });
    },
  },
};
</script>
