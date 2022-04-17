<template>
  <Profile>
    <form @submit.prevent="updateUser()">
      <Input label="Username" type="text" v-model="user.username" />
      <Input label="Email" type="email" v-model="user.email" />
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
import http from "@/inc/Http";
import Profile from "@/components/Profile/Profile.vue";
import Input from "@/components/Input";

export default {
  name: "Account",
  components: {
    Profile,
    Input,
  },
  data() {
    return {
      user: {
        username: "",
        email: "",
      },
    };
  },
  created() {
    this.user.username = this.auth.username;
    this.user.email = this.auth.email;
  },
  methods: {
    updateUser() {
      http.post("u/update", this.user).then(({ data }) => {
        if (data) {
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
.page-nav {
  a {
    display: block;
    background-color: #fcfcfc;
    color: black;
    padding: 10px;
    text-decoration: none;
    &:hover {
      background-color: #eeeeee;
    }
  }
}
</style>
