<template>
  <AppLayout>
    <div class="min-h-screen bg-gray-100">
      <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 box">
          <h1 class="text-3xl font-bold text-gray-900">렌터카 서비스</h1>
          <p class="mt-2 text-gray-600">편리하고 빠른 차량 대여 서비스를 제공합니다. 다양한 차량을 선택하고 예약하세요!</p>
        </div>
      </header>

      <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
          <section class="mb-8">
            <!-- <h2 class="text-2xl font-bold text-gray-800">사이트 설명</h2>
            <p class="mt-2 text-gray-600">이 사이트는 다양한 차량을 쉽게 대여할 수 있는 서비스를 제공합니다. 사용자는 차량을 검색하고, 예약하고, 관리할 수 있습니다.</p> -->
          </section>
          <section>
            <!-- <h2 class="text-2xl font-bold text-gray-800">Q&A</h2>
            <ul class="mt-2 text-gray-600">
              <li>Q: 어떻게 차량을 예약하나요?</li>
              <li>A: 차량 목록에서 원하는 차량을 선택하고 예약 버튼을 클릭하세요.</li>
              <li>Q: 예약을 취소할 수 있나요?</li>
              <li>A: 네, 예약한 차량의 상세 페이지에서 예약 취소 버튼을 클릭하세요.</li>
            </ul> -->
          </section>
        </div>  
      </main>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<style scoped>
header {
  background-color: #ffffff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.button {
  display: inline-block;
  padding: 10px 20px;
  font-size: 16px;
  color: white;
  background-color: #3b82f6; /* 버튼 배경색 */
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}
.button:hover {
  background-color: #2563eb; /* 버튼 호버 색상 */
}
</style>
