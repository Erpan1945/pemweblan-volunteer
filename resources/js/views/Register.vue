<template>
  <div>
    <h1>Halaman Registrasi</h1>
    <form @submit.prevent="handleRegister">
      <div>
        <label for="name">Nama:</label>
        <input type="text" id="name" v-model="name" required>
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email" required>
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="password" required>
      </div>
       <div>
        <label for="password_confirmation">Konfirmasi Password:</label>
        <input type="password" id="password_confirmation" v-model="password_confirmation" required>
      </div>
      <button type="submit">Register</button>
    </form>
    <p>
      Sudah punya akun? <router-link to="/login">Login di sini</router-link>
    </p>
  </div>
</template>

<script>
export default {
  name: 'RegisterPage',
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    };
  },
  methods: {
    handleRegister() {
      // Temporary: Log data and navigate to login
      console.log('Register attempt:', this.email);
      // TODO: Add API call for registration here later
      this.$router.push('/login'); // Navigate to login after fake registration
    }
  }
};
</script>