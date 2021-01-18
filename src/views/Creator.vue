<template>
  <div>
    <simpleTopNav></simpleTopNav>

    <div class="my-6 md:px-6 lg:px-8 pb-20 mx-auto px-3">
      <div class="mx-auto max-w-lg">
        <div class="py-1">
          <span class="px-1 text-gray-600">Danh mục</span>
          <form-select
            :selectData="categories"
            :index="category"
            @changeSelectData="changeCategory"
          ></form-select>
        </div>
        <!-- pickup category -->
        <div class="py-1">
          <span class="px-1 text-gray-600">Loại bài viết</span>
          <div class="sm:rounded shadow bg-white">
            <div class="w-full mx-auto flex text-center font-bold">
              <div
                @click="changePostType('normalPost')"
                class="w-1/3 py-3 cursor-pointer"
                :class="{
                  'border-b-2 border-gray-900': postType == 'normalPost'
                }"
              >
                Bài viết
              </div>
              <div
                @click="changePostType('flashCard')"
                class="w-1/3 py-3 cursor-pointer"
                :class="{
                  'border-b-2 border-gray-900': postType == 'flashCard'
                }"
              >
                Flash Cards
              </div>
              <div
                @click="changePostType('quiz')"
                class="w-1/3 py-3 cursor-pointer"
                :class="{ 'border-b-2 border-gray-900': postType == 'quiz' }"
              >
                Câu đố
              </div>
            </div>
            <!-- END topbar lvl1 -->
          </div>
        </div>
        <!-- Choose post type -->
        <div class="py-1">
          <span class="px-1 text-gray-600">Chủ đề</span>
          <input
            placeholder="Chủ đề được giới hạn trong 250 ký tự"
            type="text"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
            v-model="subject"
          />
        </div>
        <!-- Subject of this post -->

        <normalPost
          v-if="postType == 'normalPost'"
          :data="postContent"
          @changeContent="changePostContent"
        ></normalPost>
        <flash-card
          v-if="postType == 'flashCard'"
          :data="postContent"
          @changeContent="changePostContent"
        ></flash-card>
        <quiz
          v-if="postType == 'quiz'"
          :data="postContent"
          @changeContent="changePostContent"
        ></quiz>

        <tags :tags="tags" @updateTags="changeTags"></tags>

        <button
          class="mt-3 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
          @click="submitContent"
        >
          <div
            v-if="!processPost"
            class="h-8 flex flex-wrap justify-center content-center"
          >
            <svg
              class="text-white w-5 inline mr-2"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
              />
            </svg>
            Đăng bài
          </div>
          <div v-if="processPost">
            <loading-icon></loading-icon>
          </div>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import formSelect from "@/components/Form/Select.vue";
import simpleTopNav from "@/components/Navigator/SimpleTopNav.vue";
import tags from "@/components/Creator/Tag.vue";
import normalPost from "@/components/Creator/ArticleContent.vue";
import flashCard from "@/components/Creator/FlashCard.vue";
import quiz from "@/components/Creator/Quiz.vue";
import { mapActions, mapMutations, mapState } from "vuex";
import LoadingIcon from "@/components/Icons/LoadingAnimate.vue";

export default {
  name: "creator",
  components: {
    simpleTopNav,
    formSelect,
    tags,
    normalPost,
    flashCard,
    quiz,
    LoadingIcon
  },
  data() {
    return {
      postType: "normalPost",
      category: 0,
      subject: "",
      postContent: null,
      tags: [],
      processPost: false,
      processUpImages: false,
      errors: []
    };
  },
  computed: {
    ...mapState({
      categories: state => state.categories,
      user: state => state.user.user,
      user_token: state => state.user.token,
      currentAction: state => state.creator.currentAction,
      editPostId: state => state.creator.editPostId
    })
  },
  watch: {
    postContent: function(newVal, oldVal) {
      if (newVal !== oldVal) {
        // console.log(newVal);
      }
    }
  },
  mounted() {
    console.log(this.currentAction, this.editPostId);
    if (!this.user_token || !this.user.id) {
      this.$router.push("/auth/login");
    }

    if (this.currentAction === "edit" && this.editPostId) {
      let self = this;
      fetch("/content/posts/" + this.editPostId + ".json")
        .then(res => res.json())
        .then(res => {
          // console.log(res);
          self.postType = res[0].type ? res[0].type : "normalPost";
          self.category = self.categories.findIndex(
            category => category.id === res[0].category.id
          );
          console.log(self.category);
          if (self.category == -1) {
            self.category = 0;
          }
          self.subject = res[0].subject;
          self.postContent = res[0].content;
          let tags = [];
          res[0].tags.forEach(tag => {
            tags.push(tag.name);
          });
          self.tags = tags;
        })
        .catch(err => console.log(err));
    }
  },
  methods: {
    ...mapMutations(["SET_current_action", "SET_edit_post_id"]),
    ...mapActions(["SUBMIT_POST", "Upload_image"]),
    changePostType(type) {
      this.postType = type;
    },
    changeCategory(index) {
      // console.log(index);
      this.category = index;
    },
    changePostContent(data) {
      this.postContent = data;
    },
    changeTags(data) {
      // console.log(data);
      this.tags = data;
    },
    submitContent() {
      this.processPost = true;
      this.processUpImages = true;
      let postData = {
        cat_id: this.categories[this.category].id,
        postType: this.postType,
        subject: this.subject,
        postContent: this.postContent,
        user: JSON.stringify(this.user),
        tags: JSON.stringify(this.tags)
      };
      if (!postData.postContent || postData.subject == "") {
        this.processPost = false;
        this.processUpImages = false;
        this.$toast.error("Nội dung trống trơn.");
        return false;
      }
      var self = this;
      var uploadImages = [];
      postData.postContent.forEach((content, contentIndex) => {
        content.images.forEach((image, imgIndex) => {
          uploadImages.push(
            self
              .Upload_image(image)
              .then(imageUrl => {
                // console.log(imageUrl);
                postData.postContent[contentIndex].images[imgIndex] = imageUrl;
              })
              .catch(error => {
                console.log(error);
                postData.postContent[contentIndex].images.splice(imgIndex, 1);
              })
          );
        });
      });
      Promise.all(uploadImages).then(() => {
        self.processUpImages = false;
        postData.postContent = JSON.stringify(postData.postContent);
        self
          .SUBMIT_POST(postData)
          .then(res => {
            // console.log(res);
            if (res.status) {
              self.$toast.success("Bài viết đã được đăng thành công.");
              self.$router.push(res.url || "/");
            } else {
              self.handleErr(res);
            }
          })
          .catch(error => {
            console.log(error);
            self.handleErr(error);
          })
          .finally(() => {
            self.processPost = false;
          });
      });
    },
    handleErr(err) {},
    resetData() {
      (this.postType = "normalPost"),
        (this.category = 0),
        (this.subject = ""),
        (this.postContent = null),
        (this.tags = []),
        (this.errors = []);
    }
  },
  beforeDestroy() {
    this.resetData();
  }
};
</script>

<style scoped></style>
