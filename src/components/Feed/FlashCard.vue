<template>
  <div
    class="md:mx-2 border-t-2 shadow-xl rounded-lg mb-6 tracking-wide w-full relative"
  >
    <div class="w-full flex justify-between p-3">
      <div class="flex">
        <div class="rounded-full h-8 w-8 flex overflow-hidden">
          <img src="~@/assets/images/default_avatar.jpg" alt="profilepic" />
        </div>
        <div class="ml-2 font-bold flex content-center flex-wrap">
          braydoncoyer
        </div>
      </div>
      <div class="flex cursor-pointer items-center flex-wrap">
        <div
          class="bg-gray-700 border-2 border-white text-white text-center font-bold rounded-full p-1 mx-2"
        >
          Card 2/10
        </div>
        <span class="text-gray-500">
          2h ago
        </span>
      </div>
    </div>
    <!-- End author info parts -->

    <!-- card indicator -->
    <div ref="frontCard">
      <div class="mx-auto bg-color-black">
        <img class="w-full" src="@/assets/images/default-vertical.jpg" />
      </div>
      <!-- End media -->
      <div class="px-3 py-4">
        <h2>This is a Heading H2</h2>
        <p>
          <span class="ql-size-small">this is a small with </span
          ><span class="ql-size-small" style="color: rgb(230, 0, 0);"
            >COLOR TEXT</span
          >
        </p>
        <p class="ql-align-center">
          <span class="ql-size-large ql-font-monospace"
            >This is a large Text with </span
          ><span
            class="ql-size-large ql-font-monospace"
            style="background-color: rgb(255, 255, 102);"
            >background</span
          >
        </p>
      </div>
      <!-- End content text -->
      <div class="px-3 pb-4 flex flex-row">
        <textarea
          placeholder="Nội dung mặt sau"
          type="text"
          class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
        ></textarea>
        <button
          class="flex-1 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
        >
          Review
        </button>
      </div>
      <!-- Review back card -->
    </div>
    <!-- front card -->

    <div ref="backCard">
      <div class="mx-auto bg-color-black">
        <img class="w-full" src="@/assets/images/default-vertical.jpg" />
      </div>
      <!-- End media -->
      <div class="px-3 py-4">
        <h2>This is a Heading H2</h2>
        <p>
          <span class="ql-size-small">this is a small with </span
          ><span class="ql-size-small" style="color: rgb(230, 0, 0);"
            >COLOR TEXT</span
          >
        </p>
        <p class="ql-align-center">
          <span class="ql-size-large ql-font-monospace"
            >This is a large Text with </span
          ><span
            class="ql-size-large ql-font-monospace"
            style="background-color: rgb(255, 255, 102);"
            >background</span
          >
        </p>
      </div>
      <!-- End content text -->
      <div class="px-3 pb-4 flex flex-row ">
        <div
          class="flex flex-wrap content-center justify-center text-md block px-3 py-2 rounded-lg w-full bg-white border-2 bg-white border-gray-600 focus:outline-none"
        >
          Your answer
        </div>
        <button
          class="flex-1 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
        >
          Next Card
        </button>
      </div>
      <!-- Review back card -->
    </div>
    <!-- Back card -->

    <div class="px-3 pb-4">
      <span
        class="inline-block rounded-min text-gray-600 bg-gray-100 px-2 py-1 text-xs font-bold mr-3"
        >Default</span
      >
      <span
        class="inline-block rounded-full text-white bg-color-purple px-2 py-1 text-xs font-bold mr-1"
        >Tag 1</span
      >
      <span
        class="inline-block rounded-full text-white bg-color-purple px-2 py-1 text-xs font-bold mr-1"
        >Tag 2</span
      >
    </div>
    <!-- End relation label -->
    <interaction-pack></interaction-pack>
  </div>
</template>

<script>
// import slideImages from "./SlideImages";
import interactionPack from "./InteractionPack";
export default {
  name: "Feed-flash-card",
  components: {
    interactionPack
  }
};
</script>
