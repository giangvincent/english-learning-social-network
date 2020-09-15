<template>
  <div>
    <!--Nav-->
    <nav id="header" class="bg-white w-full shadow">
      <div
        class="w-full container mx-auto flex flex-wrap items-center mt-0 px-4 justify-between sm:justify-center"
      >
        <label
          for="menu-toggle"
          class="cursor-pointer py-2"
          @click="$router.go(-1)"
        >
          <svg
            class="color-black fill-current w-5"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M10 19l-7-7m0 0l7-7m-7 7h18"
            />
          </svg>
        </label>

        <div class="order-1 md:order-2 md:w-1/3 flex justify-center py-2">
          <logo></logo>
        </div>
      </div>
    </nav>

    <div class="my-6 md:px-6 lg:px-8 pb-20 mx-auto px-3">
      <div class="mx-auto max-w-lg">
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Danh mục</span>
          <form-select
            :selectData="categories"
            @changeSelectData="changeCategory"
          ></form-select>
        </div>
        <!-- pickup category -->
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Loại bài viết</span>
          <div class="sm:rounded shadow">
            <div class="w-full mx-auto flex text-center font-bold">
              <a href class="w-1/3 py-3 border-b-2 border-gray-900">Bài viết</a>
              <a href class="w-1/3 py-3">Flash Cards</a>
              <a href class="w-1/3 py-3">Câu đố</a>
            </div>
            <!-- END topbar lvl1 -->
          </div>
        </div>

        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Nội dung</span>
          <div id="toolbar"></div>
          <div
            id="editor"
            class="rounded-b-lg  border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          ></div>
        </div>
        <!-- text content editor -->
        <div class="py-1">
          <div
            class="content-center flex items-center justify-between lex-wrap mt-3 px-1 text-gray-600 text-sm px-1 text-sm text-gray-600"
          >
            <span>Hình ảnh</span>
            <a href="editor-image.html">
              <button
                type="button"
                class="font-semibold text-white rounded-lg px-3 py-2 btn-hover bg-color-blue"
              >
                <svg
                  class="text-white w-5 inline"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                  />
                </svg>
                Chọn hình ảnh
              </button>
            </a>
          </div>
        </div>
        <!-- Images holder -->

        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Tag</span>
          <input
            placeholder
            type="text"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
          <div class="py-3">
            <span
              class="bg-color-purple font-bold inline-block m-1 pr-8 px-2 py-1 relative rounded-full text-white text-xs"
            >
              Tag 1
              <svg
                class="absolute inline text-white w-5"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                style="top: 3px; right: 1px"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </span>
            <span
              class="bg-color-purple font-bold inline-block m-1 pr-8 px-2 py-1 relative rounded-full text-white text-xs"
            >
              Tag 2
              <svg
                class="absolute inline text-white w-5"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                style="top: 3px; right: 1px"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </span>
          </div>
        </div>
        <!-- Ending Tag -->

        <button
          class="mt-3 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
          @click="submitContent"
        >
          <svg
            class="text-white w-5 inline"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
            />
          </svg>
          Đăng bài
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import logo from "@/components/Logo.vue";
import formSelect from "@/components/Form/Select.vue";
import Quill from "quill";
import "quill/dist/quill.snow.css";

export default {
  name: "creator",
  components: {
    logo,
    formSelect
  },
  data() {
    return {
      editor: null,
      categories: [
        { title: "Từ vựng", desc: "Thêm cách học từ mới nè", id: 1 },
        { title: "Luyện nghe", desc: "Video hoặc audio để luyện nghe", id: 2 },
        { title: "Ngữ pháp", desc: "Ngữ pháp cũng quan trọng lắm", id: 3 }
      ],
      category: 0
    };
  },
  mounted() {
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

    this.editor = new Quill("#editor", {
      modules: {
        toolbar: toolbarOptions
      },
      theme: "snow"
    });
    var content =
      '<h2>This is a Heading H2</h2><p><span class="ql-size-small">this is a small with </span><span class="ql-size-small" style="color: rgb(230, 0, 0);">COLOR TEXT</span></p><p class="ql-align-center"><span class="ql-size-large ql-font-monospace">This is a large Text with </span><span class="ql-size-large ql-font-monospace" style="background-color: rgb(255, 255, 102);">background</span></p>';
    console.log(content);
    const delta = this.editor.clipboard.convert(content);
    console.log(delta);
    this.editor.setContents(delta);
  },
  methods: {
    changeCategory(index) {
      console.log(index);
      this.category = index;
    },
    submitContent() {
      let content = this.editor.root.innerHTML;
      console.log(content);
    }
  },
  beforeDestroy() {}
};
</script>
