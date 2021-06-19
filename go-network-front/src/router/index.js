import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../views/Home.vue'
import ViewProfile from '../views/ViewProfile.vue'
import NewPost from '../views/NewPost.vue'


const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/profile',
    name: 'ViewProfile',
    component: ViewProfile
  },
  {
    path: '/newPost',
    name: 'NewPost',
    component: NewPost
  },


]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
