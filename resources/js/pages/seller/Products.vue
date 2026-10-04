<template>
  <div class="space-y-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-4xl font-bold text-gray-900">Produk Saya</h1>
        <p class="text-gray-600 mt-2">Kelola produk yang Anda jual di STORETA</p>
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
        placeholder="Cari produk Anda..."
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
      <select
        v-model="filterStatus"
        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
        <option value="">Semua Status</option>
        <option value="active">Aktif</option>
        <option value="inactive">Nonaktif</option>
        <option value="low-stock">Stok Rendah</option>
      </select>
    </div>

    <!-- Products Grid -->
    <div v-if="filteredProducts.length === 0" class="text-center py-12 bg-white rounded-lg shadow">
      <p class="text-gray-600 text-lg">Belum ada produk. Mulai dengan menambahkan produk pertama Anda!</p>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="product in filteredProducts" :key="product.id" class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
        <!-- Product Image -->
        <div class="h-48 bg-gray-200 flex items-center justify-center relative">
          <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
          </svg>
          <span :class="[
            'absolute top-2 right-2 px-3 py-1 rounded-full text-xs font-semibold text-white',
            product.status === 'active' ? 'bg-green-500' :
            product.status === 'inactive' ? 'bg-gray-500' :
            'bg-red-500'
          ]">
            {{ product.status === 'active' ? 'Aktif' : product.status === 'inactive' ? 'Nonaktif' : 'Stok Habis' }}
          </span>
        </div>

        <!-- Product Info -->
        <div class="p-4">
          <h3 class="font-semibold text-gray-900 truncate">{{ product.name }}</h3>
          <p class="text-sm text-gray-600 mt-1">{{ product.category }}</p>

          <div class="mt-4 flex justify-between items-center">
            <div>
              <p class="text-lg font-bold text-blue-600">Rp {{ formatPrice(product.price) }}</p>
              <p class="text-xs text-gray-500 mt-1">Stok: {{ product.stock }}</p>
            </div>
            <div class="text-right">
              <p class="text-xs text-gray-600">{{ product.sold }} terjual</p>
            </div>
          </div>

          <!-- Rating -->
          <div class="flex items-center mt-3">
            <div class="flex text-yellow-400 text-sm">
              <span v-for="i in 5" :key="i">★</span>
            </div>
            <span class="text-xs text-gray-600 ml-2">({{ product.reviews }} ulasan)</span>
          </div>

          <!-- Action Buttons -->
          <div class="mt-4 flex gap-2">
            <button
              @click="editProduct(product)"
              class="flex-1 px-3 py-2 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition font-semibold text-sm"
            >
              Edit
            </button>
            <button
              @click="toggleProduct(product.id)"
              :class="product.status === 'active' ? 'bg-red-100 text-red-600 hover:bg-red-200' : 'bg-green-100 text-green-600 hover:bg-green-200'"
              class="flex-1 px-3 py-2 rounded transition font-semibold text-sm"
            >
              {{ product.status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
            <button
              @click="deleteProduct(product.id)"
              class="flex-1 px-3 py-2 bg-red-100 text-red-600 rounded hover:bg-red-200 transition font-semibold text-sm"
            >
              Hapus
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Add/Edit Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl w-full max-h-96 overflow-y-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
          {{ editingProduct ? 'Edit Produk' : 'Tambah Produk Baru' }}
        </h2>

        <form @submit.prevent="saveProduct" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
              <input
                v-model="formData.name"
                type="text"
                placeholder="Masukkan nama produk"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
              <select
                v-model="formData.category_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              >
                <option value="">Pilih kategori</option>
                <option value="1">Elektronik</option>
                <option value="2">Fashion</option>
                <option value="3">Makanan</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea
              v-model="formData.description"
              placeholder="Masukkan deskripsi produk"
              rows="3"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            ></textarea>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
              <input
                v-model.number="formData.price"
                type="number"
                placeholder="0"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
              <input
                v-model.number="formData.stock"
                type="number"
                placeholder="0"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
              <select
                v-model="formData.status"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                <option value="active">Aktif</option>
                <option value="inactive">Nonaktif</option>
              </select>
            </div>
          </div>

          <div class="flex gap-4 pt-4">
            <button
              type="submit"
              class="flex-1 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
            >
              {{ editingProduct ? 'Perbarui' : 'Tambah' }}
            </button>
            <button
              type="button"
              @click="closeModal"
              class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition"
            >
              Batal
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SellerProducts',
  data() {
    return {
      products: [
        { id: 1, name: 'Wireless Mouse Pro', category: 'Elektronik', price: 299000, stock: 25, sold: 145, reviews: 38, status: 'active' },
        { id: 2, name: 'USB-C Cable', category: 'Elektronik', price: 79000, stock: 8, sold: 342, reviews: 92, status: 'active' },
        { id: 3, name: 'Laptop Stand', category: 'Elektronik', price: 189000, stock: 3, sold: 67, reviews: 18, status: 'active' },
        { id: 4, name: 'T-Shirt Premium', category: 'Fashion', price: 125000, stock: 0, sold: 234, reviews: 56, status: 'inactive' },
      ],
      showModal: false,
      editingProduct: null,
      formData: {
        name: '',
        category_id: '',
        description: '',
        price: 0,
        stock: 0,
        status: 'active',
      },
      searchQuery: '',
      filterCategory: '',
      filterStatus: '',
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

      if (this.filterStatus === 'low-stock') {
        filtered = filtered.filter(p => p.stock < 10 && p.stock > 0);
      } else if (this.filterStatus) {
        filtered = filtered.filter(p => p.status === this.filterStatus);
      }

      return filtered;
    },
  },
  methods: {
    openAddModal() {
      this.editingProduct = null;
      this.formData = { name: '', category_id: '', description: '', price: 0, stock: 0, status: 'active' };
      this.showModal = true;
    },
    editProduct(product) {
      this.editingProduct = product;
      this.formData = { ...product };
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.editingProduct = null;
      this.formData = { name: '', category_id: '', description: '', price: 0, stock: 0, status: 'active' };
    },
    saveProduct() {
      if (this.editingProduct) {
        const index = this.products.findIndex(p => p.id === this.editingProduct.id);
        if (index > -1) {
          this.products[index] = { ...this.products[index], ...this.formData };
        }
        alert('Produk berhasil diperbarui');
      } else {
        this.products.push({
          id: Math.max(...this.products.map(p => p.id), 0) + 1,
          ...this.formData,
          sold: 0,
          reviews: 0,
        });
        alert('Produk berhasil ditambahkan');
      }
      this.closeModal();
    },
    toggleProduct(productId) {
      const product = this.products.find(p => p.id === productId);
      if (product) {
        product.status = product.status === 'active' ? 'inactive' : 'active';
      }
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
/* Seller Products specific styles */
</style>
