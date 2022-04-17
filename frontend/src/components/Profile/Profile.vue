<template>
  <div class="mx-auto my-4" style="width: 1024px">
    <div class="flex items-start">
      <ProfileNav />
      <div class="w-2/3 px-2">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
import ProfileNav from "./ProfileNav.vue";

export default {
  components: {
    ProfileNav,
  },
};
</script>
