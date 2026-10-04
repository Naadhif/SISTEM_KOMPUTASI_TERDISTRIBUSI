import { createRouter, createWebHistory } from 'vue-router';
import Home from './pages/Home.vue';
import Products from './pages/Products.vue';
import ProductDetail from './pages/ProductDetail.vue';
import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import Cart from './pages/Cart.vue';
import Profile from './pages/Profile.vue';
import AdminDashboard from './pages/admin/Dashboard.vue';
import AdminCategories from './pages/admin/Categories.vue';
import AdminProducts from './pages/admin/Products.vue';
import AdminUsers from './pages/admin/Users.vue';
import SellerDashboard from './pages/seller/Dashboard.vue';
import SellerProducts from './pages/seller/Products.vue';
// 1. Import halaman Integrations yang baru dibuat
import Integrations from './pages/Integrations.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
    {
        path: '/products',
        name: 'Products',
        component: Products,
    },
    {
        path: '/products/:id',
        name: 'ProductDetail',
        component: ProductDetail,
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: { requiresGuest: true },
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: { requiresGuest: true },
    },
    {
        path: '/cart',
        name: 'Cart',
        component: Cart,
        meta: { requiresAuth: true },
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile,
        meta: { requiresAuth: true },
    },
    {
        path: '/admin',
        name: 'AdminDashboard',
        component: AdminDashboard,
        meta: { requiresAuth: true, requiresRole: 'admin' },
    },
    {
        path: '/admin/categories',
        name: 'AdminCategories',
        component: AdminCategories,
        meta: { requiresAuth: true, requiresRole: 'admin' },
    },
    {
        path: '/admin/products',
        name: 'AdminProducts',
        component: AdminProducts,
        meta: { requiresAuth: true, requiresRole: 'admin' },
    },
    {
        path: '/admin/users',
        name: 'AdminUsers',
        component: AdminUsers,
        meta: { requiresAuth: true, requiresRole: 'admin' },
    },
    {
        path: '/seller',
        name: 'SellerDashboard',
        component: SellerDashboard,
        meta: { requiresAuth: true, requiresRole: 'seller' },
    },
    {
        path: '/seller/products',
        name: 'SellerProducts',
        component: SellerProducts,
        meta: { requiresAuth: true, requiresRole: 'seller' },
    },
    // 2. Tambahkan rute untuk Integrations Hub
    {
        path: '/integrations',
        name: 'Integrations',
        component: Integrations,
        // Anda bisa menambahkan meta: { requiresAuth: true } jika halaman ini butuh login, 
        // atau dibiarkan bebas diakses.
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation guards
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    const user = localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null;

    if (to.meta.requiresAuth && !token) {
        next('/login');
    } else if (to.meta.requiresGuest && token) {
        next('/');
    } else if (to.meta.requiresRole && user?.role !== to.meta.requiresRole) {
        next('/');
    } else {
        next();
    }
});

export default router;