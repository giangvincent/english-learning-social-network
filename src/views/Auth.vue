<template>
  <div>
    <div
      v-if="page === 'login'"
      class="container mx-auto p-6 mnd:p-12 mt-6 relative flex flex-wrap md:w-6/12"
    >
      <div class="w-full mb-5 pb-1 text-center font-base text-gray-700">
        <router-link
          class="items-center hover:no-underline font-bold text-gray-800 text-xl uppercase"
          to="/"
          >ohitsgood</router-link
        >
      </div>
      <div class="w-full text-sm text-center font-semibold">
        Lorem ipsum dolor, sit amet?
      </div>

      <div class="mt-8 w-full mx-auto">
        <div class="py-2">
          <span class="px-1 text-sm text-gray-600">Username</span>
          <input
            placeholder
            type="text"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-2" x-data="{ show: true }">
          <span class="px-1 text-sm text-gray-600">Password</span>
          <div class="relative">
            <input
              placeholder
              :type="showPass ? 'password' : 'text'"
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
        <div class="flex justify-between">
          <label class="block text-gray-500 font-bold my-4">
            <input type="checkbox" class="leading-loose text-pink-600" />
            <span class="pl-2 py-2 text-sm text-gray-600 leading-snug"
              >Nhớ tài khoản cho lần sau</span
            >
          </label>
        </div>
        <button
          class="mt-3 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
          @click="login()"
        >
          Đăng nhập
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
      <div
        class="w-full mb-5 pb-1border-b-2 text-center font-base text-gray-700"
      >
        <router-link
          class="items-center hover:no-underline font-bold text-gray-800 text-xl uppercase"
          to="/"
          >ohitsgood</router-link
        >
      </div>
      <div class="w-full">
        <div class="text-center font-semibold">Lorem ipsum dolor</div>
        <div class="text-center font-base">Sed ut perspiciatis unde?</div>
      </div>
      <div class="mt-8 mx-auto w-full">
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Username</span>
          <input
            placeholder
            type="text"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Email</span>
          <input
            placeholder
            type="email"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Password</span>
          <input
            placeholder
            type="password"
            x-model="password"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Password Confirm</span>
          <input
            placeholder
            type="password"
            x-model="password_confirm"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="flex justify-start mt-3 ml-4 p-1">
          <ul>
            <li class="flex items-center py-1">
              <div
                :class="{
                  'bg-green-200 text-green-700':
                    password == password_confirm && password.length > 0,
                  'bg-red-200 text-red-700':
                    password != password_confirm || password.length == 0,
                }"
                class="rounded-full p-1 fill-current"
              >
                <svg
                  class="w-4 h-4"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    x-show="password == password_confirm && password.length > 0"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"
                  />
                  <path
                    x-show="password != password_confirm || password.length == 0"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </div>
              <span
                :class="{
                  'text-green-700':
                    password == password_confirm && password.length > 0,
                  'text-red-700':
                    password != password_confirm || password.length == 0,
                }"
                class="font-medium text-sm ml-3"
                x-text="password == password_confirm && password.length > 0 ? 'Passwords match' : 'Passwords do not match' "
              ></span>
            </li>
            <li class="flex items-center py-1">
              <div
                :class="{
                  'bg-green-200 text-green-700': password.length > 7,
                  'bg-red-200 text-red-700': password.length < 7,
                }"
                class="rounded-full p-1 fill-current"
              >
                <svg
                  class="w-4 h-4"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    x-show="password.length > 7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"
                  />
                  <path
                    x-show="password.length < 7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </div>
              <span
                :class="{
                  'text-green-700': password.length > 7,
                  'text-red-700': password.length < 7,
                }"
                class="font-medium text-sm ml-3"
                x-text="password.length > 7 ? 'The minimum length is reached' : 'At least 8 characters required' "
              ></span>
            </li>
          </ul>
        </div>
        <div class="flex justify-start">
          <label class="block text-gray-500 font-bold my-4 flex items-center">
            <input class="leading-loose text-pink-600 top-0" type="checkbox" />
            <span class="ml-2 text-sm py-2 text-gray-600 text-left">
              Accept the
              <a
                href="#"
                class="font-semibold border-b-2 border-gray-200 hover:border-gray-500 text-black"
                >Terms and Conditions of the site</a
              >and
              <a
                href="#"
                class="font-semibold border-b-2 border-gray-200 hover:border-gray-500 text-black"
                >the information data policy.</a
              >
            </span>
          </label>
        </div>
        <button
          class="mt-3 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
          @click="register()"
        >
          Register
        </button>
        <div class="text-sm font-semibold block py-6 flex justify-center">
          <a
            @click="changeAuthRoute('login')"
            class="font-normal border-b-2 border-gray-200 hover:border-teal-500"
          >
            You're already member?
            <span class="font-semibold">Login</span>
          </a>
        </div>
      </div>
    </div>
    <!-- End register tab -->
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
function validateEmail(email) {
  const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}
export default {
  name: "Authenticate",
  data() {
    return {
      showPass: false,
      full_name: "",
      nickname: "",
      email: "",
      password: "",
      password_confirm: "",
      page: "login",
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
    ...mapState(["apiUrl"]),
  },
  created() {
    if (
      typeof this.$route.params.page !== "undefined" &&
      this.$route.params.page === "register"
    ) {
      this.page = "register";
    } else this.page = "login";
  },
  mounted() {},
  methods: {
    ...mapActions(["LOGIN", "REGISTER"]),
    changeAuthRoute(Auth) {
      this.page = Auth;
      this.$router.push("/auth/" + Auth);
    },
    login() {
      this.$router.push("/u/1");
    },
    register() {
      this.$router.push("/u/1");
    },
  },
};
</script>