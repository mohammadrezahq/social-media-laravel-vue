<template>
  <div class="grid grid-cols-3 md:grid-cols-4 gap-0 z-0">
    <div v-for="(post, i) in posts" :key="i" class="relative">
      <span
        v-if="isToday(post.date)"
        class="absolute top-2 w-24 font-medium mx-auto rounded-full shadow-md left-2 text-center bg-white p-2 text-gray-500"
        >Today</span
      >
      <img
        @click="showModal(i)"
        class="cursor-pointer h-full"
        :src="post.image"
      />
      <PostModal
        v-if="show_modal[i]"
        @update:closeModal="closeModal(i)"
        @update:likePost="likePost(i)"
        @update:comments="(comment) => updateComments(i, comment)"
        @update:caption="(caption) => updateCaption(i, caption)"
        @update:delete="deletePost(i)"
        :post="content[i]"
      />
    </div>
  </div>
</template>

<script>
import PostModal from "./Post/PostModal.vue";
import http from "@/inc/Http";

export default {
  components: { PostModal },
  props: ["posts", "user"],
  data() {
    return {
      show_modal: [],
      content: [],
    };
  },
  methods: {
    showModal(i) {
      const data = {
        _id: this.posts[i]._id,
      };

      if (this.content[i] == undefined) {
        http.post("p/show", data).then(({ data }) => {
          this.content[i] = data;
          this.show_modal[i] = true;
        });
      } else {
        this.show_modal[i] = true;
      }
    },
    closeModal(i) {
      this.show_modal[i] = false;
      document.getElementsByTagName("body")[0].style.overflow = "auto";
    },
    likePost(i) {
      if (this.content[i].has_liked == true) {
        this.content[i].likes -= 1;
      } else {
        this.content[i].likes += 1;
      }
      this.content[i].has_liked = !this.content[i].has_liked;
    },
    isToday(date) {
      const today = new Date();
      const someDate = new Date(date);
      return (
        someDate.getDate() == today.getDate() &&
        someDate.getMonth() == today.getMonth() &&
        someDate.getFullYear() == today.getFullYear()
      );
    },
    updateComments(i, comment) {
      comment.user = this.auth;
      this.content[i].comments = [comment].concat(this.content[i].comments);
    },
    updateCaption(i, caption) {
      this.content[i].caption = caption;
    },
    deletePost(i) {
      this.content.splice(i, 1);
      this.$emit("update:delete", i);
    },
  },
};
</script>
