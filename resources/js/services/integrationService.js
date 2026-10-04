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
