<template>
  <div>
    <simpleTopNav></simpleTopNav>
    <div
      v-if="page === 'login'"
      class="container mx-auto p-6 mnd:p-12 mt-6 relative flex flex-wrap md:w-6/12"
    >
      <div class="w-full text-sm text-center font-semibold">
        Bạn hãy vui lòng điền đầy đủ thông tin bên dưới.
      </div>

      <div class="mt-8 w-full mx-auto">
        <div class="py-2">
          <span class="px-1 text-sm text-gray-600">Địa chỉ Email</span>
          <input
            placeholder
            type="text"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
            autocomplete="email"
            v-model="email"
          />
        </div>
        <div class="py-2" x-data="{ show: true }">
          <span class="px-1 text-sm text-gray-600">Mật khẩu</span>
          <div class="relative">
            <input
              placeholder
              :type="!showPass ? 'password' : 'text'"
              class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
              v-model="password"
              autocomplete="password"
            />
            <div
              class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
            >
              <svg
                class="h-6 text-gray-700"
                fill="none"
                @click="showPass = !showPass"
                :class="{ hidden: !showPass, block: showPass }"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 576 512"
              >
                <path
                  fill="currentColor"
                  d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"
                />
              </svg>

              <svg
                class="h-6 text-gray-700"
                fill="none"
                @click="showPass = !showPass"
                :class="{ block: !showPass, hidden: showPass }"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 640 512"
              >
                <path
                  fill="currentColor"
                  d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z"
                />
              </svg>
            </div>
          </div>
        </div>
        <div class="flex justify-between">
          <label class="block text-gray-500 font-bold my-4">
            <input
              type="checkbox"
              class="leading-loose text-pink-600"
              v-model="keepLogin"
            />
            <span class="pl-2 py-2 text-sm text-gray-600 leading-snug"
              >Nhớ tài khoản cho lần sau</span
            >
          </label>
        </div>
        <button
          class="mt-3 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
          @click="sendLogin()"
        >
          <span v-if="!processApi"> Đăng nhập </span>
          <div v-if="processApi">
            <loading-icon></loading-icon>
          </div>
        </button>
        <div class="flex flex-col flex-wrap content-center text-center">
          <label class="block text-gray-500 font-bold my-4">
            <a
              href="#"
              class="cursor-pointer tracking-tighter border-b-2 border-gray-400 hover:border-gray-600"
            >
              <span>Quên mật khẩu?</span>
            </a>
          </label>
          <div class="text-sm font-semibold block py-3">
            <a @click="changeAuthRoute('register')" class="font-normal">
              Bạn chưa có tài khoản?
              <br />
              <span
                class="font-semibold border-b-2 border-gray-400 hover:border-teal-500"
                >Đăng ký ở đây nè</span
              >
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- End login tab -->

    <div
      v-if="page === 'register'"
      class="container mx-auto p-6 md:p-12 mt-6 relative flex flex-wrap md:w-6/12"
    >
      <div class="w-full">
        <div class="text-center font-semibold">
          Bạn hãy vui lòng điền đầy đủ thông tin bên dưới
        </div>
        <div class="text-center font-base">
          Mọi thông tin của bạn đều được chúng tôi bảo mật trong CSDL của chúng
          tôi.
        </div>
      </div>
      <div class="mt-8 mx-auto w-full">
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Họ tên đầy đủ</span>
          <input
            placeholder
            type="text"
            v-model="registerData.full_name"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Tên hiển thị</span>
          <input
            placeholder
            type="text"
            v-model="registerData.nick_name"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Ngày sinh</span>
          <input
            placeholder
            type="date"
            v-model="registerData.birthday"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Email</span>
          <input
            placeholder
            type="email"
            v-model="registerData.email"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Mật khẩu</span>
          <div class="relative">
            <input
              placeholder
              :type="!showPass ? 'password' : 'text'"
              v-model="registerData.password"
              class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
            />
            <div
              class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
            >
              <svg
                class="h-6 text-gray-700"
                fill="none"
                @click="showPass = !showPass"
                :class="{ hidden: !showPass, block: showPass }"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 576 512"
              >
                <path
                  fill="currentColor"
                  d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"
                />
              </svg>

              <svg
                class="h-6 text-gray-700"
                fill="none"
                @click="showPass = !showPass"
                :class="{ block: !showPass, hidden: showPass }"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 640 512"
              >
                <path
                  fill="currentColor"
                  d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z"
                />
              </svg>
            </div>
          </div>
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Xác nhận mật khẩu</span>
          <input
            placeholder
            type="password"
            v-model="registerData.password_confirm"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>

        <div class="flex justify-start">
          <label class="block text-gray-500 font-bold my-4 flex items-center">
            <input
              class="leading-loose text-pink-600 top-0"
              type="checkbox"
              v-model="registerData.accept_term"
            />
            <span class="ml-2 text-sm py-2 text-gray-600 text-left">
              Bằng cách đánh dấu vào mục này bạn đã đồng ý tuân thủ
              <a
                href="#"
                class="font-semibold border-b-2 border-gray-200 hover:border-gray-500 text-black"
                >Điều Khoản</a
              >
              và
              <a
                href="#"
                class="font-semibold border-b-2 border-gray-200 hover:border-gray-500 text-black"
                >Chính Sách</a
              >
              của website.
            </span>
          </label>
        </div>
        <button
          class="mt-3 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
          @click="sendRegister()"
        >
          <span v-if="!processApi"> Đăng ký tài khoản </span>
          <div v-if="processApi">
            <loading-icon></loading-icon>
          </div>
        </button>
        <div class="text-sm font-semibold block py-6 flex justify-center">
          <a
            @click="changeAuthRoute('login')"
            class="font-normal border-b-2 border-gray-200 hover:border-teal-500"
          >
            Bạn đã có tài khoản?
            <span class="font-semibold">Đăng nhập tại đây</span>
          </a>
        </div>
      </div>
    </div>
    <!-- End register tab -->
  </div>
</template>

<script>
import simpleTopNav from "@/components/Navigator/SimpleTopNav.vue";
import { mapActions, mapMutations, mapState } from "vuex";
import LoadingIcon from "@/components/Icons/LoadingAnimate.vue";

function validateEmail(email) {
  const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

export default {
  name: "Authenticate",
  components: {
    LoadingIcon,
    simpleTopNav,
  },
  data() {
    return {
      processApi: false,
      showPass: false,
      registerData: {
        full_name: "",
        nick_name: "",
        birthday: new Date().getDate(),
        email: "",
        password: "",
        password_confirm: "",
        accept_term: false,
      },
      email: "",
      password: "",
      page: "login",
      keepLogin: true,
    };
  },
  watch: {
    email: function (newVal, oldVal) {
      if (newVal && newVal !== oldVal) {
        let checkEmail = validateEmail(newVal);
        console.log(checkEmail);
      }
    },
  },
  computed: {
    ...mapState({
      user: (state) => state.user.user,
      user_token: (state) => state.user.token,
    }),
  },
  created() {
    this.page = "login";
    if (
      typeof this.$route.params.page !== "undefined" &&
      this.$route.params.page === "register"
    ) {
      this.page = "register";
    }

    if (
      typeof this.$route.params.page !== "undefined" &&
      this.$route.params.page === "logout"
    ) {
      if (this.isLocalStorage()) {
        localStorage.clear();
        this.SET_USER({});
        this.SET_TOKEN(null);
        this.$toast.success("Đăng xuất thành công.");
        this.$router.push("/");
      }
    }
  },
  mounted() {
    if (this.isLocalStorage() && !this.user_token) {
      let user_token = localStorage.getItem("user_token");
      let user = localStorage.getItem("user");
      console.log(JSON.parse(user_token), JSON.parse(user));
      if (user_token && user) {
        this.SET_USER(JSON.parse(user));
        this.SET_TOKEN(JSON.parse(user_token));
        this.$router.go(-1);
      }
    } else {
      this.$router.go(-1);
    }
  },
  methods: {
    ...mapActions(["LOGIN", "REGISTER"]),
    ...mapMutations(["SET_USER", "SET_TOKEN"]),
    changeAuthRoute(Auth) {
      this.page = Auth;
      this.$router.push("/auth/" + Auth);
    },
    sendLogin() {
      if (
        this.email !== "" &&
        this.password !== "" &&
        !this.processApi &&
        validateEmail(this.email)
      ) {
        this.processApi = true;
        let self = this;
        this.LOGIN({ email: this.email, password: this.password })
          .then((res) => {
            self.processApi = false;
            if (self.keepLogin && self.isLocalStorage()) {
              localStorage.setItem("user", JSON.stringify(res.user));
              localStorage.setItem("user_token", JSON.stringify(res.token));
            }
            self.$router.go(-1);
          })
          .catch((err) => {
            self.processApi = false;
          });
      }
    },
    sendRegister() {
      const isEmpty = !Object.values(this.registerData).some(
        (data) => data !== null && data !== ""
      );
      if (
        !isEmpty &&
        !this.processApi &&
        validateEmail(this.registerData.email)
      ) {
        this.processApi = true;
        let self = this;
        this.REGISTER(this.registerData)
          .then((res) => {
            self.processApi = false;
            if (self.isLocalStorage()) {
              localStorage.setItem("user", JSON.stringify(res.success.user));
              localStorage.setItem(
                "user_token",
                JSON.stringify(res.success.token)
              );
            }
            self.$router.go(-1);
          })
          .catch((err) => {
            self.processApi = false;
          });
      }
    },
  },
};
</script>
