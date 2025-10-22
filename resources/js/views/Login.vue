<template>
  <div>
    <h1>Halaman Login</h1>
    <form @submit.prevent="handleLogin">
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email" required>
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="password" required>
      </div>
      <button type="submit">Login</button>
    </form>
    <p>
      Belum punya akun? <router-link to="/register">Daftar di sini</router-link>
    </p>
  </div>
</template>

<script>
export default {
  name: 'LoginPage',
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    handleLogin() {
      // Temporary: Log data and navigate to dashboard
      console.log('Login attempt:', this.email);
      // TODO: Add API call for login here later
      this.$router.push('/dashboard'); // Navigate after fake login
    }
  }
};
</script>