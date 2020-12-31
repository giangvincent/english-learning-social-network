<template>
  <div>
    <fieldset
      class="relative my-2 p-3 border-2 border-blue-900 rounded-lg bg-white"
      v-for="(quiz, paraIndex) in quizs"
      :key="'quiz-' + paraIndex"
    >
      <legend class="mx-2 font-bold rounded-lg bg-blue-900 text-white p-2">
        Nội dung câu hỏi
      </legend>
      <div
        class="absolute right-0 rounded-full w-10 -mr-3 -mt-10"
        @click="removeQuiz(paraIndex)"
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
        <span class="px-1 text-gray-600">Câu hỏi</span>
        <content-editor
          :contentHtml="quiz.contentHtml"
          :contentOrigin="quiz.contentOrigin"
          :paraIndex="paraIndex.toString()"
          @updateContent="updateContent"
        ></content-editor>
      </div>
      <!-- text content editor -->

      <media-input
        @updateImages="updateImages"
        :paraIndex="paraIndex"
      ></media-input>
      <div class="relative my-2 p-3">
        <div class="font-bold">Các câu trả lời</div>
        <div
          class="py-1 flex"
          v-for="(answer, index) in quiz.answers"
          :key="'answers-' + index"
        >
          <input
            placeholder="Nội dung câu trả lời"
            type="text"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
            v-on:change="updateAnswer($event.target.value, index, paraIndex)"
            maxlength="100"
            :value="answer"
          />

          <button
            class="mx-1 border border-2 border-green-600 rounded w-10"
            @click="makeCorrectAnswer(index, paraIndex)"
            :class="{
              'bg-green-600': quiz.correctAnswers.includes(index)
            }"
            title="Đánh dấu câu trả lời đúng"
          >
            <svg
              class="w-full h-full inline"
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
            @click="delAnswer(index, paraIndex)"
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
            @click="createAnswer(paraIndex)"
          >
            Thêm câu trả lời
          </button>
        </div>
      </div>
    </fieldset>
    <div class="flex justify-center">
      <button
        class="float-right font-semibold text-white rounded-lg px-3 py-2 btn-hover bg-color-black"
        @click="addQuiz()"
      >
        Thêm câu hỏi mới
      </button>
    </div>
  </div>
</template>

<script>
import ContentEditor from "@/components/Form/ContentEditor.vue";
import MediaInput from "@/components/Form/MediaInput.vue";
export default {
  name: "quizs",
  components: {
    ContentEditor,
    MediaInput
  },
  props: {
    data: Array
  },
  data() {
    return {
      maxAns: 5,
      quizs: [
        {
          contentHtml: "",
          contentOrigin: { ops: [] },
          images: [],
          answers: [],
          correctAnswers: []
        }
      ]
    };
  },
  watch: {
    quizs: {
      handler(val) {
        this.$emit("changeContent", this.quizs);
      },
      deep: true
    },
    data: {
      handler: function(val) {
        this.quizs = this.data;
      },
      deep: true
    }
  },
  mounted() {
    if (this.data) {
      this.quizs = this.data;
    }
  },
  methods: {
    addQuiz() {
      this.quizs.push({
        contentHtml: "",
        contentOrigin: { ops: [] },
        images: [],
        answers: [],
        correctAnswers: []
      });
    },
    removeCard(paraIndex) {
      this.quizs.splice(paraIndex, 1);
    },
    createAnswer(paraIndex) {
      console.log("create new Answer");
      this.quizs[paraIndex].answers.push("");
    },
    delAnswer(index, paraIndex) {
      this.quizs[paraIndex].answers.splice(index, 1);
      this.quizs[paraIndex].correctAnswers.splice(
        this.quiz[paraIndex].correctAnswers.indexOf(index),
        1
      );
    },
    makeCorrectAnswer(index, paraIndex) {
      if (this.quizs[paraIndex].correctAnswers.includes(index)) {
        this.quizs[paraIndex].correctAnswers.splice(
          this.quizs[paraIndex].correctAnswers.indexOf(index),
          1
        );
      } else {
        this.quizs[paraIndex].correctAnswers.push(index);
      }
    },
    updateContent(content, paraIndex) {
      this.quizs[paraIndex].contentHtml = content.html;
      this.quizs[paraIndex].contentOrigin = content.origin;
    },
    updateImages(images, paraIndex) {
      this.quizs[paraIndex].images = images;
    },
    updateAnswer(value, index, paraIndex) {
      this.quizs[paraIndex].answers[index] = value;
    }
  }
};
</script>
