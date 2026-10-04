<template>
  <div class="space-y-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-4xl font-bold text-gray-900">Kelola Kategori</h1>
        <p class="text-gray-600 mt-2">Tambah, edit, dan hapus kategori produk</p>
      </div>
      <button
        @click="openAddModal"
        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
      >
        + Tambah Kategori
      </button>
    </div>

    <!-- Search & Filter -->
    <div class="flex gap-4">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Cari kategori..."
        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
      <select
        v-model="sortBy"
        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
        <option value="newest">Terbaru</option>
        <option value="oldest">Tertua</option>
        <option value="name-asc">Nama A-Z</option>
        <option value="name-desc">Nama Z-A</option>
      </select>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <table class="w-full">
        <thead class="bg-gray-50 border-b">
          <tr>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Nama Kategori</th>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Deskripsi</th>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Jumlah Produk</th>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Dibuat</th>
            <th class="text-center py-4 px-6 font-semibold text-gray-900">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in filteredCategories" :key="category.id" class="border-b hover:bg-gray-50 transition">
            <td class="py-4 px-6 text-gray-900 font-semibold">{{ category.name }}</td>
            <td class="py-4 px-6 text-gray-600">{{ category.description }}</td>
            <td class="py-4 px-6">
              <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                {{ category.products_count }} produk
              </span>
            </td>
            <td class="py-4 px-6 text-gray-600">{{ formatDate(category.created_at) }}</td>
            <td class="py-4 px-6 text-center">
              <button
                @click="editCategory(category)"
                class="text-blue-600 hover:text-blue-800 font-semibold text-sm mr-3"
              >
                Edit
              </button>
              <button
                @click="deleteCategory(category.id)"
                class="text-red-600 hover:text-red-800 font-semibold text-sm"
              >
                Hapus
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="filteredCategories.length === 0" class="text-center py-12">
        <p class="text-gray-600">Tidak ada kategori ditemukan</p>
      </div>
    </div>

    <!-- Add/Edit Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
          {{ editingCategory ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
        </h2>

        <form @submit.prevent="saveCategory" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
            <input
              v-model="formData.name"
              type="text"
              placeholder="Masukkan nama kategori"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea
              v-model="formData.description"
              placeholder="Masukkan deskripsi kategori"
              rows="4"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            ></textarea>
          </div>

          <div class="flex gap-4 pt-4">
            <button
              type="submit"
              class="flex-1 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
            >
              {{ editingCategory ? 'Perbarui' : 'Tambah' }}
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
  name: 'AdminCategories',
  data() {
    return {
      categories: [
        { id: 1, name: 'Elektronik', description: 'Produk elektronik terlengkap', products_count: 345, created_at: '2026-09-15' },
        { id: 2, name: 'Fashion', description: 'Pakaian dan aksesoris', products_count: 567, created_at: '2026-09-10' },
        { id: 3, name: 'Makanan', description: 'Makanan dan minuman', products_count: 234, created_at: '2026-09-05' },
        { id: 4, name: 'Buku', description: 'Buku dan literatur', products_count: 123, created_at: '2026-09-01' },
      ],
      showModal: false,
      editingCategory: null,
      formData: {
        name: '',
        description: '',
      },
      searchQuery: '',
      sortBy: 'newest',
    };
  },
  computed: {
    filteredCategories() {
      let filtered = this.categories;

      if (this.searchQuery) {
        filtered = filtered.filter(c =>
          c.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          c.description.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      }

      if (this.sortBy === 'newest') {
        filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
      } else if (this.sortBy === 'oldest') {
        filtered.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
      } else if (this.sortBy === 'name-asc') {
        filtered.sort((a, b) => a.name.localeCompare(b.name));
      } else if (this.sortBy === 'name-desc') {
        filtered.sort((a, b) => b.name.localeCompare(a.name));
      }

      return filtered;
    },
  },
  methods: {
    openAddModal() {
      this.editingCategory = null;
      this.formData = { name: '', description: '' };
      this.showModal = true;
    },
    editCategory(category) {
      this.editingCategory = category;
      this.formData = { name: category.name, description: category.description };
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.editingCategory = null;
      this.formData = { name: '', description: '' };
    },
    saveCategory() {
      if (this.editingCategory) {
        // Update existing
        const index = this.categories.findIndex(c => c.id === this.editingCategory.id);
        if (index > -1) {
          this.categories[index] = {
            ...this.categories[index],
            ...this.formData,
          };
        }
        alert('Kategori berhasil diperbarui');
      } else {
        // Add new
        this.categories.push({
          id: Math.max(...this.categories.map(c => c.id), 0) + 1,
          ...this.formData,
          products_count: 0,
          created_at: new Date().toISOString().split('T')[0],
        });
        alert('Kategori berhasil ditambahkan');
      }
      this.closeModal();
    },
    deleteCategory(categoryId) {
      if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
        const index = this.categories.findIndex(c => c.id === categoryId);
        if (index > -1) {
          this.categories.splice(index, 1);
          alert('Kategori berhasil dihapus');
        }
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
      });
    },
  },
};
</script>

<style scoped>
/* Admin Categories specific styles */
</style>
