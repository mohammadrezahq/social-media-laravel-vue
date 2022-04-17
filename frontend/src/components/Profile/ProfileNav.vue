<template>
  <div class="w-1/3">
    <div class="flex flex-col">
      <router-link
        active-class="bg-gray-100"
        class="transition p-2 bg-gray-50 hover:bg-gray-100"
        to="/profile/settings"
        >Profile Settings</router-link
      >
      <router-link
        active-class="bg-gray-100"
        class="transition p-2 bg-gray-50 hover:bg-gray-100"
        to="/profile/account"
        >Account</router-link
      >
      <router-link
        active-class="bg-gray-100"
        class="transition p-2 bg-gray-50 hover:bg-gray-100"
        to="/profile/avatar"
        >Change Avatar</router-link
      >
      <router-link
        active-class="bg-gray-100"
        class="transition p-2 bg-gray-50 hover:bg-gray-100"
        to="/profile/security"
        >Change Password</router-link
      >
    </div>
  </div>
</template>

<script>
export default {
  name: "ProfileNav",
  data() {
    return {
      modals: [],
    };
  },
};
</script>
