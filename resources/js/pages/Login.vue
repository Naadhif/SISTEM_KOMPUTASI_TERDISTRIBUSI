<template>
  <div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
      <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-900">Masuk ke STORETA</h1>

        <form @submit.prevent="handleLogin" class="space-y-6">
          <!-- Error Alert -->
          <div v-if="error" class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
            {{ error }}
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

          <!-- Password Input -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input
              v-model="form.password"
              type="password"
              placeholder="Masukkan password"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              required
            >
          </div>

          <!-- Remember Me & Forgot Password -->
          <div class="flex items-center justify-between">
            <label class="flex items-center">
              <input v-model="form.remember" type="checkbox" class="w-4 h-4 text-blue-600 rounded">
              <span class="ml-2 text-sm text-gray-700">Ingat saya</span>
            </label>
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Lupa password?</a>
          </div>

          <!-- Login Button -->
          <button
            type="submit"
            :disabled="loading"
            class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{ loading ? 'Memproses...' : 'Masuk' }}
          </button>
        </form>

        <!-- Divider -->
        <div class="mt-6 flex items-center">
          <div class="flex-1 border-t border-gray-300"></div>
          <span class="px-3 text-gray-500 text-sm">atau</span>
          <div class="flex-1 border-t border-gray-300"></div>
        </div>

        <!-- Social Login -->
        <div class="mt-6 space-y-3">
          <button class="w-full border border-gray-300 text-gray-700 font-semibold py-2 rounded-lg hover:bg-gray-50 transition flex items-center justify-center space-x-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"></path>
              <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"></path>
              <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"></path>
              <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"></path>
            </svg>
            <span>Google</span>
          </button>
        </div>

        <!-- Register Link -->
        <p class="mt-6 text-center text-gray-700 text-sm">
          Belum punya akun?
          <router-link to="/register" class="text-blue-600 hover:text-blue-800 font-semibold">
            Daftar sekarang
          </router-link>
        </p>
      </div>

      <!-- Demo Accounts -->
      <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h3 class="font-semibold text-blue-900 mb-3">Akun Demo untuk Testing:</h3>
        <div class="space-y-2 text-sm text-blue-800">
          <p><strong>Admin:</strong> admin@storeta.com / password123</p>
          <p><strong>Seller:</strong> seller1@storeta.com / password123</p>
          <p><strong>User:</strong> user@storeta.com / password123</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      form: {
        email: '',
        password: '',
        remember: false,
      },
      loading: false,
      error: '',
    };
  },
  methods: {
    handleLogin() {
      this.loading = true;
      this.error = '';

      axios.post('/api/auth/login', {
        email: this.form.email,
        password: this.form.password,
      })
        .then(response => {
          const { data } = response.data;
          localStorage.setItem('token', data.access_token);
          localStorage.setItem('user', JSON.stringify(data.user));

          // Update axios default header
          axios.defaults.headers.common['Authorization'] = `Bearer ${data.access_token}`;

          // Redirect based on role
          const redirectPath = data.user.role === 'admin' ? '/admin' : data.user.role === 'seller' ? '/seller' : '/';
          this.$router.push(redirectPath);
        })
        .catch(error => {
          this.error = error.response?.data?.message || 'Email atau password salah';
          this.loading = false;
        });
    },
  },
};
</script>

<style scoped>
/* Login page specific styles */
</style>
