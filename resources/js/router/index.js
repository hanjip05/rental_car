import { createRouter, createWebHistory } from 'vue-router';
import Home from '../Pages/Home.vue';
import Login from '@/Pages/Auth/Login.vue';
import Register from '@/Pages/Auth/Register.vue'; // 경로가 올바른지 확인

const routes = [
  { path: '/', component: Home },
  {
    path: '/login',
    component: Login,
  },
  {
    path: '/register',
    name: 'Register',
    component: Register, // Register 컴포넌트가 올바르게 설정되어 있는지 확인
  },
  // 다른 라우트들...
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
