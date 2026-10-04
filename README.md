# 🛒 STORETA - E-Commerce API

**Sistem e-commerce terdistribusi dengan REST API yang dibangun menggunakan Laravel 11 dan token-based authentication.**

> Proyek ini adalah sistem e-commerce lengkap untuk mata kuliah **Sistem Komputasi Terdistribusi** (UTS Phase) dengan 3 role (Admin, Seller, User), manajemen produk multi-kategori, dan sistem order dengan stock management.

---

## 🌟 Fitur Utama

### ✅ Authentication & Authorization
- Token-based authentication menggunakan **Laravel Sanctum**
- 3 role berbeda: **Admin**, **Seller**, **User**
- Role-based access control (RBAC) dengan middleware custom
- Secure password hashing dengan bcrypt

### ✅ User Management
- Registration untuk user baru (role: user/seller)
- Login dengan access token
- Admin dapat manage semua users (CRUD)
- User profiling dengan timestamps

### ✅ Product Management
- **Seller** dapat membuat & manage produk mereka sendiri
- **Admin** dapat manage semua produk
- Multi-category support - satu produk bisa punya multiple kategori
- Stock tracking & management
- Detailed product information (name, description, price, image, stock)

### ✅ Category Management
- Hierarchical categories dengan parent-child relationships
- Admin dapat manage kategori (CRUD)
- N:N relationship dengan products (pivot table)
- Support sub-categories

### ✅ Order Management
- User dapat membuat order dengan multiple items
- Stock validation & auto-reduction saat order dibuat
- Role-based order filtering:
  - User: hanya lihat order mereka sendiri
  - Seller: lihat order yang berisi produk mereka
  - Admin: lihat semua orders
- Order status management (pending, processing, shipped, delivered, cancelled)
- Order cancellation dengan stock restoration
- Database transaction safety

### ✅ Dashboard Admin
- Comprehensive statistics & insights
- Total users breakdown by role
- Orders by status
- Recent orders (last 10)
- Top products (most frequently ordered)
- Low stock alerts
- Revenue & average order value calculations

### ✅ API Documentation
- Complete endpoint documentation (27 endpoints)
- Request/response examples
- Test credentials provided
- Error handling guide

---

## 🏗️ Tech Stack

| Component | Technology |
|-----------|-----------|
| **Framework** | Laravel 11 |
| **Language** | PHP 8.1+ |
| **Database** | SQLite (dapat switch ke MySQL/PostgreSQL) |
| **Authentication** | Laravel Sanctum |
| **Authorization** | Custom RBAC Middleware |
| **API Style** | RESTful JSON |
| **Server** | PHP Built-in Server |

---

## 📋 Prerequisites

- PHP 8.1 atau lebih tinggi
- Composer (package manager PHP)
- Git (untuk version control)
- Terminal/Command Prompt

---

## 🚀 Quick Start

### 1. Clone atau Setup Repository
```bash
# Navigate ke folder project
cd "d:\ACHMAD MAULADI-MY FOLDER\Semester 5\Sistem Komputasi Terdistribusi\Projek kelompok\e-commerce"

# Install dependencies jika belum
composer install
```

### 2. Setup Environment
```bash
# Copy .env.example ke .env (jika belum ada)
cp .env.example .env

# Generate app key
php artisan key:generate
```

### 3. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed test data
php artisan db:seed
```

### 4. Start Server
```bash
# Start PHP development server
php artisan serve

# Server akan running di http://127.0.0.1:8000
```

---

## 📚 API Documentation

### Base URL
```
http://127.0.0.1:8000/api
```

### Endpoints Overview

| Category | Method | Endpoint | Auth | Role |
|----------|--------|----------|------|------|
| **Auth** | POST | `/auth/register` | No | - |
| | POST | `/auth/login` | No | - |
| | GET | `/auth/me` | Yes | - |
| | POST | `/auth/logout` | Yes | - |
| **Categories** | GET | `/categories` | No | - |
| | GET | `/categories/{id}` | No | - |
| | POST | `/categories` | Yes | Admin |
| | PUT | `/categories/{id}` | Yes | Admin |
| | DELETE | `/categories/{id}` | Yes | Admin |
| **Products** | GET | `/products` | No | - |
| | GET | `/products/{id}` | No | - |
| | POST | `/products` | Yes | Seller/Admin |
| | PUT | `/products/{id}` | Yes | Seller/Admin |
| | DELETE | `/products/{id}` | Yes | Seller/Admin |
| **Orders** | GET | `/orders` | Yes | - |
| | POST | `/orders` | Yes | User |
| | GET | `/orders/{id}` | Yes | - |
| | PUT | `/orders/{id}` | Yes | Admin |
| | DELETE | `/orders/{id}` | Yes | - |
| **Users** | GET | `/users` | Yes | Admin |
| | GET | `/users/{id}` | Yes | Admin |
| | POST | `/users` | Yes | Admin |
| | PUT | `/users/{id}` | Yes | Admin |
| | DELETE | `/users/{id}` | Yes | Admin |
| **Dashboard** | GET | `/dashboard/stats` | Yes | Admin |

**Total: 27 endpoints - ALL IMPLEMENTED ✅**

---

## 🔐 Test Credentials

Gunakan credentials berikut untuk testing:

### Admin
```
Email: admin@storeta.com
Password: password123
Role: admin
```

### Seller 1
```
Email: seller1@storeta.com
Password: password123
Role: seller
```

### Seller 2
```
Email: seller2@storeta.com
Password: password123
Role: seller
```

### Regular User
```
Email: user@storeta.com
Password: password123
Role: user
```

### Buyer
```
Email: buyer1@storeta.com
Password: password123
Role: user
```

---

## 📖 Usage Examples

### 1. Login & Get Token
```bash
curl -X POST http://127.0.0.1:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "seller1@storeta.com",
    "password": "password123"
  }'
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 2,
      "name": "Seller One",
      "email": "seller1@storeta.com",
      "role": "seller"
    },
    "access_token": "YOUR_TOKEN_HERE"
  }
}
```

### 2. Get All Products
```bash
curl -X GET http://127.0.0.1:8000/api/products \
  -H "Accept: application/json"
```

### 3. Get Current User (Protected)
```bash
curl -X GET http://127.0.0.1:8000/api/auth/me \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Accept: application/json"
```

### 4. Create Product (Seller Only)
```bash
curl -X POST http://127.0.0.1:8000/api/products \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "New Product",
    "description": "Product description",
    "price": 99.99,
    "stock": 50,
    "categories": [1, 2]
  }'
```

### 5. Create Order (User Only)
```bash
curl -X POST http://127.0.0.1:8000/api/orders \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "items": [
      {"product_id": 1, "quantity": 1},
      {"product_id": 2, "quantity": 2}
    ]
  }'
```

### 6. Get Dashboard Stats (Admin Only)
```bash
curl -X GET http://127.0.0.1:8000/api/dashboard/stats \
  -H "Authorization: Bearer ADMIN_TOKEN" \
  -H "Accept: application/json"
```

---

## 🗄️ Database Structure

### Tables

**users** - User accounts
- id, name, email, password, role, timestamps

**categories** - Product categories
- id, name, parent_id (untuk hierarchy), timestamps

**products** - Product inventory
- id, seller_id, name, description, price, stock, image, timestamps

**product_category** - N:N relationship
- product_id, category_id (composite key)

**orders** - Customer orders
- id, user_id, status, total, timestamps

**order_details** - Order items
- id, order_id, product_id, quantity, price, subtotal, timestamps

**personal_access_tokens** - Sanctum tokens
- id, tokenable_id, tokenable_type, name, token, abilities, created_at

---

## 🔄 Workflow Example

### Typical User Workflow

1. **Register/Login** → dapatkan access token
2. **Browse Products** → GET `/products`
3. **View Product Details** → GET `/products/{id}`
4. **Create Order** → POST `/orders` dengan items
5. **View My Orders** → GET `/orders`
6. **Check Order Status** → GET `/orders/{id}`
7. **Cancel Order** (jika pending) → DELETE `/orders/{id}`

### Typical Seller Workflow

1. **Login** → dapatkan seller token
2. **Create Product** → POST `/products`
3. **Update Product** → PUT `/products/{id}`
4. **View Orders** → GET `/orders` (hanya orders dengan produk mereka)
5. **Check Low Stock** → GET `/dashboard/stats` (jika admin, atau lihat stock di products)

### Typical Admin Workflow

1. **Login** → dapatkan admin token
2. **Manage Users** → GET/POST/PUT/DELETE `/users`
3. **Manage Categories** → GET/POST/PUT/DELETE `/categories`
4. **Manage Orders** → GET `/orders`, PUT `/orders/{id}` (update status)
5. **View Dashboard** → GET `/dashboard/stats`

---

## 🔒 Security Features

✅ **Password Hashing** - Bcrypt encryption untuk semua passwords  
✅ **Token Authentication** - Sanctum untuk API token management  
✅ **RBAC Middleware** - Role-based access control pada routes  
✅ **Request Validation** - Laravel validation rules untuk semua inputs  
✅ **Authorization Checks** - Seller hanya bisa manage produk mereka sendiri  
✅ **Database Transactions** - Atomic operations untuk stock management  
✅ **CORS Support** - Ready untuk frontend integration  

---

## 📊 Test Data

### Pre-seeded Data
- **Users**: 5 (1 admin, 2 sellers, 2 regular users)
- **Categories**: 12 (3 parent, 9 sub-categories)
- **Products**: 6 (distributed among sellers)
- **Product-Category Relations**: 8

### Run Seeders
```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ProductSeeder
```

---

## 📝 File Structure

```
e-commerce/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── ProductController.php
│   │   │   ├── OrderController.php
│   │   │   ├── UserController.php
│   │   │   └── DashboardController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   └── Models/
│       ├── User.php
│       ├── Category.php
│       ├── Product.php
│       ├── Order.php
│       └── OrderDetail.php
├── database/
│   ├── migrations/
│   │   ├── create_categories_table
│   │   ├── create_products_table
│   │   ├── create_product_category_table
│   │   ├── create_orders_table
│   │   └── create_order_details_table
│   └── seeders/
│       ├── UserSeeder.php
│       ├── CategorySeeder.php
│       └── ProductSeeder.php
├── routes/
│   └── api.php
├── API_DOCUMENTATION.md
├── IMPLEMENTATION_STATUS.md
├── PRD_STORETA.md
└── README.md
```

---

## 🧪 Testing

### Manual Testing dengan cURL
```bash
# 1. Login
TOKEN=$(curl -s -X POST http://127.0.0.1:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"seller1@storeta.com","password":"password123"}' \
  | jq -r '.data.access_token')

# 2. Create product
curl -X POST http://127.0.0.1:8000/api/products \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Product",
    "description": "Test",
    "price": 99.99,
    "stock": 100,
    "categories": [1]
  }'

# 3. Get all products
curl -X GET http://127.0.0.1:8000/api/products
```

### Testing dengan Postman
1. Import API dokumentasi ke Postman
2. Setup environment dengan base URL dan token
3. Test setiap endpoint sesuai dokumentasi
4. Verify response status dan data

---

## 🐛 Troubleshooting

### Server tidak berjalan
```bash
# Pastikan PHP terinstall
php -v

# Check port 8000 availability
# Jika port 8000 sudah digunakan, gunakan port lain:
php artisan serve --port=8001
```

### Database error
```bash
# Reset database
php artisan migrate:fresh --seed

# Check database connection di .env
# Default SQLite sudah configured
```

### Token expired
```bash
# Token valid untuk 24 jam
# Login ulang untuk mendapatkan token baru
```

### Unauthorized/Forbidden
```bash
# Pastikan:
# 1. Token valid dan belum expired
# 2. User role sesuai dengan requirement endpoint
# 3. Seller hanya bisa akses produk mereka sendiri
```

---

## 📚 Documentation Files

- **API_DOCUMENTATION.md** - Complete API reference dengan semua endpoints
- **IMPLEMENTATION_STATUS.md** - Project status & completion checklist
- **PRD_STORETA.md** - Product Requirements Document
- **README.md** - This file

---

## 🔄 Update & Maintenance

### Install Dependencies
```bash
composer install
composer update
```

### Run Migrations
```bash
# Run pending migrations
php artisan migrate

# Reset database
php artisan migrate:fresh

# Reset with seeders
php artisan migrate:fresh --seed
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
```

---

## 📅 Version History

| Version | Date | Status |
|---------|------|--------|
| 1.0.0 | 2026-09-23 | ✅ Phase 1 Complete (UTS) |

---

## 👥 Team

**Project**: STORETA E-Commerce API  
**Course**: Sistem Komputasi Terdistribusi  
**Semester**: 5  
**Status**: **COMPLETE - Ready for Deployment** ✅

---

## 📞 Support & Notes

### Key Features Implemented
✅ Complete RBAC (3 roles)  
✅ Token-based authentication  
✅ Multi-category products  
✅ Order management dengan stock control  
✅ Role-based order filtering  
✅ Admin dashboard  
✅ Database transaction safety  
✅ Complete API documentation  

### Future Enhancements (Post-UTS)
- Payment gateway integration
- Real-time notifications
- Product reviews & ratings
- Promo codes & discounts
- Advanced search & filtering
- Email/SMS notifications
- Analytics & reporting

---

## 📄 License

Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**Created**: 2026-09-23  
**Status**: Phase 1 Complete ✅  
**Total Endpoints**: 27  
**Test Users**: 5  
**API Documentation**: Complete

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
