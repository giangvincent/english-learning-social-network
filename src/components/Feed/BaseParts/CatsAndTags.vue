<template>
  <div class="px-3 pb-4">
    <router-link
      :to="`/${postData.category.slug}`"
      class="inline-block rounded-min text-gray-600 bg-gray-100 px-2 py-1 text-xs font-bold mr-3"
      >{{ postData.category.name }}</router-link
    >
    <router-link
      :to="`/tag/${tag.slug}`"
      v-for="(tag, tagIndex) in postData.tags"
      :key="`tag-${tagIndex}`"
      class="inline-block rounded-full text-white bg-color-purple px-2 py-1 text-xs font-bold mr-1"
      >{{ tag.name }}</router-link
    >
  </div>
</template>

<script>
export default {
  name: "Cats and Tags",
  props: {
    postData: Object
  }
};
</script>
