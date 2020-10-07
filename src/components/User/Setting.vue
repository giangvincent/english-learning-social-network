<template>
  <div>
    <div class="bg-white md:w-6/12 mx-auto mb-20 px-8 py-6 rounded shadow">
      <fieldset class="relative my-2 p-3 border-2 border-blue-900 rounded-lg">
        <legend class="mx-2 font-bold rounded-lg bg-blue-900 text-white p-2">
          Đổi thông tin cơ bản
        </legend>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Tên đăng nhập</span>
          <input
            placeholder
            type="text"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Tên đầy đủ</span>
          <input
            placeholder
            type="text"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Tên hiển thị</span>
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
            readonly
            type="text"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Tài khoản Facebook</span>
          <input
            placeholder
            type="text"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Giới thiệu ngắn</span>
          <textarea
            placeholder
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          ></textarea>
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Loại tài khoản</span>
          <select
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          >
            <option>Cá nhân</option>
            <option>Tổ chức</option>
          </select>
        </div>
      </fieldset>
      <fieldset class="relative my-2 p-3 border-2 border-green-800 rounded-lg">
        <legend class="mx-2 font-bold rounded-lg bg-green-800 text-white p-2">
          Đổi cài đặt thông báo
        </legend>
      </fieldset>
      <fieldset class="relative my-2 p-3 border-2 border-red-600 rounded-lg">
        <legend class="mx-2 font-bold rounded-lg bg-red-600 text-white p-2">
          Đổi mật khẩu
        </legend>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Mật khẩu cũ</span>
          <input
            placeholder
            type="password"
            x-model="password"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Mật khẩu mới</span>
          <input
            placeholder
            type="password"
            x-model="password"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
        <div class="py-1">
          <span class="px-1 text-sm text-gray-600">Xác nhận mật khẩu mới</span>
          <input
            placeholder
            type="password"
            x-model="password_confirm"
            class="text-md block px-3 py-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
          />
        </div>
      </fieldset>

      <button
        class="mt-3 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
      >
        Lưu thay đổi
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "user-setting",
  data() {
    return {
      password: "",
      password_confirm: ""
    };
  }
};
</script>
