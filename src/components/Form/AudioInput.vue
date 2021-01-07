<template>
  <div
    v-show="showAudio"
    class="modal-bg transition-all duration-500 fixed left-0 overflow-auto z-50 top-0 bottom-0 right-0 flex"
  >
    <div
      class="absolute w-full h-full bg-opacity-50 bg-black"
      @click="$emit('close')"
    ></div>
    <div
      class="modal-content bg-white relative m-auto max-w-lg shadow-lg rounded-lg"
    >
      <div
        class="closeBtn absolute right-0 top-0 font-bold text-4xl w-10 h-10 flex justify-center items-center bg-gray-900 text-white rounded-full -m-4"
        @click="$emit('close')"
      >
        &times;
      </div>
      <div class="py-3 px-3 flex flex-wrap">
        <fieldset
          class="relative my-2 p-3 border-2 border-blue-900 rounded-lg bg-white"
        >
          <legend class="mx-2 font-bold rounded-lg bg-blue-900 text-white p-2">
            Nhập chữ để nghe âm từ google translate
          </legend>
          <div class="py-1">
            <input
              ref="audioInput"
              autocapitalize="none"
              placeholder="Chữ cần phát âm ...(Tối đa 100 ký tự)"
              type="text"
              class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
              maxlength="100"
              v-model="textInput"
              v-on:keyup.enter="addAudio"
            />
          </div>
        </fieldset>
      </div>
    </div>
  </div>
  <!-- Modal other interaction -->
</template>

<script>
export default {
  name: "audio-input",
  props: {
    showAudio: Boolean
  },
  data() {
    return {
      textInput: ""
    };
  },
  watch: {
    showAudio: function(newVal, oldVal) {
      if (newVal) {
        this.$nextTick(() => this.setFocus());
      }
    }
  },
  methods: {
    setFocus: function() {
      // Note, you need to add a ref="search" attribute to your input.
      this.$refs.audioInput.focus();
    },
    addAudio() {
      if (this.textInput !== "") {
        this.textInput = this.textInput.replace(/\s+/g, " ");
        this.textInput = this.textInput.toLowerCase().trim();
        this.$emit("addAudio", this.textInput);
        this.textInput = "";
        this.$emit("close");
      }
    }
  }
};
</script>
