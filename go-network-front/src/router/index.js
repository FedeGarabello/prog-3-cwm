import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../views/Home.vue'
import ViewProfile from '../views/ViewProfile.vue'
import ViewFriends from '../views/ViewFriends.vue'
import SearchFriends from '../views/SearchFriends.vue'
import NewPost from '../views/NewPost.vue'
import Login from '../views/Login.vue'
import PostDetail from '../views/PostDetail.vue'
import Register from '../views/Register.vue'
import authService from "../services/auth";

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      requiresAuth: true,
    }
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
    path: '/friends',
    name: 'ViewFriends',
    component: ViewFriends,
    meta: {
      requiresAuth: true,
    }
  },
  {
    path: '/search',
    name: 'SearchFriends',
    component: SearchFriends,
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
  {
    path: '/:id',
    name: 'PostDetail',
    component: PostDetail,

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
