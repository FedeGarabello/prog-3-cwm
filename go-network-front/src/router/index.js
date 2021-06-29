import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../views/Home.vue'
import ViewProfile from '../views/ViewProfile.vue'
import NewPost from '../views/NewPost.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import authService from "../services/auth";

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/profile',
    name: 'ViewProfile',
    component: ViewProfile,
    meta: {
      requiresAuth: true,
    }
  },
  {
    path: '/newPost',
    name: 'NewPost',
    component: NewPost,
    meta: {
      requiresAuth: true,
    }
  },
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/register',
    name: 'register',
    component: Register
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
});

router.beforeEach((to, from) => {
  if(to.meta.requiresAuth && !authService.isAuthenticated()) {
    return {
      path: '/login'
    };
  }
});


export default router
