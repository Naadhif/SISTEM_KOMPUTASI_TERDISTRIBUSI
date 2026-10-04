# Dokumentasi API STORETA

## Informasi Umum
- **Base URL:** http://127.0.0.1:8000/api
- **Format Response:** JSON
- **Authentication:** Bearer Token (Laravel Sanctum)

---

## DAFTAR ENDPOINT API (27 Total)

### 1. AUTENTIKASI (4 Endpoints)

| No | Method | Endpoint | Deskripsi | Auth | Request Body | Response | Status |
|----|----|----------|-----------|------|--------------|----------|--------|
| 1 | POST | `/auth/register` | Registrasi user baru dengan email, password, dan role (user/seller) | ❌ | `{name, email, password, role}` | `{token, user}` | 201 |
| 2 | POST | `/auth/login` | Login menggunakan email & password, mendapatkan bearer token | ❌ | `{email, password}` | `{token, user}` | 200 |
| 3 | GET | `/auth/me` | Mendapatkan informasi user yang sedang login | ✅ | - | `{user}` | 200 |
| 4 | POST | `/auth/logout` | Logout dan revoke token user | ✅ | - | `{message}` | 200 |

**Penjelasan Detail:**
- **Register:** Buat akun baru, password di-hash dengan bcrypt, role bisa "user" atau "seller", token langsung diberikan setelah registrasi
- **Login:** Verifikasi email & password, token plaintext diberikan untuk digunakan di request berikutnya
- **Me:** Return data user saat ini (id, name, email, role), memerlukan token valid di header Authorization
- **Logout:** Revoke token yang digunakan, token tidak bisa digunakan lagi setelah logout

---

### 2. KATEGORI (5 Endpoints)

| No | Method | Endpoint | Deskripsi | Auth | Request Body | Response | Status |
|----|----|----------|-----------|------|--------------|----------|--------|
| 5 | GET | `/categories` | Mendapatkan list semua kategori dengan struktur hierarchical (parent-child) | ✅ | - | `[{id, name, parent_id, children}]` | 200 |
| 6 | GET | `/categories/{id}` | Mendapatkan detail kategori tertentu beserta child categories dan produk terkait | ✅ | - | `{id, name, parent_id, children, products}` | 200 |
| 7 | POST | `/categories` | Membuat kategori baru (Admin only), bisa set parent_id untuk hierarchical structure | ✅ | `{name, description, parent_id}` | `{id, name, ...}` | 201 |
| 8 | PUT | `/categories/{id}` | Update detail kategori tertentu (Admin only), bisa ubah nama, deskripsi, atau parent | ✅ | `{name, description, parent_id}` | `{id, name, ...}` | 200 |
| 9 | DELETE | `/categories/{id}` | Menghapus kategori (Admin only), akan cascade delete relasi dengan produk | ✅ | - | `{message}` | 200 |

**Penjelasan Detail:**
- **List:** Return semua kategori dengan struktur parent-child, categories bisa nested
- **Detail:** Return 1 kategori dengan child categories dan produk yang ada di kategori tersebut
- **Create:** Hanya admin bisa, name wajib, parent_id optional untuk membuat sub-kategori
- **Update:** Admin bisa ubah name/description/parent_id, validasi duplicate name per level
- **Delete:** Admin bisa hapus kategori, cascade delete relasi product_category

---

### 3. PRODUK (5 Endpoints)

| No | Method | Endpoint | Deskripsi | Auth | Request Body | Response | Status |
|----|----|----------|-----------|------|--------------|----------|--------|
| 10 | GET | `/products` | Mendapatkan list semua produk dengan filter kategori, seller, stock, dan sort | ✅ | - | `[{id, name, price, stock, seller, categories}]` | 200 |
| 11 | GET | `/products/{id}` | Mendapatkan detail produk tertentu lengkap dengan seller info dan list kategori | ✅ | - | `{id, name, description, price, stock, seller_id, seller, categories}` | 200 |
| 12 | POST | `/products` | Membuat produk baru (Seller/Admin), seller_id otomatis diisi dari user login | ✅ | `{name, description, price, stock, category_ids[]}` | `{id, name, ...}` | 201 |
| 13 | PUT | `/products/{id}` | Update produk (Seller bisa update miliknya, Admin bisa update semua) | ✅ | `{name, description, price, stock, category_ids[]}` | `{id, name, ...}` | 200 |
| 14 | DELETE | `/products/{id}` | Menghapus produk (Seller bisa hapus miliknya, Admin bisa hapus semua) | ✅ | - | `{message}` | 200 |

**Penjelasan Detail:**
- **List:** Return semua produk dengan seller name dan list kategori, bisa filter by category/seller
- **Detail:** Return 1 produk dengan seller object lengkap dan semua kategori terkait
- **Create:** Seller/Admin bisa buat, seller_id otomatis dari user login, category_ids bisa multi (N:N relationship)
- **Update:** Seller hanya bisa update produk miliknya, Admin bisa update semua, validasi price > 0 dan stock >= 0
- **Delete:** Soft delete atau hard delete, cascade delete product_category relations

---

### 4. PESANAN (5 Endpoints)

| No | Method | Endpoint | Deskripsi | Auth | Request Body | Response | Status |
|----|----|----------|-----------|------|--------------|----------|--------|
| 15 | GET | `/orders` | List pesanan dengan filtering role-based (user lihat punya sendiri, seller lihat yang beli produknya, admin lihat semua) | ✅ | - | `[{id, user_id, status, total_price, user, items}]` | 200 |
| 16 | GET | `/orders/{id}` | Detail pesanan tertentu dengan list order_details lengkap (produk, qty, harga saat order) | ✅ | - | `{id, user_id, status, total_price, created_at, details[]}` | 200 |
| 17 | POST | `/orders` | Membuat pesanan baru (User only), validasi stock, hitung total, kurangi stock atomically | ✅ | `{items[{product_id, quantity}]}` | `{id, user_id, total_price, status, details}` | 201 |
| 18 | PUT | `/orders/{id}/status` | Update status pesanan (Admin only), status: pending→processing→shipped→delivered atau cancelled | ✅ | `{status}` | `{id, status, updated_at}` | 200 |
| 19 | DELETE | `/orders/{id}/cancel` | Batalkan pesanan (User batalkan miliknya, Admin batalkan semua), restore stock otomatis | ✅ | - | `{message, order}` | 200 |

**Penjelasan Detail:**
- **List:** Role-based filtering, user lihat pesanan sendiri, seller lihat order dengan produknya, admin lihat semua
- **Detail:** Return pesanan + semua order_details dengan product info dan harga saat pemesanan
- **Create:** Validasi stock sebelum order dibuat, stock berkurang atomically dengan lockForUpdate(), hitung total dari semua items
- **Update Status:** Admin only, validasi status transition logic, bisa pending→processing→shipped→delivered atau pembatalan
- **Cancel:** Restore stock ke inventory, hanya order status "pending" yg bisa dibatalkan, pencatat waktu cancel

---

### 5. PENGGUNA (5 Endpoints - Admin Only)

| No | Method | Endpoint | Deskripsi | Auth | Request Body | Response | Status |
|----|----|----------|-----------|------|--------------|----------|--------|
| 20 | GET | `/admin/users` | List semua user dengan role, email, created_at, bisa filter by role | ✅ | - | `[{id, name, email, role, created_at}]` | 200 |
| 21 | GET | `/admin/users/{id}` | Detail user tertentu dengan stat (jumlah produk jika seller, jumlah order jika user) | ✅ | - | `{id, name, email, role, created_at, products_count, orders_count}` | 200 |
| 22 | POST | `/admin/users` | Buat user baru oleh admin, bisa set role (admin/seller/user), email unique | ✅ | `{name, email, password, role}` | `{id, name, email, role}` | 201 |
| 23 | PUT | `/admin/users/{id}` | Update user oleh admin, bisa ubah name/email/password/role, validasi email unique | ✅ | `{name, email, password, role}` | `{id, name, email, role}` | 200 |
| 24 | DELETE | `/admin/users/{id}` | Hapus user oleh admin, cascade delete produk dan pesanan user tersebut | ✅ | - | `{message}` | 200 |

**Penjelasan Detail:**
- **List:** Admin hanya bisa lihat list semua user, tidak ada filter tapi bisa sort by created_at
- **Detail:** Return user dengan statistical info (product count untuk seller, order count untuk user)
- **Create:** Admin buat user baru, validasi email belum terdaftar, password di-hash bcrypt
- **Update:** Admin bisa ubah profile user maupun role, password optional (jika kosong tidak diubah)
- **Delete:** Admin hapus user, cascade delete semua produk & pesanan user tersebut

---

### 6. DASHBOARD (1 Endpoint - Admin Only)

| No | Method | Endpoint | Deskripsi | Auth | Request Body | Response | Status |
|----|----|----------|-----------|------|--------------|----------|--------|
| 25 | GET | `/admin/dashboard` | Dashboard statistik admin (users, orders, products, revenue, top products, low stock) | ✅ | - | `{summary, users_by_role, orders_by_status, recent_orders, top_products, low_stock}` | 200 |

**Penjelasan Detail:**
- **Response Include:**
  - `summary`: total_users, total_products, total_categories, total_orders, total_revenue, average_order_value
  - `users_by_role`: count admin, seller, user
  - `orders_by_status`: count per status (pending, processing, shipped, delivered, cancelled)
  - `recent_orders`: 5 pesanan terbaru dengan user info
  - `top_products`: 5 produk paling laris (by order count)
  - `low_stock_products`: produk dengan stock < 10

---

### 7. ENDPOINT LAINNYA (2 Endpoints)

| No | Method | Endpoint | Deskripsi | Auth | Request Body | Response | Status |
|----|----|----------|-----------|------|--------------|----------|--------|
| 26 | GET | `/health` | Health check endpoint, return server status | ❌ | - | `{status, message}` | 200 |
| 27 | GET | `/info` | API info endpoint, return API version dan docs URL | ❌ | - | `{app, version, docs_url}` | 200 |

---

## KODE STATUS HTTP

| Status | Arti | Kapan Terjadi |
|--------|------|---------------|
| 200 | OK | Request berhasil, resource ditemukan dan diupdate |
| 201 | Created | Resource berhasil dibuat (POST) |
| 400 | Bad Request | Validasi gagal, input tidak sesuai format |
| 401 | Unauthorized | Token tidak ada atau invalid, user belum login |
| 403 | Forbidden | User tidak memiliki permission untuk akses resource ini |
| 404 | Not Found | Resource tidak ditemukan (ID invalid) |
| 422 | Unprocessable Entity | Validasi data gagal (duplicate email, stock insufficient) |
| 500 | Internal Server Error | Error di server side |

---

## TEST CREDENTIALS

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@storeta.com | password123 |
| Seller | seller@storeta.com | password123 |
| User | user@storeta.com | password123 |

---

**Last Updated:** 2026-09-24
  }'
```

Response:
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@storeta.com",
      "role": "admin"
    },
    "access_token": "1|ABZnp86MM1oC2hFMJs0RPBMxJjJ8cEQjGudkYUEi870232c3",
    "token_type": "Bearer"
  }
}
```

### Contoh: Create Order
```bash
curl -X POST http://127.0.0.1:8000/api/orders \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "items": [
      {"product_id": 1, "quantity": 1},
      {"product_id": 2, "quantity": 2}
    ]
  }'
```

Response:
```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "id": 1,
    "user_id": 4,
    "status": "pending",
    "total": 1039.97,
    "details": [
      {
        "product_id": 1,
        "quantity": 1,
        "price": 999.99,
        "subtotal": 999.99
      },
      {
        "product_id": 2,
        "quantity": 2,
        "price": 19.99,
        "subtotal": 39.98
      }
    ]
  }
}
```

---

## 12. Catatan Implementasi

1. **Autentikasi:** Semua endpoint kecuali login, register, dan GET public endpoints memerlukan token Bearer.

2. **Otorisasi:** RBAC diimplementasikan melalui middleware CheckRole yang memvalidasi role pengguna.

3. **Validasi Stok:** Sistem memvalidasi ketersediaan stok sebelum order dibuat menggunakan database transaction untuk mencegah race condition.

4. **Kalkulasi Otomatis:** Subtotal dan total pesanan dihitung otomatis berdasarkan harga dan jumlah item.

5. **Relasi Many-to-Many:** Produk dapat memiliki multiple kategori melalui tabel pivot `product_category`.

6. **Consistency:** Pengurangan stok dan pembaruan status pesanan dijamin konsisten melalui database transaction.

---

**Versi:** 1.0  
**Tanggal:** 2026-09-24  
**Framework:** Laravel 11  
**Database:** SQLite
