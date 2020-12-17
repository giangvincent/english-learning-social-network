<template>
  <div>
    <div
      class="mx-0 border-t-2 shadow-xl rounded-lg mb-6 tracking-wide w-full bg-white pb-3"
      v-for="(faq, index) in faqs"
      :key="'faq-' + index"
    >
      <div class="w-full p-3 font-bold">
        <h1>{{ faq.title }}</h1>
      </div>
      <div class="w-full px-3" v-html="faq.content">
        <!-- End content text -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "faqs",
  data() {
    return { faqs: [] };
  },
  mounted() {
    console.log(this.page);

    let self = this;
    let contentLink = "/content/faqs.json";
    fetch(contentLink)
      .then(res => res.json())
      .then(res => {
        console.log(res);
        if (typeof res !== "undefined") {
          self.faqs = res;
        }
      })
      .catch(err => {
        console.log(err);
      });
  }
};
</script>
