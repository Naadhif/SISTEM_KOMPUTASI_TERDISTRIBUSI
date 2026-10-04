<template>
  <div class="space-y-8">
    <!-- Page Header -->
    <div>
      <h1 class="text-4xl font-bold text-gray-900">Keranjang Belanja</h1>
      <p class="text-gray-600 mt-2">{{ cartItems.length }} item dalam keranjang Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Cart Items -->
      <div class="lg:col-span-2">
        <div v-if="cartItems.length === 0" class="bg-white rounded-lg shadow p-8 text-center">
          <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          <p class="text-gray-600 text-lg mb-4">Keranjang Anda kosong</p>
          <router-link to="/products" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Lanjut Belanja
          </router-link>
        </div>

        <div v-else class="space-y-4">
          <div v-for="item in cartItems" :key="item.id" class="bg-white rounded-lg shadow p-6">
            <div class="flex gap-6">
              <!-- Product Image -->
              <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                </svg>
              </div>

              <!-- Product Info -->
              <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">{{ item.name }}</h3>
                <p class="text-sm text-gray-600 mt-1">Rp {{ formatPrice(item.price) }} per item</p>

                <!-- Quantity Controls -->
                <div class="flex items-center mt-4 space-x-3">
                  <button
                    @click="updateQuantity(item.id, item.quantity - 1)"
                    class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100"
                  >
                    −
                  </button>
                  <input
                    v-model.number="item.quantity"
                    type="number"
                    class="w-12 text-center py-1 border border-gray-300 rounded"
                    min="1"
                    @change="updateQuantity(item.id, item.quantity)"
                  >
                  <button
                    @click="updateQuantity(item.id, item.quantity + 1)"
                    class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100"
                  >
                    +
                  </button>
                </div>
              </div>

              <!-- Price & Actions -->
              <div class="text-right">
                <p class="text-2xl font-bold text-blue-600">Rp {{ formatPrice(item.price * item.quantity) }}</p>
                <button
                  @click="removeItem(item.id)"
                  class="mt-4 text-red-600 hover:text-red-800 font-semibold text-sm"
                >
                  Hapus
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Order Summary -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 sticky top-20 space-y-4">
          <h2 class="text-xl font-bold text-gray-900">Ringkasan Pesanan</h2>

          <div class="border-t pt-4 space-y-3">
            <div class="flex justify-between text-gray-700">
              <span>Subtotal</span>
              <span>Rp {{ formatPrice(subtotal) }}</span>
            </div>
            <div class="flex justify-between text-gray-700">
              <span>Diskon</span>
              <span class="text-red-600">-Rp {{ formatPrice(discount) }}</span>
            </div>
            <div class="flex justify-between text-gray-700">
              <span>Ongkos Kirim</span>
              <span v-if="shippingCost === 0" class="text-green-600">Gratis</span>
              <span v-else>Rp {{ formatPrice(shippingCost) }}</span>
            </div>
            <div class="flex justify-between text-gray-700">
              <span>Pajak (10%)</span>
              <span>Rp {{ formatPrice(tax) }}</span>
            </div>
          </div>

          <div class="border-t pt-4 flex justify-between items-center">
            <span class="text-lg font-bold text-gray-900">Total</span>
            <span class="text-2xl font-bold text-blue-600">Rp {{ formatPrice(total) }}</span>
          </div>

          <button
            v-if="cartItems.length > 0"
            @click="checkout"
            class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition"
          >
            Lanjut Checkout
          </button>

          <router-link
            to="/products"
            class="block text-center py-2 border border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition"
          >
            Lanjut Belanja
          </router-link>

          <!-- Promo Code -->
          <div class="border-t pt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Kode Promo</label>
            <div class="flex gap-2">
              <input
                v-model="promoCode"
                type="text"
                placeholder="Masukkan kode promo"
                class="flex-1 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
              <button
                @click="applyPromo"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition font-semibold"
              >
                Terapkan
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Cart',
  data() {
    return {
      cartItems: [
        {
          id: 1,
          name: 'Laptop Gaming Pro',
          price: 15999999,
          quantity: 1,
        },
        {
          id: 2,
          name: 'Wireless Mouse',
          price: 299000,
          quantity: 2,
        },
      ],
      promoCode: '',
      discount: 0,
    };
  },
  computed: {
    subtotal() {
      return this.cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    },
    shippingCost() {
      return this.subtotal >= 50000 ? 0 : 25000;
    },
    tax() {
      return Math.floor((this.subtotal - this.discount) * 0.1);
    },
    total() {
      return this.subtotal - this.discount + this.shippingCost + this.tax;
    },
  },
  methods: {
    updateQuantity(itemId, newQuantity) {
      if (newQuantity < 1) {
        this.removeItem(itemId);
        return;
      }

      const item = this.cartItems.find(i => i.id === itemId);
      if (item) {
        item.quantity = newQuantity;
      }
    },
    removeItem(itemId) {
      const index = this.cartItems.findIndex(i => i.id === itemId);
      if (index > -1) {
        this.cartItems.splice(index, 1);
      }
    },
    applyPromo() {
      if (this.promoCode.toUpperCase() === 'WELCOME20') {
        this.discount = Math.floor(this.subtotal * 0.2);
        alert('Kode promo berhasil diterapkan! Diskon 20%');
      } else if (this.promoCode.toUpperCase() === 'SAVE10') {
        this.discount = Math.floor(this.subtotal * 0.1);
        alert('Kode promo berhasil diterapkan! Diskon 10%');
      } else {
        alert('Kode promo tidak valid');
        this.promoCode = '';
      }
    },
    checkout() {
      alert('Melanjutkan ke halaman pembayaran');
      this.$router.push('/checkout');
    },
    formatPrice(price) {
      return new Intl.NumberFormat('id-ID').format(price);
    },
  },
};
</script>

<style scoped>
/* Cart specific styles */
</style>
