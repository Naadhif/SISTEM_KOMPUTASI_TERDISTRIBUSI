<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <router-link to="/" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
              <span class="text-white font-bold">S</span>
            </div>
            <span class="text-xl font-bold text-gray-900">STORETA</span>
          </router-link>

          <!-- Search Bar -->
          <div class="hidden md:flex flex-1 max-w-md mx-8">
            <input
              type="text"
              placeholder="Cari produk..."
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
          </div>

          <!-- Nav Links -->
          <div class="flex items-center space-x-4">
            <router-link to="/products" class="text-gray-700 hover:text-blue-600 transition">
              Produk
            </router-link>

            <!-- 🔥 TAMBAHKAN MENU INTEGRATIONS DI SINI -->
            <router-link to="/integrations" class="text-gray-700 hover:text-blue-600 transition flex items-center gap-1 font-medium">
              <span>🔗</span> Integrations
            </router-link>

            <div v-if="!isLoggedIn" class="flex space-x-2">
              <router-link to="/login" class="px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition">
                Masuk
              </router-link>
              <router-link to="/register" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Daftar
              </router-link>
            </div>

            <div v-else class="flex items-center space-x-4">
              <router-link to="/cart" class="relative">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span v-if="cartCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                  {{ cartCount }}
                </span>
              </router-link>

              <div class="relative group">
                <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                  <span>{{ userName }}</span>
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                  </svg>
                </button>

                <!-- Dropdown Menu -->
                <div class="absolute right-0 w-48 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                  <router-link to="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Profil Saya
                  </router-link>
                  <router-link v-if="userRole === 'admin'" to="/admin" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Admin Dashboard
                  </router-link>
                  <router-link v-if="userRole === 'seller'" to="/seller" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Seller Dashboard
                  </router-link>
                  <button @click="logout" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                    Keluar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <router-view />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div>
            <h3 class="text-white font-bold mb-4">STORETA</h3>
            <p class="text-sm">Platform e-commerce terpercaya untuk semua kebutuhan belanja online Anda.</p>
          </div>
          <div>
            <h4 class="text-white font-semibold mb-4">Kategori</h4>
            <ul class="space-y-2 text-sm">
              <li><a href="#" class="hover:text-white transition">Elektronik</a></li>
              <li><a href="#" class="hover:text-white transition">Fashion</a></li>
              <li><a href="#" class="hover:text-white transition">Makanan</a></li>
              <li><a href="#" class="hover:text-white transition">Buku</a></li>
            </ul>
          </div>
          <div>
            <h4 class="text-white font-semibold mb-4">Bantuan</h4>
            <ul class="space-y-2 text-sm">
              <li><a href="#" class="hover:text-white transition">Pusat Bantuan</a></li>
              <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
              <li><a href="#" class="hover:text-white transition">Syarat & Ketentuan</a></li>
              <li><a href="#" class="hover:text-white transition">Hubungi Kami</a></li>
            </ul>
          </div>
          <div>
            <h4 class="text-white font-semibold mb-4">Ikuti Kami</h4>
            <div class="flex space-x-4">
              <a href="#" class="hover:text-white transition">Facebook</a>
              <a href="#" class="hover:text-white transition">Instagram</a>
              <a href="#" class="hover:text-white transition">Twitter</a>
            </div>
          </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
          <p>&copy; 2026 STORETA. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      isLoggedIn: false,
      userName: '',
      userRole: '',
      cartCount: 0,
    };
  },
  mounted() {
    this.checkAuth();
    window.addEventListener('storage', this.checkAuth);
    this.$router.afterEach(() => {
      this.checkAuth();
    });
  },
  beforeUnmount() {
    window.removeEventListener('storage', this.checkAuth);
  },
  methods: {
    checkAuth() {
      const user = localStorage.getItem('user');
      if (user) {
        try {
          const userData = JSON.parse(user);
          this.isLoggedIn = true;
          this.userName = userData.name;
          this.userRole = userData.role;
        } catch (e) {
          this.isLoggedIn = false;
        }
      } else {
        this.isLoggedIn = false;
      }
    },
    logout() {
      if (confirm('Apakah Anda yakin ingin keluar?')) {
        axios.post('/api/auth/logout')
          .then(() => {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
          this.isLoggedIn = false;
          this.$router.push('/');
        })
          .catch(error => {
            console.error('Logout error:', error);
          });
      }
    }
  }
};
</script>

<style scoped>
/* Add any component-specific styles here */
</style>