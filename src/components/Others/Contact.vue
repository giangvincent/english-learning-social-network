<template>
  <div class="container mx-auto p-6 md:p-12 mt-6 relative flex flex-wrap">
    <div class="w-full mb-5 pb-1border-b-2 text-center font-base text-gray-700">
      <router-link
        class="items-center hover:no-underline font-bold text-gray-800 text-xl uppercase"
        to="/"
        >ohitsgood</router-link
      >
    </div>
    <div class="w-full">
      <div class="text-center font-semibold">Lorem ipsum dolor</div>
      <div class="text-center font-base">Sed ut perspiciatis unde?</div>
    </div>
    <div class="mt-8 mx-auto w-full">
      <div class="py-1">
        <span class="px-1 text-sm text-gray-600">Email của bạn</span>
        <input
          placeholder
          type="email"
          v-model="email"
          class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
        />
      </div>
      <div class="py-1">
        <span class="px-1 text-sm text-gray-600">Tên của bạn</span>
        <input
          placeholder
          type="text"
          v-model="name"
          class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
        />
      </div>
      <div class="py-1">
        <span class="px-1 text-sm text-gray-600">Vấn đề liên hệ</span>
        <input
          placeholder
          type="text"
          v-model="subject"
          class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
        />
      </div>
      <div class="py-1">
        <span class="px-1 text-sm text-gray-600">Nội dung</span>
        <div class="relative rounded-lg bg-white border-2 border-gray-300">
          <div id="editor-container">
            <div
              id="editor"
              class="editor h-64 rounded-b-lg border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
            ></div>
          </div>
        </div>
      </div>

      <button
        class="mt-3 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
        @click="sendRegister()"
      >
        <span v-if="!processApi">
          Gửi liên hệ
        </span>
        <div v-if="processApi">
          <loading-icon></loading-icon>
        </div>
      </button>
    </div>
  </div>
</template>

<script>
import Quill from "quill";
import "quill/dist/quill.snow.css";
export default {
  name: "contact",
  data() {
    return {
      processApi: false,
      email: null,
      name: null,
      subject: null,
      content: null
    };
  },
  mounted() {
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

        ["clean"] // remove formatting button
      ];
      this.editor =
        this.editor ||
        new Quill("#editor", {
          modules: {
            toolbar: this.toolbar || toolbarOptions
          },
          scrollingContainer: "#editor-container",
          theme: "snow",
          height: 200
        });

      const importContent = this.editor.clipboard.convert(this.content);
      this.editor.setContents(importContent);
      var self = this;
      this.editor.on("text-change", function(delta, oldDelta, source) {
        self.content = self.editor.root.innerHTML;
      });

      changeHeightEleByClass(document.getElementsByClassName("editor"));
      changeHeightEleByClass(document.getElementsByClassName("ql-editor"));
    },
    sendContact() {}
  }
};
</script>
