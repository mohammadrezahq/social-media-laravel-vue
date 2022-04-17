<template>
  <div class="row">
    <div class="user-avatar col-4 text-center">
      <div class="w-100 h-100">
        <img :src="profile.avatar">
      </div>
    </div>
    <div class="user-title col-8">
      <h3>{{profile.display_name}}</h3>
      <p>{{profile.bio}}</p>
      <div class="row row-cols-4">
        <div>Followers: {{followers}} </div>
        <div>Followings: {{followings}} </div>
      </div>
      <button :class="hasFollow" @click="doFollow(profile.username)" v-if="profile._id !== user._id">{{hasFollow}}</button>
    </div>
</div>
</template>

<script>
export default {
  name: 'UserPage',
  props: ['profile', 'followers', 'followings', 'hasFollow']

}
</script>
