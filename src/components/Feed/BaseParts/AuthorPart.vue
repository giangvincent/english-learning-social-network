<template>
  <div class="w-full flex justify-between p-3">
    <div class="flex">
      <router-link
        :to="`/u/${postData.author.id}`"
        class="rounded-full h-8 w-8 flex overflow-hidden"
      >
        <img
          :src="
            postData.author.avatar
              ? postData.author.avatar
              : '/assets/images/default_avatar.jpg'
          "
          alt="profilepic"
        />
      </router-link>
      <router-link
        :to="`/u/${postData.author.id}`"
        class="ml-2 font-bold flex content-center flex-wrap"
      >
        {{ postData.author.full_name }}
      </router-link>
    </div>
    <router-link
      :to="`/p/${detailPostType}/${pid}`"
      class="flex text-sm cursor-pointer content-center flex-wrap text-gray-500"
    >
      {{ shortTimer }} trước
    </router-link>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  name: "author-part",
  props: {
    postData: Object,
    shortTimer: String,
    detailPostType: String,
    pid: String
  },
  computed: {
    ...mapState({
      rootUrl: state => state.rootUrl
    })
  }
};
</script>
