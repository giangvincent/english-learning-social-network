import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/user/:id',
      name: 'user-page',
      component: () => import('./views/User.vue')
    },
    {
      path: '/auth',
      name: 'authenticate',
      component: () => import('./views/Auth.vue')
    },
    {
      path: '/cat/:name',
      name: 'category-feed',
      component: () => import('./views/Category.vue')
    },
    {
      path: '/tag/:name',
      name: 'tag-feed',
      component: () => import('./views/Tag.vue')
    },
    {
      path: '/creator',
      name: 'creator-tool',
      component: () => import('./views/Creator.vue')
    }
  ]
})
