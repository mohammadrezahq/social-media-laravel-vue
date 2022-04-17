<template>
  <div>
    <h1
      class="text-4xl text-center w-36 p-2 select-none bg-gray-100 text-gray-500 rounded-md my-2 m-auto font-medium"
    >
      Explore
    </h1>
    <Posts v-bind:posts="posts" />
  </div>
</template>
<script>
import Posts from "../components/Posts.vue";
import http from "@/inc/Http";

export default {
  name: "Explore",
  components: {
    Posts,
  },
  data() {
    return {
      posts: [],
    };
  },
  created() {
    http.get("p/explore").then(({ data }) => {
      this.posts = data;
    });
  },
};
</script>
