<template>
  <div>
    <fieldset
      class="relative my-2 p-3 border-2 border-blue-900 rounded-lg bg-white"
      v-for="(card, index) in flashCards"
      :key="'flash-card-' + index"
    >
      <legend class="mx-2 font-bold rounded-lg bg-blue-900 text-white p-2">
        Flash Card {{ index + 1 }}
      </legend>
      <div
        class="absolute right-0 rounded-full w-10 -mr-3 -mt-10"
        @click="removeCard(index)"
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
        <span class="px-1 text-gray-600">Nội dung gợi ý</span>
        <content-editor
          :contentHtml="card.contentHtml"
          :contentOrigin="card.contentOrigin"
          :paraIndex="index.toString()"
          @updateContent="updateContent"
          :toolbar="true"
        ></content-editor>
      </div>
      <!-- text content editor -->

      <media-input
        @updateImages="updateImages"
        :paraIndex="index"
      ></media-input>

      <div class="py-1">
        <span class="px-1 text-gray-600">Kết quả</span>
        <content-editor
          :paraIndex="'-flip-content-' + index"
          :contentHtml="card.flipContentHtml"
          :contentOrigin="card.flipContentOrigin"
          @updateContent="updateFlipContent"
          :toolbar="true"
        ></content-editor>
      </div>
      <!-- text content editor -->

      <media-input
        @updateImages="updateFlipImages"
        @updateAudios="updateAudios"
        :paraIndex="index"
      ></media-input>
    </fieldset>
    <div class="flex justify-center">
      <button
        class="float-right font-semibold text-white rounded-lg px-3 py-2 btn-hover bg-color-black"
        @click="addCard()"
      >
        Thêm Card mới
      </button>
    </div>
  </div>
</template>

<script>
import ContentEditor from "@/components/Form/ContentEditor.vue";
import MediaInput from "@/components/Form/MediaInput.vue";
export default {
  name: "flash-card",
  components: {
    ContentEditor,
    MediaInput
  },
  props: {
    data: Array
  },
  data() {
    return {
      maxCards: 15,
      flashCards: [
        {
          contentHtml: "",
          contentOrigin: { ops: [] },
          images: [],
          audios: [],
          flipContentHtml: "",
          flipContentOrigin: { ops: [] },
          flipImages: []
        }
      ]
    };
  },
  watch: {
    flashCards: {
      handler(val) {
        this.$emit("changeContent", this.flashCards);
      },
      deep: true
    },
    data: {
      handler: function(val) {
        // console.log(val);
        this.flashCards = this.data;
      },
      deep: true
    }
  },
  mounted() {
    console.log(this.data);
    if (this.data) {
      this.flashCards = this.data;
    }
  },
  methods: {
    removeCard(index) {
      this.flashCards.splice(index, 1);
    },
    addCard() {
      this.flashCards.push({
        contentHtml: "",
        contentOrigin: { ops: [] },
        images: [],
        flipContentHtml: "",
        flipContentOrigin: { ops: [] },
        flipImages: []
      });
    },
    updateContent(content, paraIndex) {
      this.flashCards[paraIndex].contentHtml = content.html;
      this.flashCards[paraIndex].contentOrigin = content.origin;
    },
    updateFlipContent(content, paraIndex) {
      paraIndex = parseInt(paraIndex.replace("-flip-content-", ""));
      this.flashCards[paraIndex].flipContentHtml = content.html;
      this.flashCards[paraIndex].flipContentOrigin = content.origin;
    },
    updateImages(images, paraIndex) {
      this.flashCards[paraIndex].images = images;
    },
    updateFlipImages(images, paraIndex) {
      this.flashCards[paraIndex].flipImages = images;
    },
    updateAudios(audios, paraIndex) {
      this.flashCards[paraIndex].audios = audios;
    }
  }
};
</script>
