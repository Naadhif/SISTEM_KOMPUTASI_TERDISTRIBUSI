<template>
  <div class="space-y-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-4xl font-bold text-gray-900">Seller Dashboard</h1>
        <p class="text-gray-600 mt-2">Kelola toko dan produk Anda</p>
      </div>
      <div class="text-right">
        <p class="text-sm text-gray-600">Selamat datang,</p>
        <p class="text-2xl font-bold text-gray-900">{{ sellerName }}</p>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm">Total Penjualan</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ formatPrice(totalSales) }}</p>
            <p class="text-green-600 text-sm mt-2">↑ 8% dari minggu lalu</p>
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
            <p class="text-gray-600 text-sm">Pesanan Hari Ini</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ ordersToday }}</p>
            <p class="text-green-600 text-sm mt-2">↑ 3 pesanan</p>
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
            <p class="text-gray-600 text-sm">Produk Aktif</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ activeProducts }}</p>
            <p class="text-orange-600 text-sm mt-2">2 produk habis stok</p>
          </div>
          <div class="w-16 h-16 bg-orange-100 rounded-lg flex items-center justify-center">
            <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM15 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM15 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-600 text-sm">Rating Toko</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ shopRating }}</p>
            <p class="text-yellow-600 text-sm mt-2">Berdasarkan {{ ratingCount }} ulasan</p>
          </div>
          <div class="w-16 h-16 bg-yellow-100 rounded-lg flex items-center justify-center">
            <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <router-link to="/seller/products" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Produk Saya</h3>
          <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path>
          </svg>
        </div>
        <p class="text-gray-600 text-sm">{{ activeProducts }} produk aktif</p>
        <p class="text-blue-600 text-sm font-semibold mt-3">Kelola →</p>
      </router-link>

      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Pesanan</h3>
          <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path>
          </svg>
        </div>
        <p class="text-gray-600 text-sm">{{ totalOrders }} pesanan bulan ini</p>
        <p class="text-green-600 text-sm font-semibold mt-3">Lihat Detail →</p>
      </div>

      <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition cursor-pointer">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Pengaturan Toko</h3>
          <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.533 1.533 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.533 1.533 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
          </svg>
        </div>
        <p class="text-gray-600 text-sm">Kelola profil dan pengaturan toko</p>
        <p class="text-purple-600 text-sm font-semibold mt-3">Buka →</p>
      </div>
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
              <th class="text-left py-3 px-4 font-semibold text-gray-900">Jumlah</th>
              <th class="text-left py-3 px-4 font-semibold text-gray-900">Total</th>
              <th class="text-left py-3 px-4 font-semibold text-gray-900">Status</th>
              <th class="text-left py-3 px-4 font-semibold text-gray-900">Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in recentOrders" :key="order.id" class="border-b hover:bg-gray-50">
              <td class="py-3 px-4 text-gray-900 font-semibold">#{{ order.id }}</td>
              <td class="py-3 px-4 text-gray-700">{{ order.buyer }}</td>
              <td class="py-3 px-4 text-gray-700">{{ order.items }} item</td>
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

    <!-- Low Stock Warning -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
      <h2 class="text-xl font-bold text-yellow-900 mb-4">⚠️ Produk Stok Rendah</h2>
      <div class="space-y-3">
        <div v-for="product in lowStockProducts" :key="product.id" class="flex justify-between items-center p-3 bg-white rounded">
          <div>
            <p class="font-semibold text-gray-900">{{ product.name }}</p>
            <p class="text-sm text-gray-600">Stok tersisa: {{ product.stock }} item</p>
          </div>
          <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm font-semibold">
            Restock
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SellerDashboard',
  data() {
    return {
      sellerName: 'Seller One',
      totalSales: 45250000,
      ordersToday: 12,
      activeProducts: 28,
      shopRating: 4.8,
      ratingCount: 342,
      totalOrders: 156,
      recentOrders: [
        { id: 2001, buyer: 'John Doe', items: 2, total: 299998, status: 'completed', date: '2026-09-27' },
        { id: 2002, buyer: 'Jane Smith', items: 1, total: 999990, status: 'processing', date: '2026-09-27' },
        { id: 2003, buyer: 'Bob Johnson', items: 3, total: 245000, status: 'pending', date: '2026-09-26' },
        { id: 2004, buyer: 'Alice Brown', items: 1, total: 189999, status: 'completed', date: '2026-09-26' },
      ],
      lowStockProducts: [
        { id: 1, name: 'Wireless Mouse Pro', stock: 5 },
        { id: 2, name: 'USB-C Cable', stock: 8 },
        { id: 3, name: 'Laptop Stand', stock: 3 },
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
/* Seller Dashboard specific styles */
</style>
