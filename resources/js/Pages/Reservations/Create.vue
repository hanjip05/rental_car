<template>
  <AppLayout>
  <div class="container mx-auto p-4 bg-white shadow-lg rounded-lg box">
    <h1 class="text-4xl font-bold mb-4 text-center text-gray-800">차량 예약</h1>
    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block text-lg font-semibold mb-2 text-gray-700">예약 시작일</label>
        <input 
          type="date" 
          v-model="form.start_date" 
          @change="updateStartDateText" 
          :min="minStartDate" 
          class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
        />
        <div class="text-green-500 mt-2">선택한 시작일: {{ startDateText }}</div>
        <div v-if="form.errors.start_date" class="text-red-500 mt-2">{{ form.errors.start_date }}</div>
      </div>
      <div>
        <label class="block text-lg font-semibold mb-2 text-gray-700">예약 종료일</label>
        <input 
          type="date" 
          v-model="form.end_date" 
          @change="updateEndDateText" 
          :min="minEndDate" 
          class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
        />
        <div class="text-green-500 mt-2">선택한 종료일: {{ endDateText }}</div>
        <div v-if="form.errors.end_date" class="text-red-500 mt-2">{{ form.errors.end_date }}</div>
      </div>
      <div v-if="!isAvailable" class="text-red-500 mt-4">
        날짜가 중복되었습니다. 다시 선택해주세요.
      </div>
      <button type="submit" class="button mt-4" :disabled="!isAvailable || isReserved">예약</button>
      <p v-if="isReserved" class="text-red-500 mt-4">이 차량은 이미 예약되어 있습니다.</p>
    </form>
  </div>
</AppLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';


const props = defineProps({
  car: Object
});

const form = useForm({
  start_date: '',
  end_date: ''
});

const isAvailable = ref(true);
const isReserved = ref(false);
const startDateText = ref('');
const endDateText = ref('');
const minStartDate = ref('');
const minEndDate = ref('');

onMounted(() => {
  const today = new Date();
  minStartDate.value = today.toISOString().split('T')[0];
  checkReservationStatus();
});

watch([() => form.start_date, () => form.end_date], () => {
  checkAvailability();
});

async function checkReservationStatus() {
  try {
    const response = await axios.get(`/reservations/status/${props.car.id}`);
    isReserved.value = response.data.is_reserved;
  } catch (error) {
    console.error('Error checking reservation status:', error);
  }
}

async function checkAvailability() {
  if (form.start_date && form.end_date) {
    try {
      const response = await axios.post('/reservations/check-availability', {
        car_id: props.car.id,
        start_date: form.start_date,
        end_date: form.end_date
      });
      isAvailable.value = response.data.available;
    } catch (error) {
      console.error('Error checking availability:', error);
      isAvailable.value = false; // 오류 발생 시 예약 불가로 설정
    }
  }
}

function updateStartDateText() {
  if (form.start_date) {
    startDateText.value = new Date(form.start_date).toLocaleDateString('ko-KR');
    minEndDate.value = form.start_date; // 예약 시작일을 종료일의 최소 날짜로 설정
  }
}

function updateEndDateText() {
  if (form.end_date) {
    endDateText.value = new Date(form.end_date).toLocaleDateString('ko-KR');
  }
}

function submit() {
  form.post(`/reservations/store/${props.car.id}`, {
    onSuccess: () => {
      window.location.href = `/cars/${props.car.id}`;
    },
    onError: (errors) => {
      alert('예약 요청에 실패했습니다: ' + errors.message);
    }
  });
}
</script>

<style>
  .container {
    max-width: 600px;
    margin: auto;
    padding: 1.5rem;
    background-color: rgba(255, 255, 255, 0.9);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 0.75rem;
    transition: all 0.3s ease-in-out;
  }

  .container:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  }

  .button {
    display: inline-block;
    font-weight: 500;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.75rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    background-color: #3b82f6; /* 버튼 배경색 */
    color: white; /* 버튼 글자색 */
  }

  .button:hover {
    background-color: #2563eb; /* 버튼 호버 색상 */
  }

  .button:focus, .button.focus {
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.5);
  }
</style>
