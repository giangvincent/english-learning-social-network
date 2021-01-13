<template>
  <div class="px-3 pb-4">
    <router-link
      :to="`/${postData.category.slug}`"
      class="inline-block rounded-min text-gray-600 bg-gray-100 px-2 py-1 text-xs font-bold mr-3"
      ><svg
        class="w-4 inline"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"
        />
      </svg>
      {{ postData.category.name }}</router-link
    >
    <router-link
      :to="`/tag/${tag.slug}`"
      v-for="(tag, tagIndex) in postData.tags"
      :key="`tag-${tagIndex}`"
      class="inline-block rounded-full text-white bg-color-purple px-2 py-1 text-xs font-bold mr-1 mb-1"
      >#{{ tag.name }}</router-link
    >
  </div>
</template>

<script>
export default {
  name: "Cats-and-Tags",
  props: {
    postData: Object
  }
};
</script>
