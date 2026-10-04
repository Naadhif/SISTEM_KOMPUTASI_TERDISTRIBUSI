<template>
  <button @click="$emit('click')" :disabled="loading" class="p-6 border rounded-xl shadow-sm hover:shadow-md transition bg-white text-left flex flex-col justify-between group cursor-pointer border-gray-200">
    <div>
      <div class="text-4xl mb-3 group-hover:scale-110 transition transform inline-block">{{ icon }}</div>
      <h3 class="font-bold text-lg text-gray-800">{{ title }}</h3>
    </div>
    <div v-if="loading" class="mt-4 text-xs font-semibold text-blue-600 animate-pulse flex items-center gap-1">
      <span>Memuat data...</span>
    </div>
  </button>
</template>

<script setup>
defineProps({ icon: String, title: String, loading: Boolean })
defineEmits(['click'])
</script>