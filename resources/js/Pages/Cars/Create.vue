<template>
  <AppLayout>
    <div>
      <h1>차량 추가</h1>
      <div v-if="authUser">
        <form @submit.prevent="submit">
          <div>
            <label for="name">브랜드</label>
            <input id="name" v-model="form.name" type="text" required autocomplete="name" />
          </div>
          <div>
            <label for="model">모델</label>
            <input id="model" v-model="form.model" type="text" required autocomplete="model" />
          </div>
          <div>
            <label for="year">연식</label>
            <input id="year" v-model="form.year" type="number" required autocomplete="year" />
          </div>
          <button type="submit">차량 등록</button>
        </form>
      </div>
      <span v-else>차량을 등록하려면 로그인 해주세요.</span>
    </div>
  </AppLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const form = useForm({
  name: '',
  model: '',
  year: '',
});

const { props } = usePage();
const authUser = props.auth?.user;

const submit = () => {
  form.post('/cars', {
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>
