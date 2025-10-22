<template>
  <div>
    <h1>Ubah Profile</h1>
    <form @submit.prevent="handleUpdateProfile">
      <div>
        <label for="name">Nama:</label>
        <input type="text" id="name" v-model="name">
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email">
      </div>
      <button type="submit">Simpan Perubahan</button>
    </form>
    <p>
      <router-link to="/dashboard">Kembali ke Dashboard</router-link>
    </p>
  </div>
</template>

<script>
export default {
  name: 'ProfilePage',
  data() {
    return {
      // Static data for now
      name: 'Nama Pengguna Awal',
      email: 'user@example.com'
    };
  },
  methods: {
    handleUpdateProfile() {
      // Temporary: Log data
      console.log('Update profile:', this.name, this.email);
      // TODO: Add API call for profile update here later
      alert('Profil berhasil diperbarui!');
    }
  }
};
</script>