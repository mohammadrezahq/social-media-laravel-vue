<template>
  <div>
    <div
      @click="closeModal()"
      v-if="show"
      class="fixed bg-black opacity-25 left-0 right-0 top-0 bottom-0 w-full h-full z-40"
    ></div>
    <transition name="slide-bottom-fade">
      <div
        class="bg-white fixed left-0 right-0 top-1/2 rounded-md m-auto flex z-50"
        style="transform: translateY(-50%); height: 640px; width: 1080px"
        v-if="show"
      >
        <div class="w-1/2">
          <img
            :src="post.image"
            style="width: 640px; height: 640px"
            class="rounded-l-md"
          />
        </div>

        <div class="w-1/2 flex flex-col justify-end">
          <div
            class="flex pl-2 pr-3 py-3 border-b border-gray-200 items-center justify-between"
            style="height: 8%"
          >
            <div class="flex space-x-2">
              <img :src="post.user.avatar" class="rounded-full w-8 h-8" />
              <router-link :to="'/@' + post.user.username"
                ><p class="text-xl font-light">
                  {{ post.user.display_name }}
                </p></router-link
              >
            </div>
            <div
              v-if="post.own_post"
              class="post-menu-div relative cursor-pointer"
            >
              <span @click="postMenu = !postMenu">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                  role="img"
                  width="1.5em"
                  height="1.5em"
                  preserveAspectRatio="xMidYMid meet"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill="currentColor"
                    d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0 12c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2z"
                  />
                </svg>
              </span>
              <div
                v-if="postMenu"
                class="absolute bg-white shadow-md p-4 top-6 -left-4 flex flex-col"
              >
                <p class="cursor-pointer" v-if="!save" @click="editPost()">
                  edit
                </p>
                <p class="cursor-pointer" @click="deletePost()">delete</p>
              </div>
            </div>
          </div>
          <div class="p-2 h-2/6">
            <p
              v-text="caption"
              :class="save ? 'border border-black' : ''"
              :contenteditable="save"
              @keyup="updateCaption"
            ></p>
          </div>
          <div v-if="save" class="p-2">
            <button
              @click="saveEdit()"
              class="px-4 w-20 inline-block py-1 rounded-md text-blue-600 border duration-700 border-blue-600 transition-all hover:bg-blue-500 hover:text-white"
            >
              Save
            </button>
            <button
              @click="save = !save"
              class="px-4 w-20 inline-block py-1 rounded-md text-red-600 duration-700 transition-all"
            >
              Cancel
            </button>
          </div>

          <div class="p-2 flex flex-col items-center w-1/12">
            <svg
              @click="like()"
              class="hover:animate-spin"
              xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
              role="img"
              width="2em"
              height="2em"
              preserveAspectRatio="xMidYMid meet"
              viewBox="0 0 24 24"
            >
              <path
                class="cursor-pointer"
                :fill="post.has_liked ? 'red' : 'none'"
                :stroke="post.has_liked ? 'red' : 'black'"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M22 8.862a5.95 5.95 0 0 1-1.654 4.13c-2.441 2.531-4.809 5.17-7.34 7.608c-.581.55-1.502.53-2.057-.045l-7.295-7.562c-2.205-2.286-2.205-5.976 0-8.261a5.58 5.58 0 0 1 8.08 0l.266.274l.265-.274A5.612 5.612 0 0 1 16.305 3c1.52 0 2.973.624 4.04 1.732A5.95 5.95 0 0 1 22 8.862Z"
              />
            </svg>

            <span class="select-none"> {{ post.likes }} </span>
          </div>
          <Comments
            :comments="post.comments"
            @update:postComment="postComment"
          />
        </div>
      </div>
    </transition>
  </div>
</template>
<script>
import Comments from "./PostComments.vue";
import http from "@/inc/Http";

export default {
  components: { Comments },
  props: ["post"],
  data() {
    return {
      show: false,
      postMenu: false,
      save: false,
      caption: "",
    };
  },
  mounted() {
    this.caption = this.post.caption;
    this.show = true;
    document.getElementsByTagName("body")[0].style.overflow = "hidden";
  },
  methods: {
    closeModal() {
      this.show = false;
      setTimeout(() => this.$emit("update:closeModal"), 300);
    },
    like() {
      this.$emit("update:likePost");
      const id = this.post._id;

      http.post("l", { id: id }).then(({ data }) => {
        if (!data) {
          this.$emit("update:likePost");
        }
      });
    },
    postComment(comment) {
      const id = this.post._id;

      http.post("c/do", { comment: comment, post_id: id }).then(({ data }) => {
        this.$emit("update:comments", data);
      });
    },
    editPost() {
      this.postMenu = false;
      this.save = true;
    },
    saveEdit() {
      this.save = false;
      http
        .post("p/update", { post_id: this.post._id, caption: this.caption })
        .then(({ data }) => {
          this.$emit("update:caption", this.caption);
        });
    },
    updateCaption(e) {
      this.caption = e.target.innerText;
    },
    deletePost() {
      if (confirm("Are you sure?") == true) {
        http.post("p/delete", { post_id: this.post._id }).then((response) => {
          this.closeModal();
          this.$emit("update:delete");
        });
      }
    },
  },
};
</script>
<style scoped>
.slide-bottom-fade-enter-active {
  transition: all 0.3s ease-out;
}
.slide-bottom-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-bottom-fade-enter-from,
.slide-bottom-fade-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
</style>
