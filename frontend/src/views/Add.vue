<template>
  <div class="flex">
    <div class="w-1/2 p-4">
      <img v-if="postPreview" :src="postPreview" />
    </div>
    <div class="w-1/2 p-4">
      <form
        @submit.prevent="doPost"
        class="flex flex-col"
        enctype="multipart/form-data"
      >
        <label
          for="image-input"
          class="transition border block border-gray-300 text-gray-500 p-2 text-center my-2 rounded-md cursor-pointer hover:border-gray-500 hover:text-gray-700"
          >Add Your Image</label
        >
        <input
          id="image-input"
          class="hidden"
          type="file"
          @change="onFileChanged"
        />
        <textarea
          class="p-2 border-gray-200 border rounded-md outline-none focus:border-blue-600"
          v-model="postCaption"
          placeholder="Write your caption..."
          maxlength="250"
        ></textarea>
        <button
          v-if="postImage"
          class="px-4 py-1 w-32 mx-auto my-2 rounded-md text-blue-600 border duration-700 border-blue-600 transition-all hover:bg-blue-500 hover:text-white"
          type="submit"
        >
          Share
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import http from "@/inc/Http";

export default {
  name: "Add",
  data() {
    return {
      postImage: "",
      postPreview: "",
      postCaption: "",
    };
  },
  methods: {
    onFileChanged(e) {
      this.postImage = e.target.files[0];
      const reader = new FileReader();

      reader.addEventListener(
        "load",
        function () {
          this.postPreview = reader.result;
        }.bind(this),
        false
      );

      if (this.postImage) {
        if (/\.(jpe?g|png|gif)$/i.test(this.postImage.name)) {
          reader.readAsDataURL(this.postImage);
        }
      }
    },
    doPost() {
      const data = new FormData();
      data.append("avatar", this.postImage);
      data.append("caption", this.postCaption);

      http.post("p/add", data).then((response) => {
        if (response) {
          const url = "/@" + this.auth.username;
          this.$router.push(url);
        }
      });
    },
  },
};
</script>
