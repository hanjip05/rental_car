<template>
    <div>
      <h1>차량 예약 생성</h1>
      <form @submit.prevent="createReservation">
        <div>
          <label for="startDate">예약 시작일:</label>
          <input type="date" v-model="startDate" required />
        </div>
        <div>
          <label for="endDate">예약 종료일:</label>
          <input type="date" v-model="endDate" required />
        </div>
        <button type="submit">예약하기</button>
      </form>
      <p v-if="errorMessage">{{ errorMessage }}</p>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        startDate: '',
        endDate: '',
        errorMessage: ''
      };
    },
    methods: {
      createReservation() {
        if (this.startDate && this.endDate) {
          // API 호출 예시
          axios.post('/api/reservations', { startDate: this.startDate, endDate: this.endDate })
            .then(response => {
              // 성공 처리
              alert('예약이 성공적으로 생성되었습니다.');
              // 추가적인 로직 (예: 리다이렉트)
            })
            .catch(error => {
              this.errorMessage = '예약 생성에 실패했습니다.';
            });
        } else {
          this.errorMessage = '모든 필드를 입력해야 합니다.';
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* 스타일을 여기에 추가하세요 */
  h1 {
    font-size: 24px;
    margin-bottom: 20px;
  }
  form {
    display: flex;
    flex-direction: column;
  }
  label {
    margin: 10px 0 5px;
  }
  input {
    padding: 8px;
    margin-bottom: 15px;
  }
  button {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
  }
  button:hover {
    background-color: #0056b3;
  }
  </style>