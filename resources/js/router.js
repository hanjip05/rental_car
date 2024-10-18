import { createRouter, createWebHistory } from 'vue-router';
import Show from './Pages/Cars/Show.vue'; // 경로 확인
import ReservationCreate from './Pages/ReservationCreate.vue';  // 경로를 실제 파일 위치에 맞게 조정

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('./Pages/Home.vue'), // 경로를 실제 파일 위치에 맞게 조정
  },
  {
    path: '/cars/:id',
    component: Show,
    name: 'cars.show',
  },
  {
    path: '/reservations/create/:id',
    name: 'reservationCreate',
    component: ReservationCreate,
    props: true
  },
  // 다른 라우트들...
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
