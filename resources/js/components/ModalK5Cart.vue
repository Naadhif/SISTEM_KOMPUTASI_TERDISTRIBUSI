<template>
  <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[80vh] overflow-hidden shadow-2xl flex flex-col">
      <!-- Header Modal -->
      <div class="bg-pink-500 text-white p-4 flex justify-between items-center">
        <h2 class="font-bold text-lg flex items-center gap-2">🛒 Shopping Cart (Kelompok 5)</h2>
        <button @click="$emit('close')" class="hover:bg-pink-600 w-8 h-8 rounded-full flex items-center justify-center transition">✕</button>
      </div>
      
      <!-- Body Modal -->
      <div class="p-6 overflow-y-auto flex-1">
        <div v-if="loading" class="text-center py-12 text-gray-500 animate-pulse">Memuat data keranjang...</div>
        <div v-else-if="error" class="bg-red-50 border border-red-200 p-4 rounded-xl text-red-700 text-sm">{{ error }}</div>
        <div v-else-if="cart.length === 0" class="text-center py-12 text-gray-400">Keranjang belanja kosong.</div>
        <div v-else class="space-y-3">
          <div v-for="item in cart" :key="item.id" class="border border-gray-100 bg-gray-50 p-4 rounded-xl flex justify-between items-center">
            <div>
              <h3 class="font-bold text-gray-800">{{ item.nama || item.name }}</h3>
              <p class="text-xs text-gray-500 mt-1">Harga satuan: {{ item.harga || item.price }}</p>
            </div>
            <span class="font-medium text-pink-600 text-xs bg-pink-100 px-3 py-1 rounded-full">
              Qty: {{ item.kuantitas || item.quantity }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({ cart: Array, loading: Boolean, error: String })
defineEmits(['close'])
</script>