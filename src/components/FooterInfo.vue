<template>
  <div
    ref="footerInfo"
    id="footer-info"
    class="bottom-0 p-2 mb-5 text-xs z-10 bg-white fixed w-64 md:w-1/5 lg:w-1/6"
  >
    <ul class="flex flex-wrap my-1 items-center underline">
      <li class="mr-2">
        <router-link to="/about/us">Về thatsgood</router-link>
      </li>
      <li class="mr-2"><router-link to="/about/faqs">FAQs</router-link></li>
      <li class="mr-2">
        <router-link to="/about/buy-coffee" class="flex"
          ><svg
            class="h-4 w-4 text-yellow-500"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
            /></svg
          >Buy Coffee</router-link
        >
      </li>
      <li class="mr-2">
        <router-link to="/about/contact">Liên hệ</router-link>
      </li>
      <li>
        <router-link to="/about/policy">Điều khoản & Chính sách</router-link>
      </li>
    </ul>
    <div class="italic">
      Copy right @Thatsgood {{ new Date().getFullYear() }}.
    </div>
  </div>
</template>

<script>
export default {
  name: "footer-info",
  mounted() {
    this.$emit("getHeight", this.$refs.footerInfo.clientHeight);
  }
};
</script>
