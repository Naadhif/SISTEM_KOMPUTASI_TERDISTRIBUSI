<template>
  <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[80vh] overflow-hidden shadow-2xl flex flex-col">
      <!-- Header Modal -->
      <div class="bg-orange-500 text-white p-4 flex justify-between items-center">
        <h2 class="font-bold text-lg flex items-center gap-2">🍽️ Food Menus (Kelompok 4)</h2>
        <button @click="$emit('close')" class="hover:bg-orange-600 w-8 h-8 rounded-full flex items-center justify-center transition">✕</button>
      </div>
      
      <!-- Body Modal -->
      <div class="p-6 overflow-y-auto flex-1">
        <div v-if="loading" class="text-center py-12 text-gray-500 animate-pulse">Memuat menu makanan...</div>
        <div v-else-if="error" class="bg-red-50 border border-red-200 p-4 rounded-xl text-red-700 text-sm">{{ error }}</div>
        <div v-else-if="menus.length === 0" class="text-center py-12 text-gray-400">Tidak ada data menu tersedia.</div>
        <div v-else class="space-y-3">
          <div v-for="menu in menus" :key="menu.id" class="border border-gray-100 bg-gray-50 p-4 rounded-xl flex justify-between items-center hover:bg-orange-50/50 transition">
            <div>
              <h3 class="font-bold text-gray-800">{{ menu.name || menu.nama }}</h3>
              <p class="text-xs text-gray-500 mt-1">{{ menu.description || menu.deskripsi || 'Tidak ada deskripsi' }}</p>
            </div>
            <span class="font-semibold text-orange-600 text-sm bg-orange-100 px-3 py-1 rounded-full">
              {{ menu.price || menu.harga }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({ menus: Array, loading: Boolean, error: String })
defineEmits(['close'])
</script>