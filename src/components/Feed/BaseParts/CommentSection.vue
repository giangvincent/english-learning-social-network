<template>
  <div>
    <!-- comment form -->
    <div class="bg-white shadow-xl p-3 md:p-6">
      <span>Bình luận</span>
      <div class="mt-1">
        <textarea
          placeholder="Nội dung bình luận"
          type="text"
          class="text-md block px-3 py-2 mb-2 rounded-lg w-full bg-white border-2 border-gray-300 placeholder-gray-600 focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none"
        ></textarea>
        <button
          class="flex-1 text-lg font-semibold w-full text-white rounded-lg px-6 py-3 btn-hover gradient-black"
        >
          Gửi bình luận
        </button>
      </div>
    </div>

    <div class="bg-white shadow-xl p-6 mt-6 mb-10">
      <div
        v-for="(comment, index) in comments"
        :key="'comment-' + index"
        class="flex flex-col mb-4 relative"
      >
        <div class="leading-normal mb-2">
          {{ comment.body }}
        </div>

        <div class="text-gray-500 text-xs">
          <span>{{ comment.author.name }}</span>
          -
          <span>{{ comment.created_at }}</span>
        </div>
        <button class="absolute right-0 top-0 p-2 shadow rounded  -mt-4 -mr-4">
          <svg
            class="w-6"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"
            />
            <path
              fill-rule="evenodd"
              d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      state: "default",
      data: {
        body: ""
      },
      comments: [
        {
          id: 1,
          body:
            "Lorem Ipsum chỉ đơn giản là một đoạn văn bản giả, được dùng vào việc trình bày và dàn trang phục vụ cho in ấn. Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500, khi một họa sĩ vô danh ghép nhiều đoạn văn bản với nhau để tạo thành một bản mẫu văn bản. Đoạn văn bản này không những đã tồn tại năm thế kỉ, mà khi được áp dụng vào tin học văn phòng, nội dung của nó vẫn không hề bị thay đổi. Nó đã được phổ biến trong những năm 1960 nhờ việc bán những bản giấy Letraset in những đoạn Lorem Ipsum, và gần đây hơn, được sử dụng trong các ứng dụng dàn trang, như Aldus PageMaker.",
          edited: false,
          created_at: new Date().toLocaleString(),
          author: {
            id: 1,
            name: "Nick Basile"
          }
        },
        {
          id: 2,
          body:
            'Chúng ta vẫn biết rằng, làm việc với một đoạn văn bản dễ đọc và rõ nghĩa dễ gây rối trí và cản trở việc tập trung vào yếu tố trình bày văn bản. Lorem Ipsum có ưu điểm hơn so với đoạn văn bản chỉ gồm nội dung kiểu "Nội dung, nội dung, nội dung" là nó khiến văn bản giống thật hơn, bình thường hơn. Nhiều phần mềm thiết kế giao diện web và dàn trang ngày nay đã sử dụng Lorem Ipsum làm đoạn văn bản giả, và nếu bạn thử tìm các đoạn "Lorem ipsum" trên mạng thì sẽ khám phá ra nhiều trang web hiện vẫn đang trong quá trình xây dựng. Có nhiều phiên bản khác nhau đã xuất hiện, đôi khi do vô tình, nhiều khi do cố ý (xen thêm vào những câu hài hước hay thông tục).',
          edited: false,
          created_at: new Date().toLocaleString(),
          author: {
            id: 2,
            name: "Bob Ross"
          }
        }
      ]
    };
  },
  methods: {
    startEditing() {
      this.state = "editing";
    },
    stopEditing() {
      this.state = "default";
      this.data.body = "";
    },

    saveComment() {
      let newComment = {
        id: this.comments[this.comments.length - 1].id + 1,
        body: this.data.body,
        edited: false,
        created_at: new Date().toLocaleString(),
        author: {
          id: 1,
          name: "abc"
        }
      };

      this.comments.push(newComment);

      this.stopEditing();
    }
  }
};
</script>
