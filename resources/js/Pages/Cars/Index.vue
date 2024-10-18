<template>
  <AppLayout>
    <div class="container mx-auto p-4 box">
      <h1 class="text-4xl font-bold mb-4">차량 목록</h1>
      <template v-if="$page.props.auth && $page.props.auth.user">
        <Link :href="createRoute" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">새로운 차량 추가</Link>
      </template>
      <ul class="space-y-4">
        <li v-for="car in cars" :key="car.id" class="border p-4 rounded bg-white shadow">
          <Link :href="`/cars/${car.id}`" class="text-xl">
            {{ car.name }} {{ car.model }} ({{ car.year }})
          </Link>
          <span v-if="car.is_reserved" class="ml-4 text-red-500">예약됨</span>
          <span v-else class="ml-4 text-green-500">대여 가능</span>
        </li>
      </ul>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  cars: Array,
  createRoute: {
    type: String,
    default: '/cars/create' // 기본값 설정
  }
});
</script>

<style scoped>
.container {
  max-width: 800px;
  margin: auto;
  padding: 1.5rem;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>
