<template>
  <div :id="'editor-container-' + paraIndex">
    <div
      :id="'editor-' + paraIndex"
      class="editor h-64 rounded-b-lg border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
    ></div>
    <span class="italic">(Tối đa: 500 ký tự)</span>
  </div>
</template>

<script>
import Quill from "quill";
import "quill/dist/quill.snow.css";
import { mapState } from "vuex";

export default {
  name: "content-editor",
  props: {
    paraIndex: String,
    contentHtml: String,
    contentOrigin: Object,
    toolbar: Boolean,
  },
  data() {
    return {
      editor: null,
      reinitEditor: true,
    };
  },
  watch: {
    contentHtml: function (newVal, oldVal) {
      if (this.currentAction === "edit" && this.reinitEditor) {
        this.initEditor();
        this.reinitEditor = false;
      }
    },
    paraIndex: function (newVal, oldVal) {
      console.log("reinit Editor");
      this.initEditor();
    },
  },
  computed: {
    ...mapState({
      currentAction: (state) => state.creator.currentAction,
    }),
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
        [{ align: [] }],

        ["clean"], // remove formatting button
      ];
      this.editor =
        this.editor ||
        new Quill("#editor-" + this.paraIndex, {
          modules: {
            toolbar: this.toolbar || toolbarOptions,
          },
          scrollingContainer: "#editor-container-" + this.paraIndex,
          theme: "snow",
          height: 200,
        });

      const importContent = this.editor.clipboard.convert(this.contentHtml);
      console.log(this.contentOrigin);
      this.editor.setContents(importContent);
      var self = this;
      let limit = 400;
      this.editor.on("text-change", function (delta, oldDelta, source) {
        /* if (source == "api") {
          console.log("An API call triggered this change.");
        } else if (source == "user") {
          console.log("A user action triggered this change.");
        } */
        if (self.editor.getLength() > limit) {
          self.editor.deleteText(limit, self.editor.getLength());
        }
        let contentChanged = {
          html: self.editor.root.innerHTML,
          origin: self.editor.getContents(),
        };
        // console.log(delta, self.editor.root.innerHTML);
        self.$emit("updateContent", contentChanged, self.paraIndex);
      });

      changeHeightEleByClass(document.getElementsByClassName("editor"));
      changeHeightEleByClass(document.getElementsByClassName("ql-editor"));
    },
  },
};
function changeHeightEleByClass(elements) {
  for (var i = 0, len = elements.length; i < len; i++) {
    elements[i].style["height"] = "auto";
  }
}
</script>

<style></style>
