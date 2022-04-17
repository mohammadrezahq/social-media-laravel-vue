<template>
  <div class="w-1/3 m-auto mt-2">
    <h1 class="text-4xl inline-block">Register</h1>
    <router-link
      class="inline-block text-gray-400 hover:text-blue-600"
      to="/login"
      >or Login</router-link
    >

    <form @submit.prevent="onRegister()">
      <Input
        label="Username"
        :space="true"
        type="text"
        v-model="form.username"
        :errors="errors.username"
      />
      <Input
        label="Name"
        type="text"
        v-model="form.display_name"
        :errors="errors.display_name"
      />
      <Input
        label="Email"
        type="email"
        v-model="form.email"
        :errors="errors.email"
      />
      <Input
        label="Birthday"
        type="date"
        v-model="form.birthday"
        :errors="errors.birthday"
      />
      <Input
        label="Password"
        type="password"
        v-model="form.password"
        :errors="errors.password"
      />

      <div class="flex my-4 space-x-2">
        <label>Gender:</label>
        <select
          :class="
            'w-32 border border-gray-200 outline-none rounded-md ' +
            (form.gender !== '' ? 'border-blue-500 text-blue-500' : '')
          "
          v-model="form.gender"
        >
          <option disabled value="">Select</option>
          <option value="male">Male</option>
          <option value="other">Other</option>
          <option value="female">Female</option>
        </select>
        <div v-for="(error, i) in errors.gender" :key="i">
          <p class="text-red-600">{{ error }}</p>
        </div>
      </div>

      <div>
        <div class="flex space-x-2 my-1">
          <label>Select Avatar: </label>
          <label
            for="select-file"
            :class="
              'bg-white border-gray-200 border px-4 outline-none rounded-md ' +
              (form.file !== '' ? 'border-blue-600 text-blue-600' : '')
            "
          >
            {{ form.file == "" ? "Select" : "Selected" }}
          </label>
          <input
            id="select-file"
            type="file"
            @change="onFileChanged"
            accept="image/*"
            class="hidden"
          />
        </div>
        <img v-if="avatarPreview" :src="avatarPreview" />
      </div>

      <div class="my-3">
        <button
          type="submit"
          class="px-4 py-1 rounded-md text-blue-600 border duration-700 border-blue-600 transition-all hover:bg-blue-500 hover:text-white"
        >
          Register
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import Input from "@/components/Input";
import { mapActions, mapGetters } from "vuex";
import http from "@/inc/Http.js";

export default {
  name: "Register",
  components: {
    Input,
  },
  created() {
    this.pushPage();
  },
  data() {
    return {
      avatarPreview: "",
      form: {
        username: "",
        display_name: "",
        email: "",
        gender: "",
        birthday: "",
        password: "",
        file: "",
      },
      errors: [],
    };
  },
  computed: {
    ...mapGetters("auth", ["checkLogin"]),
    isUserLoggedIn() {
      return this.checkLogin;
    },
  },
  methods: {
    ...mapActions("auth", ["setUser"]),
    pushPage() {
      if (this.isUserLoggedIn) this.$router.push({ path: "/profile/settings" });
    },
    onFileChanged(e) {
      this.form.file = e.target.files[0];

      const reader = new FileReader();

      reader.addEventListener(
        "load",
        function () {
          this.avatarPreview = reader.result;
        }.bind(this),
        false
      );

      if (this.form.file) {
        if (/\.(jpe?g|png|gif)$/i.test(this.form.file.name)) {
          reader.readAsDataURL(this.form.file);
        }
      }
    },
    onRegister() {
      this.errors = [];
      const data = new FormData();
      data.append("username", this.form.username);
      data.append("display_name", this.form.display_name);
      data.append("email", this.form.email);
      data.append("gender", this.form.gender);
      data.append("birthday", this.form.birthday);
      data.append("password", this.form.password);
      data.append("avatar", this.form.file);

      http
        .post("u/register", data)
        .then(({ data }) => {
          this.setUser(data);
          this.$root.$emit("navChange");
          setTimeout(() => (window.location = "/@" + data.user.username), 1000);
        })
        .catch(({ response }) => {
          this.errors = response.data.errors;
        });
    },
  },
};
</script>
