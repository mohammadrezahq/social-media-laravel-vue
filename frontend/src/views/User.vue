<template>
  <div>
    <div class="">
      <div class="flex justify-center space-x-4 my-4 items-center">
        <div class="user-avatar col-4 text-center">
          <div class="w-60 h-60">
            <img :src="user.avatar" class="w-60 h-60" />
          </div>
        </div>
        <div>
          <h3 class="font-bold text-4xl">{{ user.display_name }}</h3>
          <p class="text-gray-500">{{ user.bio }}</p>
          <div class="flex justify-between my-2">
            <div class="rounded-md bg-gray-100 p-2 text-gray-600">
              Followers: <b>{{ user.followers }}</b>
            </div>
            <div class="rounded-md bg-gray-100 p-2 text-gray-600">
              Followings: <b>{{ user.followings }}</b>
            </div>
          </div>
          <button
            :class="
              'transition rounded-md border p-2 m-auto ' +
              (!user.has_follow
                ? 'bg-blue-600 text-white border-blue-600 hover:bg-white hover:text-blue-600'
                : 'border-gray-300 text-gray-400')
            "
            @click="doFollow()"
            v-if="user._id !== auth._id"
          >
            {{ !user.has_follow ? "Follow" : "Unfollow" }}
          </button>
        </div>
      </div>
      <hr />
      <Posts :posts="user.posts" :user="user" @update:delete="deletePost" />
    </div>
  </div>
</template>
<script>
import http from "@/inc/Http";
import Posts from "../components/Posts.vue";

export default {
  name: "User",
  components: {
    Posts,
  },
  watch: {
    $route(to, from) {
      this.$router.go();
    },
  },
  data() {
    return {
      user: [],
    };
  },
  created() {
    const data = { username: this.$route.params.username };

    http.post("u/get", data).then(({ data }) => {
      this.user = data;
      document.title = "Lymedia - " + data.display_name;
    });
  },
  methods: {
    postModal(id) {
      this.modals[id] = !this.modals[id];
    },
    doFollow() {
      const _id = this.user._id;
      const data = { followed: _id };

      http.post("f/do", data).then(({ data }) => {
        if (data === "followed") {
          ++this.followers;
          this.user.has_follow = true;
        } else {
          --this.followers;
          this.user.has_follow = false;
        }
      });
    },
    deletePost(i) {
      this.user.posts.splice(i, 1);
    },
  },
};
</script>
