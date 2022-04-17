<template>
  <div class="flex flex-col justify-between h-3/6">
    <div
      class="scroll-style flex bg-gray-50 flex-col overflow-y-scroll h-80 pl-2"
    >
      <div v-for="(comment, i) in comments" class="m-2" :key="i">
        <img
          :src="comment.user.avatar"
          class="w-6 h-6 rounded-full inline-block"
        />
        <b class="align-middle ml-1">{{ comment.user.username }}</b>
        <span class="align-middle ml-1">{{ comment.text }}</span>
      </div>
    </div>
    <form @submit.prevent="postComment" class="flex flex-col justify-between">
      <div>
        <textarea
          v-model="comment"
          class="w-full border-t border-gray-200 p-2 outline-none focus:border-blue-300 resize-none"
          placeholder="type..."
        ></textarea>
      </div>
      <div>
        <button
          class="w-full bg-blue-600 text-white p-2 rounded-br-md"
          type="submit"
        >
          Comment
        </button>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  props: ["comments"],
  data() {
    return {
      comment: "",
    };
  },
  methods: {
    postComment() {
      if (this.comment !== "") this.$emit("update:postComment", this.comment);
      this.comment = "";
    },
  },
};
</script>
