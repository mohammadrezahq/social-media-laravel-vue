<template>
  <div class="w-1/3 m-auto mt-2">
    <h1 class="text-4xl inline-block">Login</h1>
    <router-link
      class="inline-block text-gray-400 hover:text-blue-600"
      to="/register"
      >or Register</router-link
    >
    <form @submit.prevent="onLogin()">
      <Input
        label="Username or Email"
        type="text"
        v-model="user.username"
        :errors="errors.username"
      />
      <Input
        label="Password"
        type="password"
        v-model="user.password"
        :errors="errors.password"
      />
      <div class="my-3">
        <button
          type="submit"
          class="px-4 py-1 rounded-md text-blue-600 border duration-700 border-blue-600 transition-all hover:bg-blue-500 hover:text-white"
        >
          Login
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import Input from "@/components/Input";
import http from "@/inc/Http";
import { mapActions } from "vuex";

export default {
  name: "Login",
  components: {
    Input,
  },
  data() {
    return {
      user: {
        username: "",
        password: "",
      },
      errors: [],
    };
  },
  methods: {
    ...mapActions("auth", ["setUser"]),
    onLogin() {
      this.errors = [];
      if (this.user.username === "")
        this.errors.username = "Enter username or password";
      if (this.user.password === "")
        this.errors.password = "Enter your password";

      if (Object.keys(this.errors).length === 0) {
        http
          .post("u/login", this.user)
          .then(({ data }) => {
            if (data) {
              this.setUser(data);
              setTimeout(
                () => (window.location = "/@" + data.user.username),
                500
              );
            }
          })
          .catch(({ response }) => {
            this.errors.username = [response.data];
          });
      }
    },
  },
};
</script>
<style lang="scss" scoped>
h1 {
  display: inline-block;
}
.router-link {
  color: black;
  text-decoration: none;
}
</style>
