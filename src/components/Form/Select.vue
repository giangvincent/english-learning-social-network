<template>
  <div class="flex flex-col items-center relative">
    <div class="w-full">
      <div
        class="my-2 flex text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
        @click="initPick = !initPick"
        @focus="initPick = !initPick"
      >
        <div class="flex flex-auto flex-wrap"></div>
        <input
          placeholder="Click để chọn"
          class="p-1 px-2 appearance-none w-full text-gray-800"
          :value="selectData[index] ? selectData[index].name : ''"
        />
        <div
          class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200"
        >
          <button
            class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="100%"
              height="100%"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="feather feather-chevron-up w-4 h-4"
              :class="{ hidden: initPick }"
            >
              <polyline points="18 15 12 9 6 15"></polyline>
            </svg>
            <svg
              :class="{ hidden: !initPick }"
              class="feather feather-chevron-up w-4 h-4"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>
    <div
      :class="{ hidden: !initPick }"
      class="absolute shadow-lg bg-white top-0 z-40 w-full left-0 mt-16 rounded max-h-select overflow-y-auto"
      @click="initPick = false"
    >
      <div class="flex flex-col w-full">
        <div
          class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-teal-100"
          v-for="(data, index) in selectData"
          @click="$emit('changeSelectData', index)"
          :key="`select-${index}`"
        >
          <div
            class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100"
          >
            <div class="w-full items-center flex">
              <div class="mx-2 -mt-1">
                {{ data.name }}
                <div
                  class="text-xs truncate w-full normal-case font-normal -mt-1 text-gray-500"
                >
                  {{ data.description || "" }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "form-select",
  props: {
    selectData: Array,
    index: Number
  },
  data() {
    return {
      initPick: false,
      picked: 0
    };
  }
};
</script>
