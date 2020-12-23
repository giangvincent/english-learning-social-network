<template>
  <div
    ref="footerInfo"
    id="footer-info"
    class="bottom-0 p-2 mb-5 text-xs z-10 bg-white fixed w-64 md:w-1/5 lg:w-1/6"
  >
    <ul class="flex flex-wrap my-1 items-center underline">
      <li class="mr-2"><router-link to="/about/us">About</router-link></li>
      <li class="mr-2"><router-link to="/about/faqs">FAQs</router-link></li>
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
