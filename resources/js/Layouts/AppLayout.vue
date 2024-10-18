<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow box">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        <Link href="/" class="flex items-center">
          <img src="/img/logo.png" alt="사이트 로고" class="h-8 mr-3 cursor-pointer" />
        </Link>
        <div class="flex justify-end space-x-4 float-right w">
          <Link href="/cars" class="btn text-gray-600 hover:text-gray-900">차량 목록</Link>
          <Link href="/cars/create" class="btn text-gray-600 hover:text-gray-900">차량 등록</Link>
          <template v-if="$page.props.auth && $page.props.auth.user">
            <button @click="logout" class="btn text-gray-600 hover:text-gray-900">로그아웃</button>
          </template>
          <template v-else>
            <Link href="/login" class="btn text-gray-600 hover:text-gray-900">로그인</Link>
            <Link href="/register" class="btn text-gray-600 hover:text-gray-900">회원가입</Link>
          </template>
        </div>
      </div>
    </nav>

    <main>
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <slot></slot>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

const form = useForm({});

const logout = () => {
  form.post('/logout');
};
</script>

<style scoped>
nav {
  background-color: #ffffff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.float-right {
    float: right;
}

.h-8 {
    height: 11rem;
}

.mr-3 {
    margin-right: 11rem;
}

.btn {
  display: inline-block;
  padding: 1rem 2.25rem; /* 버튼 크기 증가 */
  border: 1px solid transparent;
  border-radius: 0.375rem;
  background-color: #3b82f6; /* 파란색 */
  color: #ffffff; /* 텍스트 색상 */
  text-align: center;
  cursor: pointer;
  transition: background-color 0.2s;
}

/* 버튼 위치 조정 */
.flex {
  margin-top: 3rem; /* 위쪽 여백 추가 */
}

.justify-end {
    justify-content: flex-end;
    padding: 0px 10px;
    border:none;
}

.btn + .btn {
    margin-left: 15px;

}

.btn:hover {
  background-color: #2563eb; /* 더 진한 파란색 */
}
</style>
