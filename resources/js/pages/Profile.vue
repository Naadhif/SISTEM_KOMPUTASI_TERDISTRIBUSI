<template>
  <div class="space-y-8">
    <!-- Page Header -->
    <div>
      <h1 class="text-4xl font-bold text-gray-900">Profil Saya</h1>
      <p class="text-gray-600 mt-2">Kelola informasi akun dan preferensi Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
      <!-- Sidebar Navigation -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white text-center">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-12 h-12 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <h2 class="text-xl font-bold">{{ user.name }}</h2>
            <p class="text-blue-100 text-sm mt-1">{{ user.email }}</p>
            <span class="inline-block mt-3 px-3 py-1 bg-white bg-opacity-20 rounded-full text-xs font-semibold">
              {{ user.role === 'admin' ? 'Admin' : user.role === 'seller' ? 'Penjual' : 'Pembeli' }}
            </span>
          </div>

          <nav class="p-4 space-y-2">
            <button
              v-for="tab in tabs"
              :key="tab.id"
              @click="activeTab = tab.id"
              :class="[
                'w-full text-left px-4 py-3 rounded-lg transition',
                activeTab === tab.id
                  ? 'bg-blue-100 text-blue-600 font-semibold'
                  : 'text-gray-700 hover:bg-gray-100'
              ]"
            >
              {{ tab.label }}
            </button>
          </nav>
        </div>
      </div>

      <!-- Main Content -->
      <div class="lg:col-span-3">
        <!-- Profile Settings -->
        <div v-if="activeTab === 'profile'" class="bg-white rounded-lg shadow p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Profil</h2>

          <form @submit.prevent="updateProfile" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input
                  v-model="user.name"
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input
                  v-model="user.email"
                  type="email"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                <input
                  v-model="user.phone"
                  type="tel"
                  placeholder="+62xxx"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                <input
                  v-model="user.birth_date"
                  type="date"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
              <textarea
                v-model="user.address"
                rows="4"
                placeholder="Masukkan alamat lengkap"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              ></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kota</label>
                <input
                  v-model="user.city"
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                <input
                  v-model="user.province"
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
                <input
                  v-model="user.postal_code"
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>
            </div>

            <div class="flex gap-4 pt-4">
              <button
                type="submit"
                class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
              >
                Simpan Perubahan
              </button>
              <button
                type="button"
                @click="cancelEdit"
                class="px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition"
              >
                Batal
              </button>
            </div>
          </form>
        </div>

        <!-- Orders History -->
        <div v-if="activeTab === 'orders'" class="bg-white rounded-lg shadow p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Pesanan</h2>

          <div v-if="orders.length === 0" class="text-center py-8">
            <p class="text-gray-600">Belum ada pesanan</p>
          </div>

          <div v-else class="space-y-4">
            <div v-for="order in orders" :key="order.id" class="border rounded-lg p-4 hover:shadow-lg transition">
              <div class="flex justify-between items-start mb-3">
                <div>
                  <p class="font-semibold text-gray-900">Order #{{ order.id }}</p>
                  <p class="text-sm text-gray-600">{{ formatDate(order.created_at) }}</p>
                </div>
                <span :class="[
                  'px-3 py-1 rounded-full text-xs font-semibold',
                  order.status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'
                ]">
                  {{ order.status === 'completed' ? 'Selesai' : 'Diproses' }}
                </span>
              </div>
              <p class="text-lg font-bold text-blue-600">Rp {{ formatPrice(order.total_amount) }}</p>
              <button class="mt-3 text-blue-600 hover:text-blue-800 font-semibold text-sm">
                Lihat Detail
              </button>
            </div>
          </div>
        </div>

        <!-- Security Settings -->
        <div v-if="activeTab === 'security'" class="bg-white rounded-lg shadow p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Keamanan</h2>

          <div class="space-y-6">
            <!-- Change Password -->
            <div class="border-b pb-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Ubah Password</h3>
              <form @submit.prevent="changePassword" class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                  <input
                    v-model="passwordForm.old_password"
                    type="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  >
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                  <input
                    v-model="passwordForm.new_password"
                    type="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  >
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                  <input
                    v-model="passwordForm.password_confirmation"
                    type="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  >
                </div>

                <button
                  type="submit"
                  class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
                >
                  Ubah Password
                </button>
              </form>
            </div>

            <!-- Two Factor Authentication -->
            <div class="border-b pb-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Autentikasi Dua Faktor</h3>
              <p class="text-gray-600 mb-4">Tingkatkan keamanan akun Anda dengan autentikasi dua faktor</p>
              <button class="px-6 py-2 border border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition">
                Aktifkan 2FA
              </button>
            </div>

            <!-- Logout All Devices -->
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Keluar dari Semua Perangkat</h3>
              <p class="text-gray-600 mb-4">Keluar dari akun Anda di semua perangkat lain</p>
              <button class="px-6 py-2 border border-red-600 text-red-600 font-semibold rounded-lg hover:bg-red-50 transition">
                Keluar Semua Perangkat
              </button>
            </div>
          </div>
        </div>

        <!-- Preferences -->
        <div v-if="activeTab === 'preferences'" class="bg-white rounded-lg shadow p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Preferensi</h2>

          <div class="space-y-6">
            <!-- Notifications -->
            <div class="flex items-center justify-between p-4 border rounded-lg">
              <div>
                <p class="font-semibold text-gray-900">Email Notifikasi</p>
                <p class="text-sm text-gray-600">Terima notifikasi pesanan dan promosi</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input v-model="preferences.email_notifications" type="checkbox" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
              </label>
            </div>

            <!-- Marketing -->
            <div class="flex items-center justify-between p-4 border rounded-lg">
              <div>
                <p class="font-semibold text-gray-900">Penawaran Khusus</p>
                <p class="text-sm text-gray-600">Terima penawaran dan diskon eksklusif</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input v-model="preferences.marketing_emails" type="checkbox" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
              </label>
            </div>

            <button
              @click="savePreferences"
              class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
            >
              Simpan Preferensi
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Profile',
  data() {
    return {
      activeTab: 'profile',
      user: {
        name: 'John Doe',
        email: 'john@storeta.com',
        phone: '+62812345678',
        birth_date: '1990-01-15',
        address: 'Jl. Contoh No. 123',
        city: 'Jakarta',
        province: 'DKI Jakarta',
        postal_code: '12345',
        role: 'user',
      },
      passwordForm: {
        old_password: '',
        new_password: '',
        password_confirmation: '',
      },
      preferences: {
        email_notifications: true,
        marketing_emails: false,
      },
      orders: [
        {
          id: 1001,
          total_amount: 299998,
          status: 'completed',
          created_at: '2026-09-20',
        },
        {
          id: 1002,
          total_amount: 149999,
          status: 'processing',
          created_at: '2026-09-25',
        },
      ],
      tabs: [
        { id: 'profile', label: '👤 Profil' },
        { id: 'orders', label: '📦 Pesanan' },
        { id: 'security', label: '🔐 Keamanan' },
        { id: 'preferences', label: '⚙️ Preferensi' },
      ],
    };
  },
  methods: {
    updateProfile() {
      alert('Profil berhasil diperbarui');
    },
    cancelEdit() {
      // Reset form
    },
    changePassword() {
      if (this.passwordForm.new_password !== this.passwordForm.password_confirmation) {
        alert('Password tidak sesuai');
        return;
      }
      alert('Password berhasil diubah');
      this.passwordForm = {
        old_password: '',
        new_password: '',
        password_confirmation: '',
      };
    },
    savePreferences() {
      alert('Preferensi berhasil disimpan');
    },
    formatPrice(price) {
      return new Intl.NumberFormat('id-ID').format(price);
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
/* Profile specific styles */
</style>
