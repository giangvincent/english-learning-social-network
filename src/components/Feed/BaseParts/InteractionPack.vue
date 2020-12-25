<template>
  <div
    class="py-2 px-2 border-t-2 border-gray-400 flex content-center flex-wrap"
  >
    <div
      class="w-1/5 py-2 rounded-lg hover:bg-gray-300 focus:bg-gray-300 flex flex-col items-center justify-center flex-wrap font-bold relative"
      @click="saveClick(!saved)"
    >
      <bagged-icon :saved="saved"></bagged-icon>
      <span :class="{ 'text-green-500': !saved, 'text-red-500': saved }">{{
        saved ? "Bỏ học" : "Học"
      }}</span>
      <label
        class="m-1 absolute bg-color-blue font-semibold right-0 rounded-full text-center text-white text-xs top-0 numberIndicator"
        v-if="indicatorNum.nums_bagged > 10"
        >{{ indicatorNum.nums_bagged }}</label
      >
    </div>
    <!-- saved icon -->
    <div
      class="w-1/5 py-2 rounded-lg hover:bg-gray-300 focus:bg-gray-300 flex flex-col items-center justify-center flex-wrap font-bold relative"
      @click="goodClick(!goodVoted)"
    >
      <good-voted :goodVoted="goodVoted"></good-voted>
      <span :class="{ 'color-blue': goodVoted }">{{
        goodVoted ? "Good" : "Good?"
      }}</span>
      <label
        class="m-1 absolute bg-color-blue font-semibold right-0 rounded-full text-center text-white text-xs top-0 numberIndicator"
        v-if="indicatorNum.nums_good > 10"
        >{{ indicatorNum.nums_good }}</label
      >
    </div>
    <!-- good icon -->

    <div
      class="w-1/5 py-2 rounded-lg focus:bg-gray-300 flex flex-col items-center justify-center flex-wrap font-bold relative"
      @click="badClick(!badVoted)"
    >
      <bad-voted :badVoted="badVoted"></bad-voted>
      <span :class="{ 'color-blue': badVoted }">{{
        badVoted ? "Bad" : "Bad?"
      }}</span>
      <label
        class="m-1 absolute bg-color-blue font-semibold right-0 rounded-full text-center text-white text-xs top-0 numberIndicator"
        v-if="indicatorNum.nums_bad > 10"
        >{{ indicatorNum.nums_bad }}</label
      >
    </div>
    <!-- bad icon -->

    <div
      class="w-1/5 py-2 rounded-lg hover:bg-gray-300 focus:bg-gray-300 flex flex-col items-center justify-center flex-wrap font-bold color-blue relative"
    >
      <svg
        class="w-8 mx-auto"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        @click="shareClicked = !shareClicked"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
        />
      </svg>
      <span @click="shareClicked = !shareClicked">Share</span>
      <div
        class="bg-white absolute top-0 -mt-16 p-2 shadow-2xl rounded-lg"
        v-show="shareClicked"
      >
        <ul class="flex">
          <li class="m-1 w-10 h-10" @click="shareInit('facebook')">
            <img
              src="/assets/icons/fb_share.png"
              class="w-full rounded-lg"
              alt="facebook"
              width="40"
              height="40"
            />
          </li>
          <li class="m-1 w-10 h-10" @click="shareInit('link')">
            <svg
              class="w-full"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"
              />
            </svg>
          </li>
          <li class="m-1">
            <input
              class="h-10"
              ref="linkShare"
              type="text"
              :value="linkShare"
            />
          </li>
        </ul>
      </div>
    </div>
    <!-- Share icon -->

    <div
      class="w-1/5 py-2 rounded-lg hover:bg-gray-300 focus:bg-gray-300 flex flex-col items-center justify-center flex-wrap font-bold text-black-600 relative"
      @click="showModal = true"
    >
      <svg
        class="w-8 mx-auto"
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
      <span>Khác</span>
      <div class="shareHolder absolute"></div>
    </div>
    <!-- More icon -->

    <div
      v-show="showModal"
      class="modal-bg transition-all duration-500 fixed left-0 overflow-auto z-50 top-0 bottom-0 right-0 flex"
    >
      <div
        class="absolute w-full h-full bg-opacity-50 bg-black"
        @click="showModal = false"
      ></div>
      <div
        class="modal-content bg-white relative m-auto max-w-lg shadow-lg rounded-lg"
      >
        <div
          class="closeBtn absolute right-0 top-0 font-bold text-4xl w-10 h-10 flex justify-center items-center bg-gray-900 text-white rounded-full -m-4"
          @click="showModal = false"
        >
          &times;
        </div>
        <div class="py-3 px-3 flex flex-wrap">
          <router-link
            class="mx-2 p-2 flex flex-col items-center rounded-lg hover:bg-gray-300 focus:bg-gray-300"
            :to="`/p/${detailPostType}/${post_id}`"
          >
            <svg
              class="w-8"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"
              />
            </svg>
            <span class="font-bold text-center">Bình luận</span>
          </router-link>
          <div
            class="mx-2 p-2 flex flex-col items-center rounded-lg hover:bg-gray-300 focus:bg-gray-300"
            v-if="user.id !== author.id"
            @click="RequestReportPost()"
          >
            <svg
              class="w-8"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"
              />
            </svg>
            <span class="text-center font-bold">Báo cáo</span>
          </div>
          <div
            class="mx-2 p-2 flex flex-col items-center rounded-lg hover:bg-gray-300 focus:bg-gray-300"
            @click="goEditPost"
            v-if="user.id === author.id"
          >
            <svg
              class="w-8"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
              />
            </svg>
            <span class="text-center font-bold">Thay đổi</span>
          </div>
          <div
            class="mx-2 p-2 flex flex-col items-center rounded-lg hover:bg-gray-300 focus:bg-gray-300"
            @click="RequestDeletePost()"
            v-if="user.id === author.id"
          >
            <svg
              class="w-8"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
              />
            </svg>
            <span class="text-center font-bold">Xóa</span>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal other interaction -->
  </div>
  <!-- End interaction for user -->
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";
import BaggedIcon from "@/components/Icons/BaggedIcon.vue";
import GoodVoted from "@/components/Icons/GoodVoted.vue";
import BadVoted from "@/components/Icons/BadVoted.vue";
export default {
  name: "interaction-pack",
  props: {
    post_id: String,
    detailPostType: String,
    author: Object,
    indicatorNum: Object,
    interactOb: Object
  },
  components: {
    BadVoted,
    GoodVoted,
    BaggedIcon
  },
  data() {
    return {
      saved: false,
      goodVoted: false,
      badVoted: false,
      socialShareIcons: [
        "/assets/icons/fb_share.png",
        "/assets/icons/twittershare.png"
      ],
      shareClicked: false,
      showModal: false,
      linkShare: ""
    };
  },
  computed: {
    ...mapState({
      user: state => state.user.user,
      apiUrl: state => state.apiUrl
    })
  },
  watch: {
    interactOb: {
      handler(val) {
        this.saved = this.interactOb.bagged.includes(this.user.id);
        this.goodVoted = this.interactOb.good.includes(this.user.id);
        this.badVoted = this.interactOb.bad.includes(this.user.id);
      },
      deep: true
    }
  },
  mounted() {
    this.linkShare = this.apiUrl + "/share/" + this.post_id;
  },
  methods: {
    ...mapActions(["ReqInteract", "REQ_DEL_POST"]),
    ...mapMutations(["SET_current_action", "SET_edit_post_id"]),
    goEditPost() {
      this.SET_current_action("edit");
      this.SET_edit_post_id(this.post_id);
      this.$router.push("/creator");
    },
    RequestReportPost() {
      var self = this;
      setTimeout(function() {
        self
          .ReqInteract({
            post_id: self.post_id,
            interact: "report"
          })
          .then(res => {
            self.$toast.success("Báo cáo đã được gửi đi.");
          });
      }, 500);
    },
    RequestDeletePost() {
      this.REQ_DEL_POST(this.post_id)
        .then(res => {
          console.log(res);
          self.$toast.success("Bài viết đã xóa.");
        })
        .catch(error => {
          console.log(error);
        });
    },
    saveClick(status) {
      this.checkLogin();
      this.saved = !this.saved;
      var self = this;
      setTimeout(function() {
        self.ReqInteract({
          post_id: self.post_id,
          interact: status ? "bagged" : "un-bagged"
        });
      }, 500);
    },
    goodClick(status) {
      this.checkLogin();
      this.goodVoted = !this.goodVoted;
      var self = this;
      setTimeout(function() {
        self.ReqInteract({
          post_id: self.post_id,
          interact: status ? "good" : "un-good"
        });
      }, 500);
    },
    badClick(status) {
      this.checkLogin();
      this.badVoted = !this.badVoted;
      var self = this;
      setTimeout(function() {
        self.ReqInteract({
          post_id: self.post_id,
          interact: status ? "bad" : "un-bad"
        });
      }, 500);
    },
    checkLogin() {
      if (!this.user.id) {
        this.$router.push("/auth/login");
      }
    },
    shareInit(type) {
      this.shareClicked = !this.shareClicked;
      if (type === "facebook") {
        window.open(
          "https://www.facebook.com/sharer.php?u=" +
            encodeURIComponent(this.linkShare)
        );
      }

      if (type === "link") {
        this.$refs.linkShare.select();
        document.execCommand("copy");
        this.$toast.info("URL chia sẻ đã copy!");
      }
    }
  }
};
</script>
