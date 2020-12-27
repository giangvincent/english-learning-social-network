<template>
  <div class="container mx-auto p-6 md:p-12 mt-6 relative flex flex-wrap">
    <div class="w-full">
      <div class="text-center font-semibold">
        Nếu bạn có ý kiến hay câu hỏi gì xin gửi về cho chúng tôi theo form sau.
      </div>
      <div class="text-center font-base">
        Mọi ý kiến của bạn đều là động lực để chúng tôi tiếp tục phát triển
        Website này.
      </div>
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

      <div class="py-1">
        <ul>
          <li
            class="text-red-600"
            v-for="(err, index) in errors"
            :key="'err-' + index"
          >
            - {{ err }}
          </li>
        </ul>
      </div>

      <button
        class="mt-3 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
        @click="sendContact()"
      >
        <span v-if="!processApi"> Gửi liên hệ </span>
        <div v-if="processApi">
          <loading-icon></loading-icon>
        </div>
      </button>
    </div>
  </div>
</template>

<script>
import LoadingIcon from "@/components/Icons/LoadingAnimate.vue";
import Quill from "quill";
import "quill/dist/quill.snow.css";
import { mapState } from "vuex";
export default {
  name: "contact",
  components: {
    LoadingIcon,
  },
  data() {
    return {
      processApi: false,
      email: null,
      name: null,
      subject: null,
      content: null,
      errors: [],
    };
  },
  mounted() {
    this.initEditor();
  },
  computed: {
    ...mapState({
      apiUrl: (state) => state.apiUrl,
    }),
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
        new Quill("#editor", {
          modules: {
            toolbar: this.toolbar || toolbarOptions,
          },
          scrollingContainer: "#editor-container",
          theme: "snow",
          height: 200,
        });

      const importContent = this.editor.clipboard.convert(this.content);
      this.editor.setContents(importContent);
      var self = this;
      this.editor.on("text-change", function (delta, oldDelta, source) {
        self.content = self.editor.root.innerHTML;
      });
    },
    sendContact() {
      this.errors = [];
      if (!this.email) {
        this.errors.push("Email còn trống");
      }
      if (!this.name) {
        this.errors.push("Tên còn trống");
      }
      if (!this.subject) {
        this.errors.push("Vấn đề còn trống");
      }
      if (!this.content) {
        this.errors.push("Nội dung còn trống");
      }
      var data = new FormData();
      data.append("email", this.email);
      data.append("name", this.name);
      data.append("subject", this.subject);
      data.append("content", this.content);
      let url = this.apiUrl + "/new-contact";
      this.processApi = true;
      let self = this;
      fetch(url, {
        method: "POST",
        body: data,
      })
        .then(function (res) {
          return res.json();
        })
        .then(function (data) {
          console.log(data);
          self.processApi = false;
          if (typeof data.status !== "undefined" && data.status) {
            self.$toast.success("Liên hệ đã được gửi thành công.");
            self.$toast.info(
              "Cảm ơn bạn đã liên hệ. Ban quản trị sẽ trả lời lại bạn trong thời gian sớm nhất."
            );
            self.$router.push("/");
          } else {
            self.$toast.error(
              "Đã xảy lỗi. Vui lòng xem lại thông tin liên hệ."
            );
            for (var key in data.error) {
              self.errors.push(data.error[key][0]);
            }
          }
        })
        .catch((err) => {
          self.$toast.error("Đã xảy lỗi.", err);
          console.log(err);
        });
    },
  },
};
</script>
