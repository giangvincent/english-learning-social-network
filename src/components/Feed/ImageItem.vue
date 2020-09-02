<template>
  <div
    class="shadow-2xl rounded-lg mb-6 tracking-wide w-full lg:w-6/12 md:w-6/12 bg-white md:mx-0 lg:mx-0"
  >
    <div class="w-full flex justify-between p-3">
      <div class="flex">
        <div class="rounded-full h-8 w-8 flex overflow-hidden">
          <img src="~@/assets/images/default_avatar.jpg" alt="profilepic" />
        </div>
        <div class="ml-2 font-bold flex content-center flex-wrap">braydoncoyer</div>
      </div>
      <div class="flex cursor-pointer content-center flex-wrap text-gray-500">2h ago</div>
    </div>
    <!-- End author info parts -->
    <slide-images></slide-images>
    <!-- End media -->

    <div class="px-3 pt-4">
      <div class="pb-4">
        <h4
          style="font-size: 20px; font-weight: bold"
        >The standard Lorem Ipsum passage, used since the 1500s</h4>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
          eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
          enim ad minim veniam, quis nostrud exercitation ullamco laboris
          nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
          reprehenderit in voluptate velit esse cillum dolore eu fugiat
          nulla pariatur. Excepteur sint occaecat cupidatat non proident,
          sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>
      </div>
      <!-- End content text -->
      <div class="pb-4">
        <span
          class="inline-block rounded-min text-gray-600 bg-gray-100 px-2 py-1 text-xs font-bold mr-3"
        >Default</span>
        <span
          class="inline-block rounded-full text-white bg-color-purple px-2 py-1 text-xs font-bold mr-1"
        >Tag 1</span>
        <span
          class="inline-block rounded-full text-white bg-color-purple px-2 py-1 text-xs font-bold mr-1"
        >Tag 2</span>
      </div>
      <!-- End relation label -->
      <div class="py-2 border-t-2 border-gray-400 flex content-center flex-wrap">
        <div
          class="w-1/4 py-2 px-6 rounded-lg hover:bg-gray-300 text-center font-bold text-red-600"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path
              d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"
            />
          </svg>
          <span>Lưu</span>
        </div>
        <!-- saved icon -->
        <div class="w-1/4 py-2 px-6 rounded-lg hover:bg-gray-300 text-center font-bold color-blue">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path
              d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"
            />
          </svg>
          <span>Thích</span>
        </div>
        <!-- Like icon -->

        <div class="w-1/4 py-2 px-6 rounded-lg hover:bg-gray-300 text-center font-bold color-blue">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path
              d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"
            />
          </svg>
          <span>Share</span>
        </div>
        <!-- Share icon -->

        <div
          class="w-1/4 py-2 px-6 rounded-lg hover:bg-gray-300 text-center font-bold text-black-600"
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
              d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <span>More</span>
        </div>
        <!-- More icon -->
      </div>
      <!-- End interaction for user -->
    </div>
  </div>
  <!-- END post -->
</template>

<script>
import slideImages from "./SlideImages";
export default {
  name: "image-item",
  components: {
    slideImages,
  },
};
</script>