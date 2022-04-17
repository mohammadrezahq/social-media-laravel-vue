import { createRouter, createWebHistory } from 'vue-router'
import NProgress from 'nprogress'

const routes = [
  {
    path: '/',
    name: 'Feed',
    meta: { title: 'home' },
    component: () => import(/* webpackChunkName: "Feed" */'../views/Feed.vue')
  },
  {
    path: '/explore',
    name: 'Explore',
    meta: { title: 'explore' },
    component: () => import(/* webpackChunkName: "Explore" */'../views/Explore.vue')
  },
  {
    path: '/login',
    name: 'Login',
    meta: { title: 'login' },
    component: () => import(/* webpackChunkName: "Login" */'../views/Auth/Login.vue')
  },
  {
    path: '/register',
    name: 'Register',
    meta: { title: 'register' },
    component: () => import(/* webpackChunkName: "Register" */'../views/Auth/Register.vue')
  },
  {
    path: '/profile/settings',
    name: 'Settings',
    meta: { title: 'settings' },
    component: () => import(/* webpackChunkName: "Settings" */'../views/Profile/Settings.vue')
  },
  {
    path: '/profile/account',
    name: 'Account',
    meta: { title: 'account' },
    component: () => import(/* webpackChunkName: "Account" */'../views/Profile/Account.vue')
  },
  {
    path: '/profile/avatar',
    name: 'Avatar',
    meta: { title: 'avatar' },
    component: () => import(/* webpackChunkName: "Avatar" */'../views/Profile/Avatar.vue')
  },
  {
    path: '/profile/security',
    name: 'Security',
    meta: { title: 'security' },
    component: () => import(/* webpackChunkName: "Security" */'../views/Profile/Security.vue')
  },
  {
    path: '/profile/logout',
    name: 'Logout',
    meta: { title: 'logout' },
    component: () => import(/* webpackChunkName: "Logout" */'../views/Auth/Logout.vue')
  },
  {
    path: '/@:username',
    name: 'User',
    component: () => import(/* webpackChunkName: "User" */'../views/User.vue')
  },
  {
    path: '/add',
    name: 'Add',
    meta: { title: 'Add post' },
    component: () => import(/* webpackChunkName: "Add" */'../views/Add.vue')
  }
]

if (localStorage.getItem('user')) {
  routes.push({ path: '/@', redirect: '/@' + JSON.parse(localStorage.getItem('user')).username })
}

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeResolve((to, from, next) => {
  if (to.name) {
    NProgress.start()
  }
  next()
})
router.beforeEach((to, from) => {
  NProgress.set(0.6)
})

router.afterEach((to, from) => {
  NProgress.done()
})

export default router
