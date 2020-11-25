<template>
  <div class="bottom-0 p-2 text-xs z-10 bg-white fixed w-64 md:w-1/5 lg:w-1/6">
    <ul class="flex flex-wrap my-1 items-center underline">
      <li class="mr-2">About</li>
      <li class="mr-2">FAQs</li>
      <li class="mr-2">Liên hệ</li>
      <li>Điều khoản & Chính sách</li>
    </ul>
    <div class="italic">
      Copy right @Thatsgood {{ new Date().getFullYear() }}.
    </div>
  </div>
</template>

<script>
export default {
  name: "footer-info"
};
</script>
