<template>
  <div>
    <h1>Dashboard</h1>
    <p>Selamat datang! Anda berhasil login.</p>
    <nav>
      <router-link to="/profile">Ubah Profile</router-link> |
      <button @click="handleLogout" class="logout-button">Logout</button>
    </nav>
  </div>
</template>

<script>
// Script section remains the same
export default {
  name: 'DashboardPage',
  methods: {
    handleLogout() {
      console.log('Logout');
      this.$router.push('/login');
    }
  }
};
</script>

<style scoped> /* Scoped means these styles ONLY apply to Dashboard.vue */
p {
  margin-bottom: 20px;
}
.logout-button {
    background-color: #dc3545; /* Red color for logout */
    border: none;
    color: white;
    padding: 8px 15px; /* Smaller padding */
    font-size: 0.9rem;
    cursor: pointer;
    border-radius: 4px;
}
.logout-button:hover {
    background-color: #c82333;
}
</style>