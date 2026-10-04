<template>
  <div class="space-y-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-4xl font-bold text-gray-900">Kelola Pengguna</h1>
        <p class="text-gray-600 mt-2">Kelola akun pengguna dan seller</p>
      </div>
      <button
        @click="openAddModal"
        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
      >
        + Tambah Pengguna
      </button>
    </div>

    <!-- Search & Filter -->
    <div class="flex gap-4">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Cari pengguna..."
        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
      <select
        v-model="filterRole"
        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
        <option value="">Semua Role</option>
        <option value="admin">Admin</option>
        <option value="seller">Seller</option>
        <option value="user">User</option>
      </select>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <table class="w-full">
        <thead class="bg-gray-50 border-b">
          <tr>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Nama</th>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Email</th>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Role</th>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Status</th>
            <th class="text-left py-4 px-6 font-semibold text-gray-900">Terdaftar</th>
            <th class="text-center py-4 px-6 font-semibold text-gray-900">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in filteredUsers" :key="user.id" class="border-b hover:bg-gray-50 transition">
            <td class="py-4 px-6 text-gray-900 font-semibold">{{ user.name }}</td>
            <td class="py-4 px-6 text-gray-600">{{ user.email }}</td>
            <td class="py-4 px-6">
              <span :class="[
                'px-3 py-1 rounded-full text-xs font-semibold',
                user.role === 'admin' ? 'bg-red-100 text-red-800' :
                user.role === 'seller' ? 'bg-blue-100 text-blue-800' :
                'bg-gray-100 text-gray-800'
              ]">
                {{ user.role === 'admin' ? 'Admin' : user.role === 'seller' ? 'Seller' : 'User' }}
              </span>
            </td>
            <td class="py-4 px-6">
              <span :class="[
                'px-3 py-1 rounded-full text-xs font-semibold',
                user.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
              ]">
                {{ user.status === 'active' ? 'Aktif' : 'Nonaktif' }}
              </span>
            </td>
            <td class="py-4 px-6 text-gray-600">{{ formatDate(user.created_at) }}</td>
            <td class="py-4 px-6 text-center">
              <button
                @click="editUser(user)"
                class="text-blue-600 hover:text-blue-800 font-semibold text-sm mr-3"
              >
                Edit
              </button>
              <button
                @click="toggleUserStatus(user.id)"
                :class="user.status === 'active' ? 'text-red-600 hover:text-red-800' : 'text-green-600 hover:text-green-800'"
                class="font-semibold text-sm mr-3"
              >
                {{ user.status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
              </button>
              <button
                @click="deleteUser(user.id)"
                class="text-red-600 hover:text-red-800 font-semibold text-sm"
              >
                Hapus
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="filteredUsers.length === 0" class="text-center py-12">
        <p class="text-gray-600">Tidak ada pengguna ditemukan</p>
      </div>
    </div>

    <!-- Add/Edit Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
          {{ editingUser ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}
        </h2>

        <form @submit.prevent="saveUser" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
            <input
              v-model="formData.name"
              type="text"
              placeholder="Masukkan nama"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input
              v-model="formData.email"
              type="email"
              placeholder="Masukkan email"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
            <select
              v-model="formData.role"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            >
              <option value="user">User</option>
              <option value="seller">Seller</option>
              <option value="admin">Admin</option>
            </select>
          </div>

          <div v-if="!editingUser">
            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input
              v-model="formData.password"
              type="password"
              placeholder="Masukkan password"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            >
          </div>

          <div class="flex gap-4 pt-4">
            <button
              type="submit"
              class="flex-1 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
            >
              {{ editingUser ? 'Perbarui' : 'Tambah' }}
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
  name: 'AdminUsers',
  data() {
    return {
      users: [
        { id: 1, name: 'Admin User', email: 'admin@storeta.com', role: 'admin', status: 'active', created_at: '2026-09-01' },
        { id: 2, name: 'Seller One', email: 'seller1@storeta.com', role: 'seller', status: 'active', created_at: '2026-09-05' },
        { id: 3, name: 'Seller Two', email: 'seller2@storeta.com', role: 'seller', status: 'active', created_at: '2026-09-10' },
        { id: 4, name: 'Regular User', email: 'user@storeta.com', role: 'user', status: 'active', created_at: '2026-09-15' },
        { id: 5, name: 'Buyer One', email: 'buyer1@storeta.com', role: 'user', status: 'inactive', created_at: '2026-09-20' },
      ],
      showModal: false,
      editingUser: null,
      formData: {
        name: '',
        email: '',
        role: 'user',
        password: '',
      },
      searchQuery: '',
      filterRole: '',
    };
  },
  computed: {
    filteredUsers() {
      let filtered = this.users;

      if (this.searchQuery) {
        filtered = filtered.filter(u =>
          u.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          u.email.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      }

      if (this.filterRole) {
        filtered = filtered.filter(u => u.role === this.filterRole);
      }

      return filtered;
    },
  },
  methods: {
    openAddModal() {
      this.editingUser = null;
      this.formData = { name: '', email: '', role: 'user', password: '' };
      this.showModal = true;
    },
    editUser(user) {
      this.editingUser = user;
      this.formData = { name: user.name, email: user.email, role: user.role, password: '' };
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.editingUser = null;
      this.formData = { name: '', email: '', role: 'user', password: '' };
    },
    saveUser() {
      if (this.editingUser) {
        const index = this.users.findIndex(u => u.id === this.editingUser.id);
        if (index > -1) {
          this.users[index] = {
            ...this.users[index],
            name: this.formData.name,
            email: this.formData.email,
            role: this.formData.role,
          };
        }
        alert('Pengguna berhasil diperbarui');
      } else {
        this.users.push({
          id: Math.max(...this.users.map(u => u.id), 0) + 1,
          name: this.formData.name,
          email: this.formData.email,
          role: this.formData.role,
          status: 'active',
          created_at: new Date().toISOString().split('T')[0],
        });
        alert('Pengguna berhasil ditambahkan');
      }
      this.closeModal();
    },
    toggleUserStatus(userId) {
      const user = this.users.find(u => u.id === userId);
      if (user) {
        user.status = user.status === 'active' ? 'inactive' : 'active';
        alert(`Pengguna ${user.status === 'active' ? 'diaktifkan' : 'dinonaktifkan'}`);
      }
    },
    deleteUser(userId) {
      if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
        const index = this.users.findIndex(u => u.id === userId);
        if (index > -1) {
          this.users.splice(index, 1);
          alert('Pengguna berhasil dihapus');
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
/* Admin Users specific styles */
</style>
