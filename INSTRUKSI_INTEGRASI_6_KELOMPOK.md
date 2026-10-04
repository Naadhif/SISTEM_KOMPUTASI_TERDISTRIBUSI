# 📋 INTEGRASI 6 KELOMPOK - STORETA

**TUJUAN:** Buat halaman `/integrations` dengan 6 button terhubung ke API 6 kelompok lain.

## 🎯 ENDPOINT

| K | Endpoint | Aksi |
|---|----------|------|
| K1 | `/login` | Redirect |
| K2 | `/auth/login` | Redirect |
| K4 | `/customer/menus` | Modal data |
| K5 | `/keranjang.php` | Modal data |
| K6 | `/gejala` | Modal data |
| K7 | `/auth/register.php` | Redirect |

---

## ⚡ STEPS

### **STEP 1: Update `.env`**
```env
VITE_K1_LOGIN_URL=https://placeholder-k1.example.com/login
VITE_K2_LOGIN_URL=https://placeholder-k2.example.com/auth/login
VITE_K4_API_URL=https://placeholder-k4.example.com/api
VITE_K4_MENUS_ENDPOINT=/customer/menus
VITE_K5_API_URL=https://placeholder-k5.example.com
VITE_K5_CART_ENDPOINT=/keranjang.php
VITE_K6_API_URL=https://placeholder-k6.example.com/api
VITE_K6_GEJALA_ENDPOINT=/gejala
VITE_K7_LOGIN_URL=https://placeholder-k7.example.com/auth/register.php
```

### **STEP 2: `resources/js/services/integrationService.js`**
```javascript
import axios from 'axios'

const K1_LOGIN_URL = import.meta.env.VITE_K1_LOGIN_URL
const K2_LOGIN_URL = import.meta.env.VITE_K2_LOGIN_URL
const K4_API_URL = import.meta.env.VITE_K4_API_URL
const K4_MENUS_ENDPOINT = import.meta.env.VITE_K4_MENUS_ENDPOINT
const K5_API_URL = import.meta.env.VITE_K5_API_URL
const K5_CART_ENDPOINT = import.meta.env.VITE_K5_CART_ENDPOINT
const K6_API_URL = import.meta.env.VITE_K6_API_URL
const K6_GEJALA_ENDPOINT = import.meta.env.VITE_K6_GEJALA_ENDPOINT
const K7_LOGIN_URL = import.meta.env.VITE_K7_LOGIN_URL

export const integrationService = {
  async getK4Menus() {
    try {
      const response = await axios.get(`${K4_API_URL}${K4_MENUS_ENDPOINT}`)
      return { success: true, data: response.data }
    } catch (error) {
      return { success: false, message: error.message }
    }
  },

  async getK5Cart() {
    try {
      const response = await axios.get(`${K5_API_URL}${K5_CART_ENDPOINT}`)
      return { success: true, data: response.data }
    } catch (error) {
      return { success: false, message: error.message }
    }
  },

  async getK6Gejala() {
    try {
      const response = await axios.get(`${K6_API_URL}${K6_GEJALA_ENDPOINT}`)
      return { success: true, data: response.data }
    } catch (error) {
      return { success: false, message: error.message }
    }
  },

  getLoginUrls() {
    return { k1: K1_LOGIN_URL, k2: K2_LOGIN_URL, k7: K7_LOGIN_URL }
  }
}

export default integrationService
```

### **STEP 3: `resources/js/pages/Integrations.vue`**
```vue
<template>
  <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-12">
    <div class="max-w-6xl mx-auto px-4">
      <h1 class="text-4xl font-bold text-center mb-12">🔗 Integration Hub</h1>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <IntegrationButton icon="🎓" title="K1: Login" @click="redirectToK1" />
        <IntegrationButton icon="📱" title="K2: Login" @click="redirectToK2" />
        <IntegrationButton icon="🍽️" title="K4: Menus" @click="showK4Modal" :loading="k4Loading" />
        <IntegrationButton icon="🛒" title="K5: Cart" @click="showK5Modal" :loading="k5Loading" />
        <IntegrationButton icon="🩺" title="K6: Gejala" @click="showK6Modal" :loading="k6Loading" />
        <IntegrationButton icon="📝" title="K7: Register" @click="redirectToK7" />
      </div>
    </div>

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

const showK4ModalFlag = ref(false), showK5ModalFlag = ref(false), showK6ModalFlag = ref(false)
const k4Loading = ref(false), k5Loading = ref(false), k6Loading = ref(false)
const k4Menus = ref([]), k5Cart = ref([]), k6Gejala = ref([])
const k4Error = ref(null), k5Error = ref(null), k6Error = ref(null)

const redirectToK1 = () => window.open(integrationService.getLoginUrls().k1, '_blank')
const redirectToK2 = () => window.open(integrationService.getLoginUrls().k2, '_blank')
const redirectToK7 = () => window.open(integrationService.getLoginUrls().k7, '_blank')

const showK4Modal = async () => {
  showK4ModalFlag.value = true
  k4Loading.value = true
  const result = await integrationService.getK4Menus()
  if (result.success) k4Menus.value = result.data.data || result.data
  else k4Error.value = result.message
  k4Loading.value = false
}

const showK5Modal = async () => {
  showK5ModalFlag.value = true
  k5Loading.value = true
  const result = await integrationService.getK5Cart()
  if (result.success) k5Cart.value = result.data.data || result.data
  else k5Error.value = result.message
  k5Loading.value = false
}

const showK6Modal = async () => {
  showK6ModalFlag.value = true
  k6Loading.value = true
  const result = await integrationService.getK6Gejala()
  if (result.success) k6Gejala.value = result.data.data || result.data
  else k6Error.value = result.message
  k6Loading.value = false
}
</script>
```

### **STEP 4: `resources/js/components/IntegrationButton.vue`**
```vue
<template>
  <button @click="$emit('click')" :disabled="loading" class="p-6 border rounded-lg hover:shadow-lg transition bg-white">
    <div class="text-4xl mb-2">{{ icon }}</div>
    <h3 class="font-bold text-lg">{{ title }}</h3>
    <div v-if="loading" class="mt-3 text-sm text-gray-500">Loading...</div>
  </button>
</template>

<script setup>
defineProps({ icon: String, title: String, loading: Boolean })
defineEmits(['click'])
</script>
```

### **STEP 5: `resources/js/components/ModalK4Menus.vue`**
```vue
<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg w-full max-w-2xl max-h-[80vh] overflow-y-auto">
      <div class="bg-orange-500 text-white p-4 flex justify-between">
        <h2>🍽️ Food Menus</h2>
        <button @click="$emit('close')">✕</button>
      </div>
      <div class="p-4">
        <div v-if="loading" class="text-center py-8">Loading...</div>
        <div v-else-if="error" class="bg-red-50 p-4 text-red-800">{{ error }}</div>
        <div v-else class="space-y-3">
          <div v-for="menu in menus" :key="menu.id" class="border p-3 rounded">
            <h3 class="font-bold">{{ menu.name || menu.nama }}</h3>
            <p class="text-sm">{{ menu.price || menu.harga }}</p>
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
```

### **STEP 6: `resources/js/components/ModalK5Cart.vue`**
```vue
<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg w-full max-w-2xl max-h-[80vh] overflow-y-auto">
      <div class="bg-pink-500 text-white p-4 flex justify-between">
        <h2>🛒 Shopping Cart</h2>
        <button @click="$emit('close')">✕</button>
      </div>
      <div class="p-4">
        <div v-if="loading" class="text-center py-8">Loading...</div>
        <div v-else-if="error" class="bg-red-50 p-4 text-red-800">{{ error }}</div>
        <div v-else class="space-y-3">
          <div v-for="item in cart" :key="item.id" class="border p-3 rounded">
            <h3 class="font-bold">{{ item.nama || item.name }}</h3>
            <p class="text-sm">Qty: {{ item.kuantitas || item.quantity }}</p>
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
```

### **STEP 7: `resources/js/components/ModalK6Gejala.vue`**
```vue
<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg w-full max-w-2xl max-h-[80vh] overflow-y-auto">
      <div class="bg-purple-500 text-white p-4 flex justify-between">
        <h2>🩺 Symptoms</h2>
        <button @click="$emit('close')">✕</button>
      </div>
      <div class="p-4">
        <div v-if="loading" class="text-center py-8">Loading...</div>
        <div v-else-if="error" class="bg-red-50 p-4 text-red-800">{{ error }}</div>
        <div v-else class="space-y-3">
          <div v-for="item in gejala" :key="item.id" class="border-l-4 border-purple-500 bg-purple-50 p-3">
            <h3 class="font-bold">{{ item.nama_gejala || item.name }}</h3>
            <p class="text-sm">{{ item.deskripsi }}</p>
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
```

### **STEP 8: Update `resources/js/router.js`**
Tambah route:
```javascript
{ path: '/integrations', name: 'Integrations', component: () => import('../pages/Integrations.vue') }
```

### **STEP 9: Update `resources/js/App.vue`**
Tambah di navbar:
```html
<router-link to="/integrations" class="nav-link">🔗 Integrations</router-link>
```

### **STEP 10: Test & Build**
```bash
npm run dev
npm run build
```

---

## ✅ CHECKLIST
- [ ] Step 1-10 selesai
- [ ] Test di browser: `/integrations`
- [ ] Build production

**DONE! 🚀**
