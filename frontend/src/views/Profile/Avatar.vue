<template>
  <Profile>
    <div class="avatar">
      <img :src="avatar" class="m-auto rounded-full w-52 h-52" />
      <label
        for="avatar-input"
        class="block p-1 w-32 rounded-md border border-gray-300 mx-auto my-2 text-gray-500 cursor-pointer text-center"
        >{{ changeFile ? "Selected" : "Select" }}</label
      >
      <input
        id="avatar-input"
        class="hidden"
        type="file"
        @change="onFileChanged"
      />
    </div>
    <div class="mt-2">
      <button
        v-if="changeFile"
        class="px-4 py-1 rounded-md text-blue-600 border duration-700 border-blue-600 transition-all hover:bg-blue-500 hover:text-white"
        @click="changeAvatar"
      >
        Save
      </button>
    </div>
  </Profile>
</template>

<script>
import http from "@/inc/Http";
import Profile from "@/components/Profile/Profile.vue";
import MiniToast from "mor-mini-toast";

export default {
  name: "Avatar",
  components: {
    Profile,
  },
  data() {
    return {
      file: "",
      avatar: "",
      changeFile: false,
    };
  },
  created() {
    this.avatar = this.auth.avatar;
  },
  methods: {
    onFileChanged(e) {
      this.file = e.target.files[0];
      this.changeFile = true;

      const reader = new FileReader();

      reader.addEventListener(
        "load",
        function () {
          this.avatar = reader.result;
        }.bind(this),
        false
      );

      if (this.file) {
        if (/\.(jpe?g|png|gif)$/i.test(this.file.name)) {
          reader.readAsDataURL(this.file);
        }
      }
    },
    changeAvatar(e) {
      e.preventDefault();

      const data = new FormData();
      data.append("avatar", this.file);

      http.post("u/update", data).then(({ data }) => {
        const user = JSON.parse(localStorage.getItem("user"));
        user.avatar = data;
        localStorage.setItem("user", JSON.stringify(user));
        this.changeFile = false;
        let options = {
          position: "top-left",
        };
        let toast = MiniToast.init("Avatar has been changed.", options);
        toast.show();
      });
    },
  },
};
</script>
