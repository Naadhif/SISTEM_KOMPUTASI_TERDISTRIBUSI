<template>
  <div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg p-8">
      <h1 class="text-4xl font-bold mb-2">Produk</h1>
      <p class="text-blue-100">Jelajahi ribuan produk dari seller terpercaya</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      <!-- Sidebar Filters -->
      <div class="md:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 space-y-6">
          <!-- Search -->
          <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">Cari Produk</label>
            <input
              v-model="filters.search"
              type="text"
              placeholder="Ketik nama produk..."
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              @input="applyFilters"
            >
          </div>

          <!-- Category Filter -->
          <div>
            <label class="block text-sm font-semibold text-gray-900 mb-3">Kategori</label>
            <div class="space-y-2">
              <label class="flex items-center">
                <input
                  type="radio"
                  value=""
                  v-model="filters.category"
                  @change="applyFilters"
                  class="w-4 h-4 text-blue-600"
                >
                <span class="ml-2 text-sm text-gray-700">Semua Kategori</span>
              </label>
              <label v-for="category in categories" :key="category.id" class="flex items-center">
                <input
                  type="radio"
                  :value="category.id"
                  v-model="filters.category"
                  @change="applyFilters"
                  class="w-4 h-4 text-blue-600"
                >
                <span class="ml-2 text-sm text-gray-700">{{ category.name }}</span>
              </label>
            </div>
          </div>

          <!-- Price Filter -->
          <div>
            <label class="block text-sm font-semibold text-gray-900 mb-3">Harga</label>
            <div class="space-y-2">
              <label class="flex items-center">
                <input type="checkbox" value="0-100000" v-model="filters.price" @change="applyFilters" class="w-4 h-4 text-blue-600">
                <span class="ml-2 text-sm text-gray-700">Rp 0 - 100.000</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" value="100000-500000" v-model="filters.price" @change="applyFilters" class="w-4 h-4 text-blue-600">
                <span class="ml-2 text-sm text-gray-700">Rp 100.000 - 500.000</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" value="500000-1000000" v-model="filters.price" @change="applyFilters" class="w-4 h-4 text-blue-600">
                <span class="ml-2 text-sm text-gray-700">Rp 500.000 - 1.000.000</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" value="1000000+" v-model="filters.price" @change="applyFilters" class="w-4 h-4 text-blue-600">
                <span class="ml-2 text-sm text-gray-700">Di atas Rp 1.000.000</span>
              </label>
            </div>
          </div>

          <!-- Rating Filter -->
          <div>
            <label class="block text-sm font-semibold text-gray-900 mb-3">Rating</label>
            <div class="space-y-2">
              <label v-for="rating in [5, 4, 3, 2, 1]" :key="rating" class="flex items-center">
                <input
                  type="checkbox"
                  :value="rating"
                  v-model="filters.rating"
                  @change="applyFilters"
                  class="w-4 h-4 text-blue-600"
                >
                <span class="ml-2 text-sm text-gray-700">
                  <span v-for="i in rating" :key="i" class="text-yellow-400">★</span>
                  ke atas
                </span>
              </label>
            </div>
          </div>

          <!-- Clear Filters -->
          <button
            @click="clearFilters"
            class="w-full px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition"
          >
            Hapus Filter
          </button>
        </div>
      </div>

      <!-- Products Grid -->
      <div class="md:col-span-3">
        <!-- Sort Options -->
        <div class="flex justify-between items-center mb-6">
          <p class="text-gray-600">Menampilkan {{ filteredProducts.length }} produk</p>
          <select
            v-model="filters.sort"
            @change="applyFilters"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="">Urutkan</option>
            <option value="newest">Terbaru</option>
            <option value="price-asc">Harga Termurah</option>
            <option value="price-desc">Harga Termahal</option>
            <option value="popular">Paling Populer</option>
          </select>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="text-center py-12">
          <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
        </div>

        <!-- Empty State -->
        <div v-else-if="filteredProducts.length === 0" class="text-center py-12">
          <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
          </svg>
          <p class="text-gray-600 text-lg">Tidak ada produk yang ditemukan</p>
        </div>

        <!-- Products Grid -->
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="product in filteredProducts"
            :key="product.id"
            class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition cursor-pointer"
            @click="goToProduct(product.id)"
          >
            <!-- Product Image -->
            <div class="h-48 bg-gray-200 flex items-center justify-center relative">
              <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
              </svg>
              <div v-if="product.stock < 10" class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-semibold">
                Stok Terbatas
              </div>
            </div>

            <!-- Product Info -->
            <div class="p-4">
              <h3 class="font-semibold text-gray-900 truncate">{{ product.name }}</h3>
              <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ product.description }}</p>

              <!-- Rating -->
              <div class="flex items-center mt-2">
                <div class="flex text-yellow-400">
                  <span v-for="i in 5" :key="i">★</span>
                </div>
                <span class="text-sm text-gray-600 ml-2">(128 ulasan)</span>
              </div>

              <!-- Price & Action -->
              <div class="mt-4 flex justify-between items-center">
                <div>
                  <p class="text-lg font-bold text-blue-600">Rp {{ formatPrice(product.price) }}</p>
                  <p class="text-xs text-gray-500">Stok: {{ product.stock }}</p>
                </div>
                <button
                  @click.stop="addToCart(product.id)"
                  class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm font-semibold"
                >
                  + Keranjang
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Products',
  data() {
    return {
      products: [],
      categories: [],
      loading: true,
      filters: {
        search: '',
        category: '',
        price: [],
        rating: [],
        sort: '',
      },
    };
  },
  computed: {
    filteredProducts() {
      let filtered = this.products;

      if (this.filters.search) {
        filtered = filtered.filter(p =>
          p.name.toLowerCase().includes(this.filters.search.toLowerCase())
        );
      }

      if (this.filters.category) {
        filtered = filtered.filter(p => p.category_id === Number(this.filters.category));
      }

      // Sort
      if (this.filters.sort === 'price-asc') {
        filtered.sort((a, b) => a.price - b.price);
      } else if (this.filters.sort === 'price-desc') {
        filtered.sort((a, b) => b.price - a.price);
      } else if (this.filters.sort === 'newest') {
        filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
      }

      return filtered;
    },
  },
  mounted() {
    this.fetchProducts();
    this.fetchCategories();
  },
  methods: {
    fetchProducts() {
      axios.get('/api/products')
        .then(response => {
          this.products = response.data.data;
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
          this.categories = response.data.data;
        })
        .catch(error => {
          console.error('Error fetching categories:', error);
        });
    },
    applyFilters() {
      // Filters are applied via computed property
    },
    clearFilters() {
      this.filters = {
        search: '',
        category: '',
        price: [],
        rating: [],
        sort: '',
      };
    },
    goToProduct(productId) {
      this.$router.push(`/products/${productId}`);
    },
    addToCart(productId) {
      alert('Produk ditambahkan ke keranjang');
    },
    formatPrice(price) {
      return new Intl.NumberFormat('id-ID').format(price);
    },
  },
};
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
