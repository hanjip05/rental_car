<template>
  <AppLayout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
        <div>
          <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            회원가입
          </h2>
        </div>
        <form class="mt-8 space-y-6" @submit.prevent="submit">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">이름</label>
            <input id="name" name="name" type="text" required v-model="form.name" class="mt-1 block w-full" autocomplete="name" />
          </div>
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">이메일</label>
            <input id="email" name="email" type="email" required v-model="form.email" class="mt-1 block w-full" autocomplete="email" />
          </div>
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">비밀번호</label>
            <input id="password" name="password" type="password" required v-model="form.password" class="mt-1 block w-full" autocomplete="new-password" />
          </div>
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">비밀번호 확인</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required v-model="form.password_confirmation" class="mt-1 block w-full" autocomplete="new-password" />
          </div>
          <div>
            <button type="submit" class="button w-full">
              회원가입
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { useRouter } from 'vue-router';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const router = useRouter();

const submit = () => {
  form.post('/register', {
    onSuccess: () => {
      router.push('/'); // 회원가입 후 홈 페이지로 이동
    },
    onError: (errors) => {
      console.error('Register errors:', errors);
    },
  });
};
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: auto;
  padding: 1.5rem;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>
