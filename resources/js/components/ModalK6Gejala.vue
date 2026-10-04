<template>
  <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[80vh] overflow-hidden shadow-2xl flex flex-col">
      <!-- Header Modal -->
      <div class="bg-purple-600 text-white p-4 flex justify-between items-center">
        <h2 class="font-bold text-lg flex items-center gap-2">🩺 Symptoms / Gejala (Kelompok 6)</h2>
        <button @click="$emit('close')" class="hover:bg-purple-700 w-8 h-8 rounded-full flex items-center justify-center transition">✕</button>
      </div>
      
      <!-- Body Modal -->
      <div class="p-6 overflow-y-auto flex-1">
        <div v-if="loading" class="text-center py-12 text-gray-500 animate-pulse">Memuat data gejala...</div>
        <div v-else-if="error" class="bg-red-50 border border-red-200 p-4 rounded-xl text-red-700 text-sm">{{ error }}</div>
        <div v-else-if="gejala.length === 0" class="text-center py-12 text-gray-400">Tidak ada data gejala tersedia.</div>
        <div v-else class="space-y-3">
          <div v-for="item in gejala" :key="item.id" class="border-l-4 border-purple-500 bg-purple-50/50 border border-gray-100 p-4 rounded-r-xl">
            <h3 class="font-bold text-gray-800">{{ item.nama_gejala || item.name }}</h3>
            <p class="text-xs text-gray-600 mt-1">{{ item.deskripsi || 'Tidak ada keterangan tambahan.' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({ gejala: Array, loading: Boolean, error: String })
defineEmits(['close'])
</script>