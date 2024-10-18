<template>
  <AppLayout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
        <div>
          <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            로그인
          </h2>
        </div>
        <form class="mt-8 space-y-6" @submit.prevent="submit">
          <input type="hidden" name="remember" value="true" />
          <div class="rounded-md shadow-sm -space-y-px">
            <div>
              <label for="email-address" class="sr-only">이메일 주소</label>
              <input id="email-address" name="email" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="이메일 주소" v-model="form.email" />
            </div>
            <div>
              <label for="password" class="sr-only">비밀번호</label>
              <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="비밀번호" v-model="form.password" />
            </div>
            <p class="text-center">아직 계정이 없으세요? <Link href="/register" class="text-blue-500 underline">회원가입</Link></p> <!-- 버튼을 링크로 변경 -->
          </div>

          <div>
            <button type="submit" class="button w-full">로그인</button>
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
import { Link } from '@inertiajs/vue3';

const form = useForm({
  email: '',
  password: '',
});

const router = useRouter();

const submit = () => {
  form.post('/login', {
    onSuccess: () => {
      router.push('/'); // 로그인 후 홈 페이지로 이동
    },
    onError: (errors) => {
      console.error('Login errors:', errors);
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
