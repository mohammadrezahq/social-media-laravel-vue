<template>
  <input
    class="p-2 rounded-md outline-none border border-transparent focus:border-gray-300"
    type="text"
    placeholder="Search..."
    v-model="searchUser"
  />
  <div
    class="mt-2 bg-white p-2 shadow-sm w-64 absolute -left-8 -right-2"
    v-if="searchUser !== ''"
  >
    <div v-if="usersList.length == 0">No user found.</div>
    <div class="search-item" v-for="(user, i) in usersList" :key="i">
      <a class="flex justify-between items-center" :href="'/@' + user.username">
        <div class="w-1/3">
          <img :src="user.avatar" class="w-10 h-10" />
        </div>
        <div class="w-2/3">
          <p class="m-0">{{ user.username }}</p>
          <span class="text-sm text-gray-300">{{ user.display_name }}</span>
        </div>
      </a>
    </div>
  </div>
</template>
<script>
import http from "@/inc/Http";

export default {
  name: "SearchBar",
  data() {
    return {
      searchUser: "",
      usersList: [],
    };
  },
  watch: {
    searchUser: async function (val) {
      const data = {
        username: val,
      };
      if (val.length > 2) {
        http.post("u/search", data).then(({ data }) => {
          this.usersList = data;
        });
      } else {
        this.usersList = [];
      }
    },
  },
};
</script>
