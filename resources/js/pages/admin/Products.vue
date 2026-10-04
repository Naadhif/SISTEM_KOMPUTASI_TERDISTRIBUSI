<template>
  <div class="space-y-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-4xl font-bold text-gray-900">Kelola Produk</h1>
        <p class="text-gray-600 mt-2">Tambah, edit, dan hapus produk dari platform</p>
      </div>
      <button
        @click="openAddModal"
        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
      >
        + Tambah Produk
      </button>
    </div>

    <!-- Search & Filter -->
    <div class="flex gap-4">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Cari produk..."
        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
      <select
        v-model="filterCategory"
        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
        <option value="">Semua Kategori</option>
        <option value="1">Elektronik</option>
        <option value="2">Fashion</option>
        <option value="3">Makanan</option>
      </select>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <table class="w-full">
        <thead class="bg-gray-50 border-b">
          <tr>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Nama Produk</th>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Kategori</th>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Harga</th>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Stok</th>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Penjual</th>
            <th class="text-center py-4 px-6 font-semibold text-gray-900">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in filteredProducts" :key="product.id" class="border-b hover:bg-gray-50 transition">
            <td class="py-4 px-6 text-gray-900 font-semibold">{{ product.name }}</td>
            <td class="py-4 px-6 text-gray-600">{{ product.category }}</td>
            <td class="py-4 px-6 text-gray-900 font-semibold">Rp {{ formatPrice(product.price) }}</td>
            <td class="py-4 px-6">
              <span :class="[
                'px-3 py-1 rounded-full text-sm font-semibold',
                product.stock > 50 ? 'bg-green-100 text-green-800' :
                product.stock > 10 ? 'bg-yellow-100 text-yellow-800' :
                'bg-red-100 text-red-800'
              ]">
                {{ product.stock }}
              </span>
            </td>
            <td class="py-4 px-6 text-gray-600">{{ product.seller }}</td>
            <td class="py-4 px-6 text-center">
              <button
                @click="editProduct(product)"
                class="text-blue-600 hover:text-blue-800 font-semibold text-sm mr-3"
              >
                Edit
              </button>
              <button
                @click="deleteProduct(product.id)"
                class="text-red-600 hover:text-red-800 font-semibold text-sm"
              >
                Hapus
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="filteredProducts.length === 0" class="text-center py-12">
        <p class="text-gray-600">Tidak ada produk ditemukan</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminProducts',
  data() {
    return {
      products: [
        { id: 1, name: 'Laptop Gaming Pro', category: 'Elektronik', price: 15999999, stock: 25, seller: 'seller1@storeta.com' },
        { id: 2, name: 'Wireless Mouse', category: 'Elektronik', price: 299000, stock: 150, seller: 'seller1@storeta.com' },
        { id: 3, name: 'T-Shirt Premium', category: 'Fashion', price: 125000, stock: 80, seller: 'seller2@storeta.com' },
        { id: 4, name: 'Kopi Arabika', category: 'Makanan', price: 85000, stock: 5, seller: 'seller2@storeta.com' },
      ],
      showModal: false,
      editingProduct: null,
      searchQuery: '',
      filterCategory: '',
    };
  },
  computed: {
    filteredProducts() {
      let filtered = this.products;

      if (this.searchQuery) {
        filtered = filtered.filter(p =>
          p.name.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      }

      if (this.filterCategory) {
        filtered = filtered.filter(p => p.category === this.filterCategory);
      }

      return filtered;
    },
  },
  methods: {
    openAddModal() {
      this.editingProduct = null;
      this.showModal = true;
    },
    editProduct(product) {
      this.editingProduct = product;
      this.showModal = true;
    },
    deleteProduct(productId) {
      if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        const index = this.products.findIndex(p => p.id === productId);
        if (index > -1) {
          this.products.splice(index, 1);
          alert('Produk berhasil dihapus');
        }
      }
    },
    formatPrice(price) {
      return new Intl.NumberFormat('id-ID').format(price);
    },
  },
};
</script>

<style scoped>
/* Admin Products specific styles */
</style>
