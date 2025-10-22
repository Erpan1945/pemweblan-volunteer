// resources/js/router/index.js

import { createRouter, createWebHistory } from 'vue-router';
import LoginPage from '../views/Login.vue';
import RegisterPage from '../views/Register.vue';
import DashboardPage from '../views/Dashboard.vue';
import ProfilePage from '../views/Profile.vue';

const routes = [
  {
    path: '/',
    redirect: '/login' // Arahkan halaman root ke halaman login secara default
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
    // Nanti bisa ditambahkan proteksi rute di sini
  },
  {
    path: '/profile',
    name: 'Profile',
    component: ProfilePage
    // Nanti bisa ditambahkan proteksi rute di sini
  },
  // Rute fallback jika URL tidak ditemukan (opsional)
  {
    path: '/:catchAll(.*)',
    redirect: '/login'
  }
];

const router = createRouter({
  // Gunakan createWebHistory untuk URL bersih tanpa '#'
  history: createWebHistory(),
  routes // shorthand for `routes: routes`
});

export default router;