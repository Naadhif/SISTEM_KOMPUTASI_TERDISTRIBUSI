<template>
  <div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
      <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-900">Daftar di STORETA</h1>

        <form @submit.prevent="handleRegister" class="space-y-6">
          <!-- Error Alert -->
          <div v-if="error" class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
            {{ error }}
          </div>

          <!-- Success Alert -->
          <div v-if="success" class="p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
            {{ success }}
          </div>

          <!-- Name Input -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
            <input
              v-model="form.name"
              type="text"
              placeholder="Masukkan nama lengkap"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              required
            >
          </div>

          <!-- Email Input -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input
              v-model="form.email"
              type="email"
              placeholder="nama@email.com"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              required
            >
          </div>

          <!-- Role Selection -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Daftar Sebagai</label>
            <div class="space-y-3">
              <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition" :class="form.role === 'user' ? 'border-blue-500 bg-blue-50' : 'border-gray-200'">
                <input
                  v-model="form.role"
                  type="radio"
                  value="user"
                  class="w-4 h-4 text-blue-600"
                >
                <span class="ml-3">
                  <span class="font-semibold text-gray-900">Pembeli</span>
                  <p class="text-xs text-gray-600">Belanja produk dari seller</p>
                </span>
              </label>

              <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition" :class="form.role === 'seller' ? 'border-blue-500 bg-blue-50' : 'border-gray-200'">
                <input
                  v-model="form.role"
                  type="radio"
                  value="seller"
                  class="w-4 h-4 text-blue-600"
                >
                <span class="ml-3">
                  <span class="font-semibold text-gray-900">Penjual</span>
                  <p class="text-xs text-gray-600">Jual produk di STORETA</p>
                </span>
              </label>
            </div>
          </div>

          <!-- Password Input -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input
              v-model="form.password"
              type="password"
              placeholder="Minimal 8 karakter"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              required
              minlength="8"
            >
            <p class="text-xs text-gray-500 mt-1">Gunakan kombinasi huruf, angka, dan simbol</p>
          </div>

          <!-- Password Confirmation -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
            <input
              v-model="form.password_confirmation"
              type="password"
              placeholder="Ulangi password"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              required
            >
          </div>

          <!-- Terms & Conditions -->
          <label class="flex items-start">
            <input v-model="form.agree" type="checkbox" class="w-4 h-4 text-blue-600 rounded mt-1">
            <span class="ml-2 text-sm text-gray-700">
              Saya setuju dengan
              <a href="#" class="text-blue-600 hover:text-blue-800">Syarat & Ketentuan</a>
              dan
              <a href="#" class="text-blue-600 hover:text-blue-800">Kebijakan Privasi</a>
            </span>
          </label>

          <!-- Register Button -->
          <button
            type="submit"
            :disabled="loading || !form.agree"
            class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{ loading ? 'Memproses...' : 'Daftar' }}
          </button>
        </form>

        <!-- Login Link -->
        <p class="mt-6 text-center text-gray-700 text-sm">
          Sudah punya akun?
          <router-link to="/login" class="text-blue-600 hover:text-blue-800 font-semibold">
            Masuk sekarang
          </router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Register',
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: 'user',
        agree: false,
      },
      loading: false,
      error: '',
      success: '',
    };
  },
  methods: {
    handleRegister() {
      if (this.form.password !== this.form.password_confirmation) {
        this.error = 'Password tidak sesuai';
        return;
      }

      this.loading = true;
      this.error = '';
      this.success = '';

      axios.post('/api/auth/register', {
        name: this.form.name,
        email: this.form.email,
        password: this.form.password,
        password_confirmation: this.form.password_confirmation,
        role: this.form.role,
      })
        .then(response => {
          const { data } = response.data;
          localStorage.setItem('token', data.access_token);
          localStorage.setItem('user', JSON.stringify(data.user));

          // Update axios default header
          axios.defaults.headers.common['Authorization'] = `Bearer ${data.access_token}`;

          this.success = 'Pendaftaran berhasil! Mengalihkan...';

          setTimeout(() => {
            this.$router.push('/');
          }, 2000);
        })
        .catch(error => {
          this.error = error.response?.data?.message || 'Terjadi kesalahan saat pendaftaran';
          this.loading = false;
        });
    },
  },
};
</script>

<style scoped>
/* Register page specific styles */
</style>
