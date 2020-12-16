<template>
  <div
    class="mx-0 border-t-2 shadow-xl rounded-lg mb-6 tracking-wide w-full bg-white"
  >
    <div class="w-full p-3 font-bold">
      <h1>{{ title }}</h1>
    </div>
    <div class="w-full p-3" v-html="content">
      <!-- End content text -->
    </div>
  </div>
</template>

<script>
export default {
  name: "static-content",
  props: {
    page: String
  },
  data() {
    return { title: "", content: "" };
  },
  mounted() {
    console.log(this.page);

    let self = this;
    let contentLink = "/content/about.json";
    if (this.page === "policy") {
      contentLink = "/content/policy.json";
    }
    fetch(contentLink)
      .then(res => res.json())
      .then(res => {
        console.log(res);
        if (typeof res !== "undefined") {
          self.title = res.title;
          self.content = res.content;
        }
      })
      .catch(err => {
        console.log(err);
      });
  }
};
</script>
