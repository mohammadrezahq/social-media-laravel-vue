<template>
  <Profile>
    <form @submit.prevent="updateUser()">
      <Input
        label="Old Password"
        type="password"
        v-model="user.oldPassword"
        :errors="errors.oldPassword"
      />
      <Input
        label="New Password"
        type="password"
        v-model="user.password"
        :errors="errors.password"
      />
      <Input
        label="Confirm Password"
        type="password"
        v-model="user.password_confirmation"
      />
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
  name: "Security",
  components: {
    Profile,
    Input,
  },
  data() {
    return {
      user: {},
      errors: [],
    };
  },
  methods: {
    updateUser() {
      this.errors = [];
      if (this.errors.length === 0) {
        http.post("u/password", this.user).catch(({ response }) => {
          this.errors = response.data.errors;
        });
      }
    },
  },
};
</script>
