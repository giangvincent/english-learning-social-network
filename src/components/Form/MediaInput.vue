<template>
  <div
    class="content-center flex items-center justify-between flex-wrap mt-3 px-1 text-gray-600 text-sm "
  >
    <span>Media</span>
    <div>
      <button
        type="button"
        class="font-semibold text-white rounded-lg px-3 py-2 btn-hover bg-color-purple mr-1"
        @click="showAudio = true"
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
            d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"
          />
        </svg>

        Chọn Audio
      </button>
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
    </div>

    <input
      ref="imgInput"
      type="file"
      class="hidden"
      accept="images/*"
      @change="onImagesSelect"
    />
    <div
      class="w-full flex flex-wrap my-4"
      ref="imageContainer"
      v-if="audios.length > 0"
    >
      <div
        class="relative mb-2 flex items-center justify-center"
        v-for="(audio, index) in audios"
        :key="'previewImage-' + index"
      >
        <svg
          class="w-8"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z"
            clip-rule="evenodd"
          />
        </svg>
        <div class="px-1 text-black font-bold text-normal">
          {{ audio }}
        </div>
        <div class="absolute">
          <button
            class="w-8 rounded-full p-2 text-white bg-black bg-opacity-50 hover:bg-opacity-100"
            @click="removeAudio(index)"
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
    <!-- list audios -->
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
    <audio-input
      :showAudio="showAudio"
      @close="showAudio = false"
      @addAudio="addAudio"
    ></audio-input>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";
import AudioInput from "./AudioInput.vue";

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
    ImageEditor: () => import("./ImageEditor.vue"),
    AudioInput: () => import("./AudioInput.vue")
  },
  data() {
    return {
      asyncComponent: "ImageEditor",
      previewImages: [],
      indexImageChange: null,
      imageChange: null,
      showAudio: false,
      audios: []
    };
  },
  watch: {
    previewImages: {
      handler(val) {
        this.$emit("updateImages", this.previewImages, this.paraIndex);
      },
      deep: true
    },
    audios: {
      handler(val) {
        this.$emit("updateAudios", this.audios, this.paraIndex);
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
    },
    addAudio(text) {
      this.audios[0] = text;
    },
    removeAudio(index) {
      this.audios.splice(index, 1);
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
