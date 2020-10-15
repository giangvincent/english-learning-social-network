<template>
  <div>
    <fieldset class="relative my-2 p-3 border-2 border-blue-900 rounded-lg">
      <legend class="mx-2 font-bold rounded-lg bg-blue-900 text-white p-2">
        Nội dung câu hỏi
      </legend>

      <div class="py-1">
        <span class="px-1 text-sm text-gray-600">Câu hỏi</span>
        <content-editor paraIndex="quiz-question"></content-editor>
      </div>
      <!-- text content editor -->

      <image-preview></image-preview>
    </fieldset>

    <fieldset class="relative my-2 p-3 border-2 border-blue-900 rounded-lg">
      <legend class="mx-2 font-bold rounded-lg bg-blue-900 text-white p-2">
        Các câu trả lời
      </legend>
      <div class="py-1">
        <input
          placeholder="Nội dung câu trả lời"
          type="text"
          class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          v-model="curAnswer"
          v-on:keyup.enter="createAnswer()"
        />
      </div>
    </fieldset>
  </div>
</template>

<script>
import ContentEditor from "@/components/Form/ContentEditor.vue";
import ImagePreview from "@/components/Form/ImagePreview.vue";
export default {
  name: "quiz",
  components: {
    ContentEditor,
    ImagePreview
  },
  data() {
    return {
      curAnswer: "",
      quizAnswers: [],
      quiz: {
        contentHtml: "",
        contentOrigin: "",
        images: [],
        answers: [],
        correctAnswers: []
      }
    };
  },
  methods: {
    createAnswer() {},
    updateContent(content, paraIndex) {}
  }
};
</script>
