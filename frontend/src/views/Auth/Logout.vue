<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'Logout',
  created () {
    this.logOut()
    this.pushPage()
  },
  computed: {
    ...mapGetters('auth', ['checkLogin']),
    isUserLoggedIn () {
      return this.checkLogin
    }
  },
  methods: {
    ...mapActions('auth', ['resetState']),
    logOut () {
      localStorage.clear()
      this.resetState()
    },
    pushPage () {
      this.$router.push({ path: '/login' })
    }
  }
}
</script>
