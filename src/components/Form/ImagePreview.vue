<template>
  <div
    class="content-center flex items-center justify-between flex-wrap mt-3 px-1 text-gray-600 text-sm px-1 text-sm text-gray-600"
  >
    <span>Hình ảnh</span>
    <button
      type="button"
      class="font-semibold text-white rounded-lg px-3 py-2 btn-hover bg-color-blue"
      @click="previewImage()"
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
    <input
      ref="imgInput"
      type="file"
      class="hidden"
      accept="images/*"
      multiple
    />
    <div class="w-full my-4" ref="imageContainer"></div>
  </div>
</template>

<script>
export default {
  name: "image-preview",
  data() {
    return {};
  }
};
</script>
