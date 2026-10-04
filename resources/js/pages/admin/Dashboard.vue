<template>
  <div class="space-y-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-4xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600 mt-2">Kelola STORETA E-Commerce platform</p>
      </div>
      <div class="text-right">
        <p class="text-sm text-gray-600">Selamat datang kembali,</p>
        <p class="text-2xl font-bold text-gray-900">{{ adminName }}</p>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm">Total Penjualan</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ formatPrice(totalSales) }}</p>
            <p class="text-green-600 text-sm mt-2">↑ 12% dari bulan lalu</p>
          </div>
          <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M8.16 2.75a.75.75 0 00-1.32 0l-1.43 4.4H.75a.75.75 0 00-.44 1.36l3.57 2.6-1.37 4.38a.75.75 0 001.15.85l3.59-2.63 3.59 2.63a.75.75 0 001.15-.85l-1.37-4.38 3.57-2.6a.75.75 0 00-.44-1.36h-4.66l-1.43-4.4z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm">Total Pesanan</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ totalOrders }}</p>
            <p class="text-green-600 text-sm mt-2">↑ 8% dari bulan lalu</p>
          </div>
          <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path>
              <path d="M16 16a2 2 0 11-4 0 2 2 0 014 0z"></path>
              <path d="M6 18a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm">Total Pengguna</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ totalUsers }}</p>
            <p class="text-green-600 text-sm mt-2">↑ 15% dari bulan lalu</p>
          </div>
          <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center">
            <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0zM13 6a1 1 0 100 2h4a1 1 0 100-2h-4zM13 9a1 1 0 011 1v2a1 1 0 11-2 0v-2a1 1 0 011-1zM15 12a1 1 0 100 2h2a1 1 0 100-2h-2z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm">Total Produk</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ totalProducts }}</p>
            <p class="text-orange-600 text-sm mt-2">↓ 2% dari bulan lalu</p>
          </div>
          <div class="w-16 h-16 bg-orange-100 rounded-lg flex items-center justify-center">
            <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM15 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM15 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <router-link to="/admin/categories" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Kelola Kategori</h3>
          <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM15 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM15 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z"></path>
          </svg>
        </div>
        <p class="text-gray-600 text-sm">{{ categoriesCount }} kategori aktif</p>
        <p class="text-blue-600 text-sm font-semibold mt-3">Buka →</p>
      </router-link>

      <router-link to="/admin/products" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Kelola Produk</h3>
          <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path>
          </svg>
        </div>
        <p class="text-gray-600 text-sm">{{ productsCount }} produk</p>
        <p class="text-green-600 text-sm font-semibold mt-3">Buka →</p>
      </router-link>

      <router-link to="/admin/users" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Kelola Pengguna</h3>
          <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0z"></path>
          </svg>
        </div>
        <p class="text-gray-600 text-sm">{{ usersCount }} pengguna</p>
        <p class="text-purple-600 text-sm font-semibold mt-3">Buka →</p>
      </router-link>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Pesanan Terbaru</h2>
        <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Lihat Semua</a>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b">
              <th class="text-left py-3 px-4 font-semibold text-gray-900">Order ID</th>
              <th class="text-left py-3 px-4 font-semibold text-gray-900">Pembeli</th>
              <th class="text-left py-3 px-4 font-semibold text-gray-900">Total</th>
              <th class="text-left py-3 px-4 font-semibold text-gray-900">Status</th>
              <th class="text-left py-3 px-4 font-semibold text-gray-900">Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in recentOrders" :key="order.id" class="border-b hover:bg-gray-50">
              <td class="py-3 px-4 text-gray-900 font-semibold">#{{ order.id }}</td>
              <td class="py-3 px-4 text-gray-700">{{ order.buyer }}</td>
              <td class="py-3 px-4 text-gray-900 font-semibold">Rp {{ formatPrice(order.total) }}</td>
              <td class="py-3 px-4">
                <span :class="[
                  'px-3 py-1 rounded-full text-xs font-semibold',
                  order.status === 'completed' ? 'bg-green-100 text-green-800' :
                  order.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                  'bg-blue-100 text-blue-800'
                ]">
                  {{ order.status === 'completed' ? 'Selesai' : order.status === 'pending' ? 'Menunggu' : 'Diproses' }}
                </span>
              </td>
              <td class="py-3 px-4 text-gray-600">{{ order.date }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Penjualan Harian</h2>
        <div class="h-64 flex items-end justify-center gap-2">
          <div v-for="i in 7" :key="i" class="flex-1 flex flex-col items-center">
            <div class="w-full bg-blue-500 rounded-t" :style="{ height: Math.random() * 200 + 'px' }"></div>
            <p class="text-xs text-gray-600 mt-2">{{ ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'][i-1] }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Kategori Terpopuler</h2>
        <div class="space-y-4">
          <div v-for="category in topCategories" :key="category.name" class="flex items-center justify-between">
            <p class="text-gray-700">{{ category.name }}</p>
            <div class="flex items-center gap-3">
              <div class="w-32 h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-blue-500 rounded-full" :style="{ width: category.percentage + '%' }"></div>
              </div>
              <p class="text-gray-700 font-semibold w-12 text-right">{{ category.percentage }}%</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminDashboard',
  data() {
    return {
      adminName: 'Admin User',
      totalSales: 125750000,
      totalOrders: 342,
      totalUsers: 1240,
      totalProducts: 2850,
      categoriesCount: 12,
      productsCount: 2850,
      usersCount: 1240,
      recentOrders: [
        { id: 1001, buyer: 'John Doe', total: 299998, status: 'completed', date: '2026-09-27' },
        { id: 1002, buyer: 'Jane Smith', total: 1499990, status: 'processing', date: '2026-09-27' },
        { id: 1003, buyer: 'Bob Johnson', total: 75000, status: 'pending', date: '2026-09-26' },
        { id: 1004, buyer: 'Alice Brown', total: 250000, status: 'completed', date: '2026-09-26' },
        { id: 1005, buyer: 'Charlie Wilson', total: 149999, status: 'processing', date: '2026-09-25' },
      ],
      topCategories: [
        { name: 'Elektronik', percentage: 35 },
        { name: 'Fashion', percentage: 25 },
        { name: 'Makanan', percentage: 20 },
        { name: 'Buku', percentage: 15 },
        { name: 'Lainnya', percentage: 5 },
      ],
    };
  },
  methods: {
    formatPrice(price) {
      return new Intl.NumberFormat('id-ID').format(price);
    },
  },
};
</script>

<style scoped>
/* Admin Dashboard specific styles */
</style>
