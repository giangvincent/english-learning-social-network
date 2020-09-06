<template>
  <div>
    <!--Nav-->
    <nav id="header" class="bg-white w-full shadow">
      <div
        class="w-full container mx-auto flex flex-wrap items-center mt-0 px-4 justify-between sm:justify-center"
      >
        <label for="menu-toggle" class="cursor-pointer py-2" @click="$router.go(-1)">
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
    <div class="sm:rounded shadow max-w-lg mx-auto mt-10">
      <div class="w-full mx-auto flex text-center font-bold">
        <a href class="w-1/3 py-3 border-b-2 border-gray-900">Từ vựng</a>
        <a href class="w-1/3 py-3">Video</a>
        <a href class="w-1/3 py-3">Bài viết</a>
      </div>
      <!-- END topbar lvl1 -->
    </div>
    <!-- User info -->
    <div class="my-6 md:px-6 lg:px-8 pb-20 mx-auto px-3">
      <div class="mx-auto max-w-lg">
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Nội dung</span>
          <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
            <div class="menubar">
              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.bold() }"
                @click="commands.bold"
              >
                <icon name="bold" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.italic() }"
                @click="commands.italic"
              >
                <icon name="italic" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.strike() }"
                @click="commands.strike"
              >
                <icon name="strike" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.underline() }"
                @click="commands.underline"
              >
                <icon name="underline" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.code() }"
                @click="commands.code"
              >
                <icon name="code" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.paragraph() }"
                @click="commands.paragraph"
              >
                <icon name="paragraph" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.heading({ level: 1 }) }"
                @click="commands.heading({ level: 1 })"
              >H1</button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.heading({ level: 2 }) }"
                @click="commands.heading({ level: 2 })"
              >H2</button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.heading({ level: 3 }) }"
                @click="commands.heading({ level: 3 })"
              >H3</button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.bullet_list() }"
                @click="commands.bullet_list"
              >
                <icon name="ul" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.ordered_list() }"
                @click="commands.ordered_list"
              >
                <icon name="ol" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.blockquote() }"
                @click="commands.blockquote"
              >
                <icon name="quote" />
              </button>

              <button
                class="menubar__button"
                :class="{ 'is-active': isActive.code_block() }"
                @click="commands.code_block"
              >
                <icon name="code" />
              </button>

              <button class="menubar__button" @click="commands.horizontal_rule">
                <icon name="hr" />
              </button>

              <button class="menubar__button" @click="commands.undo">
                <icon name="undo" />
              </button>

              <button class="menubar__button" @click="commands.redo">
                <icon name="redo" />
              </button>
            </div>
          </editor-menu-bar>
          <editor-content
            :editor="editor"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
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

        <button
          class="mt-3 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
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
import Icon from "@/components/Creator/Icon.vue";
import { Editor, EditorContent, EditorMenuBar } from "tiptap";
import {
  Blockquote,
  CodeBlock,
  HardBreak,
  Heading,
  HorizontalRule,
  OrderedList,
  BulletList,
  ListItem,
  TodoItem,
  TodoList,
  Bold,
  Code,
  Italic,
  Link,
  Strike,
  Underline,
  History,
} from "tiptap-extensions";
export default {
  components: {
    logo,
    Icon,
    EditorMenuBar,
    EditorContent,
  },
  data() {
    return {
      editor: new Editor({
        extensions: [
          new Blockquote(),
          new BulletList(),
          new CodeBlock(),
          new HardBreak(),
          new Heading({ levels: [1, 2, 3] }),
          new HorizontalRule(),
          new ListItem(),
          new OrderedList(),
          new TodoItem(),
          new TodoList(),
          new Link(),
          new Bold(),
          new Code(),
          new Italic(),
          new Strike(),
          new Underline(),
          new History(),
        ],
        content: "<p>This is just a boring paragraph</p>",
      }),
    };
  },
  beforeDestroy() {
    // Always destroy your editor instance when it's no longer needed
    this.editor.destroy();
  },
};
</script>