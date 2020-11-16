<template>
  <div
    class="content-center flex items-center justify-between flex-wrap mt-3 px-1 text-gray-600 text-sm "
  >
    <span>Hình ảnh</span>
    <button
      type="button"
      class="font-semibold text-white rounded-lg px-3 py-2 btn-hover bg-color-blue"
      @click="selectImages()"
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
    <input
      ref="imgInput"
      type="file"
      class="hidden"
      accept="images/*"
      multiple
      @change="onImagesSelect"
    />
    <div
      class="w-full flex flex-wrap my-4"
      ref="imageContainer"
      v-if="previewImages.length > 0"
    >
      <div
        class="w-1/3 sm:w-1/5 relative mb-2 pr-2 flex flex-wrap items-center justify-center"
        v-for="(image, index) in previewImages"
        :key="'previewImage-' + index"
      >
        <img :src="image" class="w-full rounded-lg" />
        <div class="absolute">
          <button
            class="w-8 rounded-full p-2 text-white bg-black bg-opacity-50 hover:bg-opacity-100"
            @click="toImageEditor(index)"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
              />
            </svg>
          </button>
          <!-- button edit image -->
          <button
            class="w-8 rounded-full p-2 text-white bg-black bg-opacity-50 hover:bg-opacity-100"
            @click="removePreview(index)"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
          <!-- button delete preview image -->
        </div>
      </div>
    </div>
    <!-- preview images -->
    <component
      v-bind:is="asyncComponent"
      :imageEdit="imageChange"
      v-on:onDoneEvent="onDoneEvent"
      v-on:cancel="onCancelEvent"
      v-if="imageChange !== null"
    >
      <!-- component changes when vm.currentView changes! -->
    </component>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";
var blobToBase64 = function(blob, callback) {
  var reader = new FileReader();
  reader.onload = function() {
    var dataUrl = reader.result;
    // var base64 = dataUrl.split(",")[1];
    callback(dataUrl);
  };
  reader.readAsDataURL(blob);
};
export default {
  name: "image-preview",
  props: {
    paraIndex: Number
  },
  components: {
    ImageEditor: () => import("./ImageEditor.vue")
  },
  data() {
    return {
      asyncComponent: "ImageEditor",
      previewImages: [],
      indexImageChange: null,
      imageChange: null
    };
  },
  watch: {
    previewImages: {
      handler(val) {
        this.$emit("updateImages", this.previewImages, this.paraIndex);
      },
      deep: true
    }
  },
  mounted() {
    if (!isScriptAlreadyIncluded("/assets/fabric.min.js")) {
      let fabricScript = document.createElement("script");
      fabricScript.setAttribute("src", "/assets/fabric.min.js");
      document.head.appendChild(fabricScript);
    }
  },
  methods: {
    ...mapMutations(["Toggle_popupEditor"]),
    selectImages() {
      this.$refs.imgInput.click();
    },
    onImagesSelect(e) {
      let images = e.target.files;
      var self = this;
      if (images) {
        for (let imageIndex = 0; imageIndex < images.length; imageIndex++) {
          blobToBase64(images[imageIndex], function(base64) {
            self.previewImages.push(base64);
          });
        }
      }
    },
    removePreview(index) {
      this.previewImages.splice(index, 1);
    },
    toImageEditor(index) {
      this.Toggle_popupEditor();
      this.indexImageChange = index;
      this.imageChange = this.previewImages[index];
    },
    onDoneEvent(finalImage) {
      this.previewImages[this.indexImageChange] = finalImage;
      this.indexImageChange = null;
      this.imageChange = null;
    },
    onCancelEvent() {
      this.indexImageChange = null;
      this.imageChange = null;
    }
  }
};
function isScriptAlreadyIncluded(src) {
  var scripts = document.getElementsByTagName("script");
  for (var i = 0; i < scripts.length; i++)
    if (scripts[i].getAttribute("src") == src) return true;
  return false;
}
</script>
