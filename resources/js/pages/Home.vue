<template>
  <div class="space-y-12">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-xl p-12 md:p-20">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div>
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Selamat Datang di STORETA</h1>
          <p class="text-xl mb-8 text-blue-100">Platform e-commerce terpercaya dengan ribuan produk pilihan dari seller terbaik.</p>
          <div class="flex space-x-4">
            <router-link to="/products" class="px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition">
              Belanja Sekarang
            </router-link>
            <button class="px-6 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-blue-700 transition">
              Pelajari Lebih Lanjut
            </button>
          </div>
        </div>
        <div class="hidden md:block text-center">
          <svg class="w-full h-96" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="80" y="100" width="240" height="200" rx="8" fill="white" opacity="0.1" stroke="white" stroke-width="2"/>
            <circle cx="200" cy="150" r="40" fill="white" opacity="0.2"/>
            <rect x="100" y="200" width="200" height="60" rx="4" fill="white" opacity="0.15" stroke="white" stroke-width="1"/>
          </svg>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section>
      <h2 class="text-3xl font-bold mb-8 text-center">Mengapa Memilih STORETA?</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
          <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
              <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H3a1 1 0 00-1 1v10a1 1 0 001 1h14a1 1 0 001-1V6a1 1 0 00-1-1h-3a1 1 0 000-2 2 2 0 00-2 2H5z" clip-rule="evenodd"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-2">Produk Terlengkap</h3>
          <p class="text-gray-600">Jutaan produk dari ribuan seller terpercaya tersedia di satu platform.</p>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
          <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M8.16 2.75a.75.75 0 00-1.32 0l-1.43 4.4H.75a.75.75 0 00-.44 1.36l3.57 2.6-1.37 4.38a.75.75 0 001.15.85l3.59-2.63 3.59 2.63a.75.75 0 001.15-.85l-1.37-4.38 3.57-2.6a.75.75 0 00-.44-1.36h-4.66l-1.43-4.4z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-2">Harga Terbaik</h3>
          <p class="text-gray-600">Bandingkan harga dan dapatkan penawaran terbaik setiap hari.</p>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition">
          <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10.868 2.884l-.321-.772A.75.75 0 008.97 1.43h-2.693c-.355 0-.671.27-.788.648l-.02.063-2.694 8.124H3.75a.75.75 0 000 1.5H.977a.75.75 0 00-.726.503l-.497 1.542a.75.75 0 00.635.935l1.978.31.003.004c.596.44 1.491.749 2.561.749.523 0 1.032-.086 1.466-.22a2.53 2.53 0 00.946-.382l5.286-3.002a.75.75 0 00.3-1.025 60.07 60.07 0 001.271-2.242.75.75 0 10-1.36-.607c-.34.682-.646 1.33-.952 1.95H16.75a.75.75 0 00.75-.75 2.25 2.25 0 00-2.25-2.25h-5.379l-.468-1.408z" clip-rule="evenodd"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-2">Gratis Ongkir</h3>
          <p class="text-gray-600">Nikmati gratis ongkos kirim untuk pembelian tertentu ke seluruh Indonesia.</p>
        </div>
      </div>
    </section>

    <!-- Featured Products -->
    <section>
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold">Produk Pilihan</h2>
        <router-link to="/products" class="text-blue-600 hover:text-blue-800 font-semibold">
          Lihat Semua →
        </router-link>
      </div>
      <div v-if="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div v-for="product in featuredProducts" :key="product.id" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition cursor-pointer" @click="goToProduct(product.id)">
          <div class="h-48 bg-gray-200 flex items-center justify-center">
            <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
            </svg>
          </div>
          <div class="p-4">
            <h3 class="font-semibold text-gray-900 truncate">{{ product.name }}</h3>
            <p class="text-sm text-gray-600 mt-1">{{ product.description }}</p>
            <div class="mt-4 flex justify-between items-center">
              <span class="text-lg font-bold text-blue-600">Rp {{ formatPrice(product.price) }}</span>
              <button @click.stop="addToCart(product.id)" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                + Keranjang
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Categories Section -->
    <section>
      <h2 class="text-3xl font-bold mb-8">Kategori Populer</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-4">
        <div v-for="category in categories" :key="category.id" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center cursor-pointer">
          <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM15 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM15 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z"></path>
            </svg>
          </div>
          <h3 class="font-semibold text-gray-900">{{ category.name }}</h3>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'Home',
  data() {
    return {
      featuredProducts: [],
      categories: [],
      loading: true,
    };
  },
  mounted() {
    this.fetchProducts();
    this.fetchCategories();
  },
  methods: {
    fetchProducts() {
      axios.get('/api/products?limit=8')
        .then(response => {
          this.featuredProducts = response.data.data.slice(0, 8);
          this.loading = false;
        })
        .catch(error => {
          console.error('Error fetching products:', error);
          this.loading = false;
        });
    },
    fetchCategories() {
      axios.get('/api/categories')
        .then(response => {
          this.categories = response.data.data.slice(0, 6);
        })
        .catch(error => {
          console.error('Error fetching categories:', error);
        });
    },
    goToProduct(productId) {
      this.$router.push(`/products/${productId}`);
    },
    addToCart(productId) {
      // Add to cart logic
      alert('Produk ditambahkan ke keranjang');
    },
    formatPrice(price) {
      return new Intl.NumberFormat('id-ID').format(price);
    },
  },
};
</script>

<style scoped>
/* Home page specific styles */
</style>
