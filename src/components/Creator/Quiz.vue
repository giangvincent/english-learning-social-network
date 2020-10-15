<template>
  <div>
    <fieldset class="relative my-2 p-3 border-2 border-blue-900 rounded-lg">
      <legend class="mx-2 font-bold rounded-lg bg-blue-900 text-white p-2">
        Nội dung câu hỏi
      </legend>

      <div class="py-1">
        <span class="px-1 text-sm text-gray-600">Câu hỏi</span>
        <content-editor
          paraIndex="quiz-question"
          :contentHtml="quiz.contentHtml"
          :contentOrigin="quiz.contentOrigin"
          @updateContent="updateContent"
        ></content-editor>
      </div>
      <!-- text content editor -->

      <image-preview
        @updateImages="updateImages"
        :paraIndex="0"
      ></image-preview>
    </fieldset>

    <fieldset class="relative my-2 p-3 border-2 border-blue-900 rounded-lg">
      <legend class="mx-2 font-bold rounded-lg bg-blue-900 text-white p-2">
        Các câu trả lời
      </legend>
      <div
        class="py-1 flex"
        v-for="(answer, index) in quiz.answers"
        :key="'answers-' + index"
      >
        <input
          placeholder="Nội dung câu trả lời"
          type="text"
          class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          v-on:change="updateAnswer($event.target.value, index)"
        />

        <button
          class="mx-1 border border-2 border-green-600 rounded w-10"
          @click="makeCorrectAnswer(index)"
          :class="{ 'bg-green-600': quiz.correctAnswers.includes(index) }"
          title="Đánh dấu câu trả lời đúng"
        >
          <svg
            class=" w-full h-full inline"
            :class="{
              'text-green-600': !quiz.correctAnswers.includes(index),
              'text-white': quiz.correctAnswers.includes(index)
            }"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7"
            />
          </svg>
        </button>
        <button
          class="mx-1 border border-2 border-red-600 rounded w-10"
          @click="delAnswer(index)"
          title="Xóa câu trả lời"
        >
          <svg
            class="text-red-600 w-full h-full inline"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
        </button>
      </div>
      <div class="flex justify-center pt-2">
        <button
          class="font-semibold text-white rounded-lg px-3 py-2 btn-hover bg-color-black"
          @click="createAnswer()"
        >
          Thêm câu trả lời
        </button>
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
      quiz: {
        contentHtml: "",
        contentOrigin: { ops: [] },
        images: [],
        answers: [],
        correctAnswers: []
      }
    };
  },
  methods: {
    createAnswer() {
      this.quiz.answers.push("");
    },
    delAnswer(index) {
      this.quiz.answers.splice(index, 1);
      this.quiz.correctAnswers.splice(
        this.quiz.correctAnswers.indexOf(index),
        1
      );
    },
    makeCorrectAnswer(index) {
      if (this.quiz.correctAnswers.includes(index)) {
        this.quiz.correctAnswers.splice(
          this.quiz.correctAnswers.indexOf(index),
          1
        );
      } else {
        this.quiz.correctAnswers.push(index);
      }
    },
    updateContent(content, paraIndex) {
      this.quiz.contentHtml = content.html;
      this.quiz.contentOrigin = content.origin;
    },
    updateImages(images, paraIndex) {
      this.quiz.images = images;
    },
    updateAnswer(value, index) {
      this.quiz.answers[index] = value;
    }
  }
};
</script>
