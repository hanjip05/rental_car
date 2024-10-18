<template>
  <AppLayout>
    <div class="container mx-auto p-4 box">
      <h1 class="text-4xl font-bold mb-4">차량 상세 정보</h1>
      <div class="border p-4 rounded mb-4 bg-white shadow">
        <p><strong>이름:</strong> {{ car.name }}</p>
        <p><strong>모델:</strong> {{ car.model }}</p>
        <p><strong>연식:</strong> {{ car.year }}</p>
        <p><strong>상태:</strong> {{ car.is_reserved ? '예약됨' : '대여 가능' }}</p>
      </div>
      <div class="space-x-4">
        <template v-if="$page.props.auth && $page.props.auth.user">
          <template v-if="car.is_reserved">
            <button @click="cancelReservation" class="bg-red-500 text-white px-4 py-2 rounded inline-block">
              예약 취소하기
            </button>
          </template>
          <template v-else>
            <Link :href="`/reservations/create/${car.id}`" class="bg-green-500 text-white px-4 py-2 rounded inline-block">
              이 차량 예약하기
            </Link>
          </template>
        </template>
        <Link href="/cars" class="bg-blue-500 text-white px-4 py-2 rounded inline-block">
          목록으로 돌아가기
        </Link>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';
import { defineProps } from 'vue';

const props = defineProps({
  car: Object,
});

const user = usePage().props.auth.user;
const car = ref(props.car);

function cancelReservation() {
  axios.post(`/reservations/cancel/${car.value.id}`)
    .then(() => {
      window.location.reload(); // 페이지 새로 고침
    })
    .catch(error => {
      console.error('예약 취소 실패:', error);
    });
}
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: auto;
  padding: 1.5rem;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>
