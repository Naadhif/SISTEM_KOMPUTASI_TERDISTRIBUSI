<template>
  <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-12">
    <div class="max-w-6xl mx-auto px-4">
      <h1 class="text-4xl font-bold text-center mb-12 text-gray-800">🔗 Integration Hub</h1>
      
      <!-- Grid Tombol Integrasi 6 Kelompok -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <IntegrationButton icon="🎓" title="K1: Login" @click="redirectToK1" />
        <IntegrationButton icon="📱" title="K2: Login" @click="redirectToK2" />
        <IntegrationButton icon="🍽️" title="K4: Menus" @click="showK4Modal" :loading="k4Loading" />
        <IntegrationButton icon="🛒" title="K5: Cart" @click="showK5Modal" :loading="k5Loading" />
        <IntegrationButton icon="🩺" title="K6: Gejala" @click="showK6Modal" :loading="k6Loading" />
        <IntegrationButton icon="📝" title="K7: Register" @click="redirectToK7" />
      </div>
    </div>

    <!-- Komponen Modal untuk K4, K5, dan K6 -->
    <ModalK4Menus v-if="showK4ModalFlag" :menus="k4Menus" :loading="k4Loading" :error="k4Error" @close="showK4ModalFlag = false" />
    <ModalK5Cart v-if="showK5ModalFlag" :cart="k5Cart" :loading="k5Loading" :error="k5Error" @close="showK5ModalFlag = false" />
    <ModalK6Gejala v-if="showK6ModalFlag" :gejala="k6Gejala" :loading="k6Loading" :error="k6Error" @close="showK6ModalFlag = false" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import IntegrationButton from '../components/IntegrationButton.vue'
import ModalK4Menus from '../components/ModalK4Menus.vue'
import ModalK5Cart from '../components/ModalK5Cart.vue'
import ModalK6Gejala from '../components/ModalK6Gejala.vue'
import integrationService from '../services/integrationService'

// State untuk mengatur visibilitas modal
const showK4ModalFlag = ref(false)
const showK5ModalFlag = ref(false)
const showK6ModalFlag = ref(false)

// State status loading
const k4Loading = ref(false)
const k5Loading = ref(false)
const k6Loading = ref(false)

// State penampung data API
const k4Menus = ref([])
const k5Cart = ref([])
const k6Gejala = ref([])

// State penampung pesan error
const k4Error = ref(null)
const k5Error = ref(null)
const k6Error = ref(null)

// Fungsi untuk Redirect ke halaman login/register kelompok lain di tab baru
const redirectToK1 = () => {
  const url = integrationService.getLoginUrls().k1
  if (url) window.open(url, '_blank')
  else alert('URL K1 belum dikonfigurasi di file .env')
}

const redirectToK2 = () => {
  const url = integrationService.getLoginUrls().k2
  if (url) window.open(url, '_blank')
  else alert('URL K2 belum dikonfigurasi di file .env')
}

const redirectToK7 = () => {
  const url = integrationService.getLoginUrls().k7
  if (url) window.open(url, '_blank')
  else alert('URL K7 belum dikonfigurasi di file .env')
}

// Fungsi untuk mengambil data dan menampilkan Modal K4 (Menus)
const showK4Modal = async () => {
  showK4ModalFlag.value = true
  k4Loading.value = true
  k4Error.value = null
  
  const result = await integrationService.getK4Menus()
  if (result.success) {
    k4Menus.value = result.data.data || result.data
  } else {
    k4Error.value = result.message
  }
  k4Loading.value = false
}

// Fungsi untuk mengambil data dan menampilkan Modal K5 (Cart)
const showK5Modal = async () => {
  showK5ModalFlag.value = true
  k5Loading.value = true
  k5Error.value = null
  
  const result = await integrationService.getK5Cart()
  if (result.success) {
    k5Cart.value = result.data.data || result.data
  } else {
    k5Error.value = result.message
  }
  k5Loading.value = false
}

// Fungsi untuk mengambil data dan menampilkan Modal K6 (Gejala)
const showK6Modal = async () => {
  showK6ModalFlag.value = true
  k6Loading.value = true
  k6Error.value = null
  
  const result = await integrationService.getK6Gejala()
  if (result.success) {
    k6Gejala.value = result.data.data || result.data
  } else {
    k6Error.value = result.message
  }
  k6Loading.value = false
}
</script>