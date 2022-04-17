<template>
  <div class="flex bg-gray-100 p-5 h-16">
    <div class="m-auto" v-if="!isUserLoggedIn">
      <p class="text-2xl text-gray-400 font-bold select-none">LyMedia</p>
    </div>
    <div class="flex justify-between w-full items-center" v-if="isUserLoggedIn">
      <div class="relative">
        <UserMenu />
      </div>
      <div class="searchBar" style="position: relative">
        <SearchBar />
      </div>
      <div class="">
        <span>
          <router-link to="add"><i class="gg-add-r"></i></router-link>
        </span>
      </div>
    </div>
  </div>
  <router-view />
</template>

<script>
import SearchBar from "@/components/App/SearchBar.vue";
import UserMenu from "@/components/App/UserMenu.vue";

export default {
  data() {
    return {
      isUserLoggedIn: false,
      searchUser: "",
      usersList: [],
    };
  },
  components: { SearchBar, UserMenu },
  methods: {
    pushPage() {
      const path = window.location.pathname;
      if (localStorage.getItem("user")) {
        if (path === "/login" || path === "/register") {
          this.$router.push("/profile/settings");
        }
        this.isUserLoggedIn = true;
      } else {
        if (path !== "/login" && path !== "/register") {
          this.$router.push("/login");
        }
      }
    },
  },
  created() {
    this.auth = JSON.parse(localStorage.getItem("user"));
    this.pushPage();
  },
  watch: {
    $route(to, from) {
      to.meta.title
        ? (document.title = "Lymedia - " + to.meta.title)
        : (document.title = "Lymedia");

      if (from.href === "/login" || from.href === "/register") {
        if (localStorage.getItem("user")) this.isUserLoggedIn = true;
      }
      if (to.href === "/profile/logout") {
        this.isUserLoggedIn = false;
      }
    },
  },
};
</script>
<style lang="scss">
.add-post {
  text-align: right;
  padding-top: 5px;

  a {
    color: black;
  }
}
*::-webkit-scrollbar {
  width: 0.2em;
}

*::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
}

*::-webkit-scrollbar-thumb {
  background-color: rgb(214, 214, 214);
}
</style>
