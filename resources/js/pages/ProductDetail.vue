<template>
  <div class="space-y-8">
    <div v-if="loading" class="text-center py-12">
      <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
    </div>

    <div v-else-if="product" class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Product Image -->
      <div>
        <div class="h-96 bg-gray-200 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-32 h-32 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
          </svg>
        </div>
        <div class="grid grid-cols-4 gap-2">
          <div v-for="i in 4" :key="i" class="h-20 bg-gray-200 rounded cursor-pointer hover:opacity-80"></div>
        </div>
      </div>

      <!-- Product Info -->
      <div class="space-y-6">
        <!-- Breadcrumb -->
        <div class="flex items-center space-x-2 text-sm text-gray-600">
          <router-link to="/" class="hover:text-blue-600">Home</router-link>
          <span>/</span>
          <router-link to="/products" class="hover:text-blue-600">Produk</router-link>
          <span>/</span>
          <span class="text-gray-900">{{ product.name }}</span>
        </div>

        <!-- Product Title -->
        <div>
          <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ product.name }}</h1>
          <div class="flex items-center space-x-4">
            <div class="flex text-yellow-400">
              <span v-for="i in 5" :key="i">★</span>
            </div>
            <span class="text-gray-600">(128 ulasan)</span>
            <span class="text-gray-500">{{ product.stock > 0 ? 'Tersedia' : 'Habis' }}</span>
          </div>
        </div>

        <!-- Price -->
        <div class="border-t border-b border-gray-200 py-4">
          <div class="text-4xl font-bold text-blue-600 mb-2">Rp {{ formatPrice(product.price) }}</div>
          <div class="text-sm text-gray-600 space-y-1">
            <p>Harga asli: <span class="line-through">Rp {{ formatPrice(product.price + 50000) }}</span></p>
            <p>Hemat: Rp {{ formatPrice(50000) }} (10%)</p>
          </div>
        </div>

        <!-- Stock Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
          <p class="text-sm text-gray-700">
            <strong>Stok tersedia:</strong> {{ product.stock }} item
          </p>
          <div v-if="product.stock < 10" class="text-red-600 text-sm mt-2">
            ⚠️ Stok terbatas, pesan sekarang!
          </div>
        </div>

        <!-- Description -->
        <div>
          <h2 class="text-lg font-bold text-gray-900 mb-3">Deskripsi Produk</h2>
          <p class="text-gray-600 leading-relaxed">{{ product.description }}</p>
        </div>

        <!-- Seller Info -->
        <div class="bg-gray-50 rounded-lg p-4">
          <div class="flex items-center justify-between mb-3">
            <div>
              <p class="text-sm text-gray-600">Dijual oleh</p>
              <p class="font-semibold text-gray-900">{{ product.seller?.name || 'STORETA Official' }}</p>
            </div>
            <button class="px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-50 transition">
              Kunjungi Toko
            </button>
          </div>
          <div class="flex space-x-6 text-sm">
            <div>
              <p class="text-gray-600">Rating</p>
              <p class="font-semibold">4.8</p>
            </div>
            <div>
              <p class="text-gray-600">Produk</p>
              <p class="font-semibold">1.2K</p>
            </div>
            <div>
              <p class="text-gray-600">Pengikut</p>
              <p class="font-semibold">5.3K</p>
            </div>
          </div>
        </div>

        <!-- Quantity & Action -->
        <div class="space-y-4">
          <div class="flex items-center space-x-4">
            <label class="text-gray-700 font-semibold">Jumlah:</label>
            <div class="flex items-center border border-gray-300 rounded-lg w-32">
              <button @click="quantity > 1 && quantity--" class="px-3 py-2 text-gray-600 hover:bg-gray-100">−</button>
              <input v-model.number="quantity" type="number" class="flex-1 text-center py-2 focus:outline-none" min="1" :max="product.stock">
              <button @click="quantity < product.stock && quantity++" class="px-3 py-2 text-gray-600 hover:bg-gray-100">+</button>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <button
              @click="addToCart"
              class="px-6 py-3 border-2 border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition"
            >
              🛒 Keranjang
            </button>
            <button
              @click="buyNow"
              class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
            >
              💳 Beli Sekarang
            </button>
          </div>
        </div>

        <!-- Shipping Info -->
        <div class="border-t pt-4">
          <h3 class="font-semibold text-gray-900 mb-3">Pengiriman</h3>
          <div class="space-y-2 text-sm text-gray-600">
            <p>📍 Dari: {{ product.seller?.city || 'Jakarta' }}</p>
            <p>⏱️ Estimasi: 1-3 hari kerja</p>
            <p>🚚 Gratis ongkir untuk pembelian minimal Rp 50.000</p>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="text-center py-12">
      <p class="text-gray-600 text-lg">Produk tidak ditemukan</p>
      <router-link to="/products" class="text-blue-600 hover:text-blue-800 mt-4 inline-block">
        Kembali ke daftar produk
      </router-link>
    </div>

    <!-- Related Products -->
    <div v-if="product" class="mt-12 border-t pt-12">
      <h2 class="text-3xl font-bold mb-8">Produk Terkait</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div v-for="relatedProduct in relatedProducts" :key="relatedProduct.id" class="bg-white rounded-lg shadow hover:shadow-lg transition cursor-pointer" @click="goToProduct(relatedProduct.id)">
          <div class="h-48 bg-gray-200 rounded-t flex items-center justify-center">
            <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
            </svg>
          </div>
          <div class="p-4">
            <h3 class="font-semibold text-gray-900 truncate">{{ relatedProduct.name }}</h3>
            <p class="text-lg font-bold text-blue-600 mt-2">Rp {{ formatPrice(relatedProduct.price) }}</p>
            <button @click.stop="addToCart" class="w-full mt-3 px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-semibold">
              + Keranjang
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProductDetail',
  data() {
    return {
      product: null,
      relatedProducts: [],
      loading: true,
      quantity: 1,
    };
  },
  mounted() {
    this.fetchProduct();
  },
  methods: {
    fetchProduct() {
      const productId = this.$route.params.id;
      axios.get(`/api/products/${productId}`)
        .then(response => {
          this.product = response.data.data;
          this.fetchRelatedProducts();
          this.loading = false;
        })
        .catch(error => {
          console.error('Error fetching product:', error);
          this.loading = false;
        });
    },
    fetchRelatedProducts() {
      axios.get(`/api/products?category_id=${this.product.category_id}&limit=4`)
        .then(response => {
          this.relatedProducts = response.data.data.filter(p => p.id !== this.product.id).slice(0, 4);
        })
        .catch(error => {
          console.error('Error fetching related products:', error);
        });
    },
    addToCart() {
      alert(`${this.quantity} x ${this.product.name} ditambahkan ke keranjang`);
    },
    buyNow() {
      alert('Fungsi beli sekarang akan membawa Anda ke checkout');
    },
    goToProduct(productId) {
      this.$router.push(`/products/${productId}`);
    },
    formatPrice(price) {
      return new Intl.NumberFormat('id-ID').format(price);
    },
  },
};
</script>

<style scoped>
/* ProductDetail specific styles */
</style>
