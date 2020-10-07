<template>
  <div
    class="md:mx-2 border-t-2 shadow-xl rounded-lg mb-6 tracking-wide w-full bg-white"
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
      <router-link
        to="/p/test-detail-quiz"
        class="flex cursor-pointer content-center flex-wrap text-gray-500"
      >
        2h ago
      </router-link>
    </div>
    <!-- End author info parts -->

    <div class="px-3 pb-4">
      <h4 style="font-size: 20px; font-weight: bold">
        The standard Lorem Ipsum passage, used since the 1500s
      </h4>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
        veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
        commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
        velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
        occaecat cupidatat non proident, sunt in culpa qui officia deserunt
        mollit anim id est laborum.
      </p>
    </div>
    <!-- End content text -->
    <div class="mx-auto bg-color-black mb-4">
      <img class="w-full" src="@/assets/images/default-vertical.jpg" />
    </div>
    <!-- End media -->

    <div class="py-3 text-sm">
      <span class="px-2">Các đáp án là :</span>
      <div
        class="flex justify-start cursor-pointer text-md rounded-lg bg-white border-2 hover:border-gray-600 py-2 m-2 border-black"
      >
        <div class="px-2 font-bold">Tighten Co.</div>
      </div>
      <div
        class="flex justify-start cursor-pointer text-md rounded-lg bg-white border-2 hover:border-gray-600 py-2 m-2 border-red-700 bg-red-400"
      >
        <div class="px-2 font-bold">Taylor Otwell</div>
      </div>
      <div
        class="flex justify-start cursor-pointer text-md rounded-lg bg-white border-2 hover:border-gray-600 py-2 m-2 border-green-800 bg-green-400"
      >
        <div class="px-2 font-bold">Adam Wathan</div>
      </div>
      <div
        class="flex justify-start cursor-pointer text-md rounded-lg bg-white border-2 border-gray-300 hover:border-gray-600 py-2 m-2"
      >
        <div class="px-2">Duke Street Studio Inc.</div>
      </div>
      <div
        class="flex justify-start cursor-pointer text-md rounded-lg bg-white border-2 border-gray-300 hover:border-gray-600 py-2 m-2"
      >
        <div class="px-2">Jeffrey Wey</div>
      </div>
    </div>

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
import interactionPack from "./InteractionPack";
export default {
  name: "feed-quiz",
  components: {
    interactionPack
  }
};
</script>
