<template>
  <div>
    <h1
      class="text-4xl text-center w-32 p-2 select-none bg-gray-100 text-gray-500 rounded-md my-2 m-auto font-medium"
    >
      Feed
    </h1>
    <Posts v-bind:posts="posts" v-bind:follow="true" />
  </div>
</template>
<script>
import http from "@/inc/Http";
import Posts from "@/components/Posts.vue";

export default {
  name: "Feed",
  data() {
    return {
      posts: [],
    };
  },
  components: {
    Posts,
  },
  created() {
    http.get("p/feed").then(({ data }) => {
      this.posts = data;
    });
  },
};
</script>
