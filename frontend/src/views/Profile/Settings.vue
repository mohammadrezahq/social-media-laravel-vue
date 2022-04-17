<template>
  <Profile>
    <form @submit.prevent="updateUser()">
      <Input label="Name" type="text" v-model="user.display_name" />
      <div class="flex flex-col">
        <label>Bio: </label>
        <textarea
          class="p-2 border-gray-200 border rounded-md outline-none focus:border-blue-600"
          v-model="user.bio"
        >
        </textarea>
      </div>
      <div class="mt-2">
        <button
          type="submit"
          class="px-4 py-1 rounded-md text-blue-600 border duration-700 border-blue-600 transition-all hover:bg-blue-500 hover:text-white"
        >
          Save
        </button>
      </div>
    </form>
  </Profile>
</template>

<script>
import Profile from "@/components/Profile/Profile.vue";
import http from "@/inc/Http";
import Input from "@/components/Input";

export default {
  name: "Settings",
  components: {
    Profile,
    Input,
  },
  data() {
    return {
      user: {
        display_name: "",
        bio: "",
      },
    };
  },
  created() {
    const user = JSON.parse(localStorage.getItem("user"));
    this.user.display_name = user.display_name;
    this.user.bio = user.bio;
  },
  methods: {
    updateUser() {
      http.post("u/update", this.user).then((res) => {
        if (res) {
          const user = JSON.parse(localStorage.getItem("user"));
          for (const item in this.user) {
            user[item] = this.user[item];
          }
          localStorage.setItem("user", JSON.stringify(user));
        }
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.avatar {
  text-align: center;
  img {
    border-radius: 50%;
    width: 50px;
    height: 50px;
    border: 4px solid #39978d;
  }
}
</style>
