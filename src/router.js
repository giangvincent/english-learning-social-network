import { createRouter, createWebHistory } from 'vue-router';
import Home from './views/Home.vue';
import store from './store';

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
    },
    {
      path: '/p/:type/:slug',
      name: 'detail',
      component: () => import('./views/Detail.vue'),
    },
    {
      path: '/u/:id',
      name: 'user-page',
      component: () => import('./views/User.vue'),
    },
    {
      path: '/auth/:page',
      name: 'authenticate',
      component: () => import('./views/Auth.vue'),
    },
    {
      path: '/tag/:name',
      name: 'tag-feed',
      component: () => import('./views/Tag.vue'),
    },
    {
      path: '/s/:query',
      name: 'search-feed',
      component: () => import('./views/Search.vue'),
    },
    {
      path: '/creator',
      name: 'creator-tool',
      component: () => import('./views/Creator.vue'),
    },
    {
      path: '/:name',
      name: 'category-feed',
      component: () => import('./views/Category.vue'),
    },
    {
      path: '/about/:page',
      name: 'other-pages',
      component: () => import('./views/About.vue'),
    },
  ],
});

router.beforeEach((to, from, next) => {
  store.state.showPanelLeft = false;
  store.state.showPanelRight = false;
  next();
});

export default router;
