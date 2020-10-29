<template>
  <div
    class="md:mx-2 border-t-2 shadow-xl rounded-lg mb-6 tracking-wide w-full bg-white"
  >
    <div class="w-full flex justify-between p-3">
      <div class="flex">
        <router-link
          :to="`/u/${postData.author.id}`"
          class="rounded-full h-8 w-8 flex overflow-hidden"
        >
          <img
            :src="
              postData.author.avatar !== ''
                ? postData.author.avatar
                : '~@/assets/images/default_avatar.jpg'
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
        :to="`/p/${pid}`"
        class="flex text-sm cursor-pointer content-center flex-wrap text-gray-500"
      >
        {{ shortTime }} trước
      </router-link>
    </div>
    <!-- End author info parts -->
    <div
      v-for="(content, index) in postData.content"
      :key="`PostData-${index}`"
    >
      <div class="mx-auto bg-color-black">
        <img
          v-for="(image, imgIndex) in content.images"
          :key="`content.images.${imgIndex}`"
          class="w-full"
          :src="rootUrl + image"
        />
      </div>
      <!-- End media -->
      <div class="px-3 py-4" v-html="content.contentHtml"></div>
      <!-- End content text -->
    </div>

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
    <!-- End relation label -->
    <interaction-pack></interaction-pack>
  </div>
  <!-- END post -->
</template>

<script>
import { mapState } from "vuex";
// import slideImages from "./SlideImages";
import interactionPack from "./InteractionPack";
export default {
  name: "image-item",
  props: {
    pid: String
  },
  components: {
    interactionPack
  },
  data() {
    return {
      shortTime: "",
      postData: {
        author: {
          id: 1,
          full_name: "loading",
          nick_name: "loading",
          avatar: ""
        },
        content: [
          {
            contentHtml: "<p>loading...</p>",
            images: [""]
          }
        ],
        category: {
          id: 1,
          name: "loading",
          slug: "loading"
        },
        tags: []
      }
    };
  },
  computed: {
    ...mapState({
      rootUrl: state => state.rootUrl
    })
  },
  mounted() {
    var self = this;
    fetch("/content/posts/" + this.pid + ".json")
      .then(res => res.json())
      .then(res => {
        console.log(res);
        self.postData = res[0];
        self.shortTimer = evaluateTime(self.postData.datetime);
      })
      .catch(err => console.log(err));
  }
};

function evaluateTime(beginTime) {
  let timeString = new Date(beginTime).getTime() / 1000;
  let timeNow = new Date().getTime() / 1000;
  let distanceTime = parseInt(timeNow) - timeString;
  let yearInSecond = 31536000;
  let monthInSecond = 2592000;
  let weekInSecond = 604800;
  let dayInSecond = 86400;
  let hourInsecond = 3600;
  let minuteInSecond = 60;
  if (distanceTime > yearInSecond) {
    return parseInt(distanceTime / yearInSecond) + " năm";
  } else if (distanceTime > monthInSecond) {
    return parseInt(distanceTime / monthInSecond) + " tháng";
  } else if (distanceTime > weekInSecond) {
    return parseInt(distanceTime / weekInSecond) + " tuần";
  } else if (distanceTime > dayInSecond) {
    return parseInt(distanceTime / dayInSecond) + " ngày";
  } else if (distanceTime > hourInsecond) {
    return parseInt(distanceTime / hourInsecond) + " giờ";
  } else if (distanceTime > minuteInSecond) {
    return parseInt(distanceTime / minuteInSecond) + " phút";
  } else {
    return parseInt(distanceTime) + " giây";
  }
}
</script>
