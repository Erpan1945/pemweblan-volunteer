// resources/js/router/index.js

import { createRouter, createWebHistory } from 'vue-router';
import LoginPage from '../views/Login.vue';
import RegisterPage from '../views/Register.vue';
import DashboardPage from '../views/Dashboard.vue';
import ProfilePage from '../views/Profile.vue';

const routes = [
  {
    path: '/',
    redirect: '/login'
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginPage
  },
  {
    path: '/register',
    name: 'Register',
    component: RegisterPage
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: DashboardPage
  },
  {
    path: '/profile',
    name: 'Profile',
    component: ProfilePage
  },
  {
    path: '/:catchAll(.*)',
    redirect: '/login'
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;