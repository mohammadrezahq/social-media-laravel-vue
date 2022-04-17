<template>
  <span @click="navDropdown()" :class="'block transition cursor-pointer ' + ( userDropdown ? 'r-style' : '' )"> <i class="gg-menu-grid-o"></i> </span>
  <transition name="slide-bottom-fade">
    <div class="absolute bg-white top-10 -left-4 w-56 shadow-md z-40" v-if="userDropdown">
      <router-link @click="navDropdown()" class="flex items-center p-4 hover-pl" to="/"><i class="gg-home"></i> Feed</router-link>
      <router-link @click="navDropdown()" class="flex items-center p-4 hover-pl" to="/explore"><i class="gg-board"></i> Explore</router-link>
      <router-link @click="navDropdown()" class="flex items-center p-4 hover-pl" :to="'/@' + auth.username"><i class="gg-profile"></i> Profile</router-link>
      <router-link @click="navDropdown()" class="flex items-center p-4 hover-pl" to="/profile/settings"><i class="gg-carousel"></i> Settings</router-link>
      <router-link @click="navDropdown()" class="flex items-center p-4 hover-pl" to="/profile/logout"><i class="gg-arrow-left-r"></i> Log out</router-link>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'UserMenu',
  data () {
    return {
      userDropdown: false,
    }
  },
  methods: {
    navDropdown () {
      this.userDropdown = !this.userDropdown
    }
  }
}
</script>
<style scoped>
.gg-board, .gg-carousel, .gg-arrow-left-r, .gg-profile, .gg-home {
  display:inline-block!important;
  vertical-align: middle;
  margin: 0 5px ;
}
.r-style {
  transform: rotate(45deg);
}
.slide-bottom-fade-enter-active {
  transition: all 0.3s ease-out;
}
.slide-bottom-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-bottom-fade-enter-from,
.slide-bottom-fade-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}
.hover-pl {
  transition: .5s;
}
.hover-pl:hover {
  padding-left: 2em;
}
</style>
