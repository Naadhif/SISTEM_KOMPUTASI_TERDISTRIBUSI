# STORETA - E-Commerce Platform

Platform e-commerce modern yang dibangun dengan Laravel 11, Vue 3, dan Tailwind CSS.

## Fitur Utama

- **Autentikasi**: Login/Register dengan role-based access (Admin, Seller, User)
- **Produk**: Katalog produk dengan filtering, sorting, dan detail produk
- **Keranjang Belanja**: Shopping cart dengan promo codes dan shipping calculation
- **Pesanan**: Order management dan tracking
- **Admin Dashboard**: Analytics dan quick actions
- **Seller Dashboard**: Dashboard khusus untuk seller dengan product management
- **User Profile**: Profil pengguna dengan order history dan security settings

## Tech Stack

- **Backend**: Laravel 11 dengan Sanctum Authentication
- **Frontend**: Vue 3 (Composition API) dengan Vue Router
- **Styling**: Tailwind CSS v4
- **Build Tool**: Vite
- **HTTP Client**: Axios
- **Database**: SQLite/MySQL

## Setup & Installation

### Prerequisites
- PHP 8.2+
- Node.js 18+
- npm atau yarn
- Composer

### 1. Clone Repository
```bash
cd "d:\ACHMAD MAULADI-MY FOLDER\Semester 5\Sistem Komputasi Terdistribusi\Projek kelompok\e-commerce"
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup
```bash
php artisan migrate:fresh --seed
```

Ini akan membuat tabel dan seed dengan data demo termasuk test users:
- **Admin**: admin@storeta.com / password123
- **Seller 1**: seller1@storeta.com / password123
- **Seller 2**: seller2@storeta.com / password123
- **User/Buyer**: user@storeta.com / password123

### 5. Install Frontend Dependencies
```bash
npm install
```

### 6. Development Server

Buka 2 terminal:

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```
Server akan berjalan di `http://localhost:8000`

**Terminal 2 - Vite Dev Server:**
```bash
npm run dev
```
Vite akan berjalan di `http://localhost:5173`

Akses aplikasi di `http://localhost:8000`

### 7. Production Build
```bash
npm run build
```

## Project Structure

```
e-commerce/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # API Controllers
│   │   └── Middleware/        # Auth & CORS middleware
│   └── Models/                # Eloquent Models
├── resources/
│   ├── css/
│   │   └── app.css           # Tailwind styles
│   ├── js/
│   │   ├── app.js            # Vue app entry point
│   │   ├── bootstrap.js      # Axios configuration
│   │   ├── router.js         # Vue Router setup
│   │   ├── App.vue           # Root layout component
│   │   └── pages/            # Page components
│   │       ├── Home.vue
│   │       ├── Products.vue
│   │       ├── ProductDetail.vue
│   │       ├── Cart.vue
│   │       ├── Profile.vue
│   │       ├── Login.vue
│   │       ├── Register.vue
│   │       ├── admin/        # Admin pages
│   │       └── seller/       # Seller pages
│   └── views/
│       └── app.blade.php     # Main Blade template
├── routes/
│   ├── api.php               # API routes
│   └── web.php               # Web routes (SPA)
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
└── config/
    └── auth.php              # Auth configuration
```

## API Documentation

### Authentication
```
POST /api/auth/login          - Login user
POST /api/auth/register       - Register new user
POST /api/auth/logout         - Logout user
GET  /api/auth/me             - Get current user
```

### Products
```
GET  /api/products            - Get all products
GET  /api/products/{id}       - Get product detail
POST /api/products            - Create product (seller/admin)
PUT  /api/products/{id}       - Update product (seller/admin)
DELETE /api/products/{id}     - Delete product (seller/admin)
```

### Categories
```
GET  /api/categories          - Get all categories
GET  /api/categories/{id}     - Get category detail
POST /api/categories          - Create category (admin)
PUT  /api/categories/{id}     - Update category (admin)
DELETE /api/categories/{id}   - Delete category (admin)
```

### Orders
```
GET  /api/orders              - Get user's orders
GET  /api/orders/{id}         - Get order detail
POST /api/orders              - Create order
PUT  /api/orders/{id}         - Update order status (seller/admin)
```

### Users (Admin only)
```
GET  /api/users               - Get all users
GET  /api/users/{id}          - Get user detail
POST /api/users               - Create user
PUT  /api/users/{id}          - Update user
DELETE /api/users/{id}        - Delete user
```

## Postman Collection

File `postman_collection.json` sudah tersedia untuk testing semua endpoints API. Import ke Postman:

1. Buka Postman
2. Click "Import"
3. Pilih file `postman_collection.json`
4. Set environment variable `base_url` ke `http://localhost:8000`
5. Mulai testing dengan demo credentials

## Authentication Flow

1. **Login**: User submit email & password → Backend return access token
2. **Token Storage**: Frontend store token di localStorage
3. **API Request**: Frontend include token di Authorization header: `Bearer {token}`
4. **Token Validation**: Backend validate token via Sanctum middleware
5. **Role-based Access**: Router guard check user role sebelum navigate

## User Roles & Permissions

### Admin
- Dashboard dengan analytics
- CRUD Products, Categories, Users
- View all orders

### Seller
- Seller Dashboard dengan sales stats
- CRUD produk mereka sendiri
- View orders dari produk mereka
- Profile management

### User (Buyer)
- Browse products
- View product details
- Shopping cart
- Create orders
- Order tracking
- Profile management

## Development Notes

### Vue 3 Composition API
Semua components menggunakan Vue 3 Composition API dengan `<script setup>` syntax untuk cleaner code.

### Tailwind CSS v4
Menggunakan Tailwind CSS v4 via @tailwindcss/vite plugin dengan utility classes yang modern.

### Axios Interceptors
Axios interceptor otomatis:
- Inject Bearer token ke setiap request
- Handle 401 responses dengan redirect ke login

### Vue Router Navigation Guards
Router guard check:
- Token validity di setiap navigation
- User role untuk role-based access control

## Testing

### Manual Testing
1. Login dengan test credentials
2. Browse products
3. Add to cart
4. Create order
5. View order history
6. Admin: Manage products/categories/users
7. Seller: Manage own products

### API Testing
Gunakan Postman collection untuk test semua endpoints.

## Troubleshooting

### Port sudah terpakai
- Laravel default port 8000, ganti dengan: `php artisan serve --port=8001`
- Vite default port 5173, ganti di vite.config.js

### Database error
```bash
php artisan migrate:fresh --seed
```

### Node modules issue
```bash
rm -rf node_modules package-lock.json
npm install
```

### Vite tidak meload styles
Pastikan `@vite(['resources/css/app.css', 'resources/js/app.js'])` di app.blade.php

## Production Deployment

1. Build frontend:
   ```bash
   npm run build
   ```

2. Set Laravel config:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. Run migrations:
   ```bash
   php artisan migrate --force
   ```

4. Start server (production):
   ```bash
   php artisan serve --env=production
   ```

## License

STORETA E-Commerce Platform - All rights reserved

## Support

Untuk pertanyaan atau bug reports, silakan hubungi tim development.
