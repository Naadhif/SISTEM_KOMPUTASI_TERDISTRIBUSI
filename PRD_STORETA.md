# Product Requirements Document (PRD)
## STORETA – Platform E-Commerce

**Mata Kuliah:** Sistem Komputasi Terdistribusi
**Dokumen:** PRD Pengembangan Hingga UTS
**Versi:** 1.0
**Kelompok:**
- Achmad Mauladi (240210501033)
- Muhammad Yusuf (240210502066)
- Dhirga Afrhiza (230210501004)
- Thariq Ziyad Chalid (230210501003)
- Muh. Nadhif Ihdar (240210502042)

---

## 1. Ringkasan Eksekutif

STORETA adalah platform *e-commerce* yang mempertemukan **Seller** (penjual) dengan **User** (pembeli) dalam transaksi jual-beli produk secara daring, dengan **Admin** sebagai pengelola operasional sistem. Dokumen ini merumuskan kebutuhan produk (*product requirements*) untuk fase pengembangan hingga UTS, mencakup autentikasi, manajemen produk & kategori, manajemen seller, dan proses pemesanan, dengan backend berbasis **REST API**.

## 2. Latar Belakang & Masalah

Pelaku UMKM dan individu membutuhkan kanal digital untuk menjual produk tanpa harus membangun infrastruktur sendiri, sementara pembeli membutuhkan satu platform untuk menemukan, membandingkan, dan memesan produk dari berbagai penjual. STORETA menjawab kebutuhan ini dengan satu sistem terpusat yang memisahkan tanggung jawab tiga peran pengguna secara jelas.

## 3. Tujuan Produk (Fase hingga UTS)

1. Menyediakan sistem autentikasi & otorisasi berbasis role (Admin, Seller, User).
2. Menyediakan pengelolaan produk dan kategori (termasuk relasi multi-kategori).
3. Menyediakan pengelolaan data seller oleh Admin.
4. Menyediakan alur pemesanan dari sisi User hingga pengelolaan status oleh Admin.
5. Menyediakan REST API yang dapat dikonsumsi aplikasi frontend secara independen (arsitektur terdistribusi client-server).

## 4. Ruang Lingkup

**Termasuk (in-scope) hingga UTS:**
- Autentikasi & manajemen akses 3 role
- CRUD User, Kategori, Produk
- Manajemen stok produk
- Proses pemesanan & detail pesanan
- Manajemen status pesanan
- Dashboard ringkas untuk Admin

**Di luar cakupan (out-of-scope) fase ini:**
- Pembayaran (payment gateway)
- Notifikasi real-time / chat
- Review & rating produk
- Sistem promo/diskon

## 5. Pengguna & Peran (Roles)

| Role | Deskripsi Umum |
|---|---|
| **Admin** | Mengelola data dan operasional sistem secara menyeluruh |
| **Seller** | Mengelola produk yang dijual, termasuk stok |
| **User** | Melihat produk dan melakukan pemesanan |

### 5.1 Hak Akses per Role

**Admin**
- Mengelola user
- Mengelola kategori
- Mengelola produk
- Melihat seluruh pesanan
- Mengelola status pesanan
- Mengelola konten administrasi

**Seller**
- Menambahkan produk
- Melihat produk miliknya
- Mengubah produk
- Menghapus produk
- Mengelola stok
- Melihat pesanan yang berkaitan dengan produknya

**User**
- Melihat produk
- Melihat kategori
- Membuat pesanan
- Melihat pesanan sendiri
- Melihat detail pesanan
- Membatalkan pesanan sesuai ketentuan

## 6. User Stories Utama

| # | Sebagai | Saya ingin | Agar |
|---|---|---|---|
| 1 | User | login/register | dapat mengakses fitur sesuai role saya |
| 2 | Admin | mengelola data user | menjaga integritas pengguna sistem |
| 3 | Seller | menambah & mengubah produk | produk saya dapat dijual di platform |
| 4 | Seller | mengatur stok | jumlah produk selalu akurat saat dipesan |
| 5 | User | melihat produk berdasarkan kategori | mudah menemukan produk yang dicari |
| 6 | User | membuat pesanan | dapat membeli produk yang diinginkan |
| 7 | Admin | mengubah status pesanan | proses transaksi dapat dipantau dan dikelola |
| 8 | Seller | melihat pesanan terkait produknya | dapat memproses pesanan tepat waktu |

## 7. Daftar Fitur (Fase hingga UTS)

| No | Fitur | Keterangan |
|---|---|---|
| 1 | Login & Autentikasi | Mengatur akses Admin, Seller, dan User |
| 2 | Manajemen User | Admin mengelola data pengguna |
| 3 | Manajemen Seller | Pengelolaan akun dan data seller |
| 4 | Manajemen Kategori | Menambah, mengubah, dan menghapus kategori |
| 5 | Manajemen Produk | Seller mengelola produk yang dijual |
| 6 | Multi-kategori Produk | Satu produk dapat memiliki beberapa kategori |
| 7 | Manajemen Stok | Mengatur jumlah stok produk |
| 8 | Pemesanan | User dapat membuat pesanan |
| 9 | Detail Pesanan | Menampilkan produk dan jumlah dalam pesanan |
| 10 | Status Pesanan | Mengatur status proses pesanan |
| 11 | Dashboard Admin | Menampilkan informasi dan data sistem |

## 8. Kebutuhan Fungsional

- **FR-1:** Sistem harus dapat memverifikasi kredensial pengguna dan menentukan role saat login.
- **FR-2:** Sistem harus membatasi akses endpoint sesuai role (RBAC).
- **FR-3:** Admin dapat melakukan CRUD terhadap data user, kategori, dan produk.
- **FR-4:** Seller hanya dapat mengelola produk miliknya sendiri.
- **FR-5:** Satu produk dapat terhubung ke lebih dari satu kategori (relasi N:N).
- **FR-6:** Sistem harus mengurangi stok produk otomatis saat pesanan dibuat.
- **FR-7:** User dapat membuat pesanan berisi satu atau lebih produk (order_details).
- **FR-8:** Sistem harus menghitung subtotal (harga × qty) dan total pesanan otomatis.
- **FR-9:** Admin dapat mengubah status pesanan (mis. diproses, dikirim, selesai, dibatalkan).
- **FR-10:** User dapat membatalkan pesanan sesuai ketentuan status yang masih diizinkan.
- **FR-11:** Seller dapat melihat pesanan yang mengandung produk miliknya.

## 9. Kebutuhan Non-Fungsional

- **Arsitektur:** REST API sebagai backend, dapat dikonsumsi frontend secara terpisah (mendukung prinsip sistem terdistribusi/client-server).
- **Keamanan:** Password harus disimpan dalam bentuk terenkripsi (hash); otorisasi berbasis role di setiap endpoint.
- **Skalabilitas:** Struktur data mendukung penambahan kategori/produk dalam jumlah besar tanpa perubahan skema.
- **Konsistensi Data:** Perubahan stok dan status pesanan harus konsisten (menghindari race condition saat pesanan bersamaan).
- **Maintainability:** Kode backend terstruktur modular per entitas (user, kategori, produk, pesanan).

## 10. Rancangan Database

### 10.1 Entitas Utama

| Tabel | Fungsi |
|---|---|
| `users` | Menyimpan seluruh pengguna sistem (Admin/Seller/User) |
| `categories` | Menyimpan kategori produk (mendukung kategori induk) |
| `products` | Menyimpan produk yang dijual seller |
| `product_category` | Tabel pivot relasi many-to-many produk ↔ kategori |
| `orders` | Menyimpan data pesanan |
| `order_details` | Menyimpan rincian produk dalam tiap pesanan |

### 10.2 Struktur Tabel

**users**
| Field | Keterangan |
|---|---|
| id | Primary key |
| name | Nama pengguna |
| email | Email |
| password | Password |
| role | Admin / User / Seller |
| created_at | Waktu dibuat |
| updated_at | Waktu diubah |

**categories**
| Field | Keterangan |
|---|---|
| id | Primary key |
| name | Nama kategori |
| parent_id | Relasi ke kategori induk |
| created_at | Waktu dibuat |
| updated_at | Waktu diubah |

**products**
| Field | Keterangan |
|---|---|
| id | Primary key |
| seller_id | Pemilik produk |
| name | Nama produk |
| description | Deskripsi |
| price | Harga |
| stock | Stok |
| image | Gambar produk |
| created_at | Waktu dibuat |
| updated_at | Waktu diubah |

**product_category**
| Field | Keterangan |
|---|---|
| product_id | FK ke products |
| category_id | FK ke categories |

**orders**
| Field | Keterangan |
|---|---|
| id | Primary key |
| user_id | Pembeli |
| status | Status pesanan |
| total | Total pembayaran |
| created_at | Waktu pesanan |
| updated_at | Waktu diubah |

**order_details**
| Field | Keterangan |
|---|---|
| id | Primary key |
| order_id | FK ke orders |
| product_id | FK ke products |
| quantity | Jumlah produk |
| price | Harga saat transaksi |
| subtotal | Harga × quantity |

### 10.3 Relasi Antar Tabel

| Relasi | Jenis |
|---|---|
| users → products | 1 : N |
| users → orders | 1 : N |
| products ↔ categories | N : N |
| orders → order_details | 1 : N |
| products → order_details | 1 : N |
| categories → categories | 1 : N |

## 11. Spesifikasi API (REST)

### 11.1 User
| Method | Endpoint | Fungsi |
|---|---|---|
| POST | /api/users | Menambah user |
| GET | /api/users | Menampilkan semua user |
| GET | /api/users/{id} | Menampilkan detail user |
| PUT | /api/users/{id} | Mengubah user |
| DELETE | /api/users/{id} | Menghapus user |

### 11.2 Category
| Method | Endpoint | Fungsi |
|---|---|---|
| POST | /api/categories | Menambah kategori |
| GET | /api/categories | Menampilkan kategori |
| GET | /api/categories/{id} | Detail kategori |
| PUT | /api/categories/{id} | Mengubah kategori |
| DELETE | /api/categories/{id} | Menghapus kategori |

### 11.3 Product
| Method | Endpoint | Fungsi |
|---|---|---|
| POST | /api/products | Menambah produk |
| GET | /api/products | Menampilkan produk |
| GET | /api/products/{id} | Detail produk |
| PUT | /api/products/{id} | Mengubah produk |
| DELETE | /api/products/{id} | Menghapus produk |

### 11.4 Order
| Method | Endpoint | Fungsi |
|---|---|---|
| POST | /api/orders | Membuat pesanan |
| GET | /api/orders | Menampilkan pesanan |
| GET | /api/orders/{id} | Detail pesanan |
| PUT | /api/orders/{id} | Mengubah status pesanan |
| DELETE | /api/orders/{id} | Membatalkan/menghapus pesanan |

### 11.5 Order Detail
| Method | Endpoint | Fungsi |
|---|---|---|
| POST | /api/orders/{order}/items | Menambahkan item |
| GET | /api/orders/{order}/items | Melihat item pesanan |
| PUT | /api/orders/{order}/items/{item} | Mengubah jumlah |
| DELETE | /api/orders/{order}/items/{item} | Menghapus item |

## 12. Alur Utama (High-Level Flow)

1. User/Seller mendaftar → login → sistem menentukan role & hak akses.
2. Admin mengelola kategori dasar.
3. Seller menambahkan produk dan mengaitkannya ke satu/lebih kategori, mengatur stok.
4. User menjelajah produk berdasarkan kategori, lalu membuat pesanan (satu atau lebih item).
5. Sistem menghitung subtotal & total, mengurangi stok produk terkait.
6. Seller melihat pesanan yang berisi produknya untuk diproses.
7. Admin memantau dan memperbarui status pesanan hingga selesai/dibatalkan.
8. Admin memantau ringkasan data melalui dashboard.

## 13. Metrik Keberhasilan (Fase hingga UTS)

- Seluruh endpoint CRUD (User, Kategori, Produk, Order, Order Detail) berfungsi dan teruji.
- Alur pemesanan end-to-end (buat pesanan → kurangi stok → ubah status) berjalan tanpa inkonsistensi data.
- Hak akses per role terverifikasi (tidak ada akses lintas-role yang tidak sah).

## 14. Risiko & Batasan

| Risiko | Mitigasi |
|---|---|
| Race condition saat stok berkurang bersamaan | Gunakan transaksi database & validasi stok sebelum commit |
| Kesalahan relasi many-to-many produk-kategori | Uji integritas tabel pivot `product_category` |
| Otorisasi role tertembus | Middleware pengecekan role di setiap endpoint |

## 15. Roadmap Singkat

| Tahap | Fokus |
|---|---|
| Sprint 1 | Autentikasi & manajemen user/role |
| Sprint 2 | Manajemen kategori & produk (termasuk multi-kategori) |
| Sprint 3 | Manajemen stok & seller |
| Sprint 4 | Alur pemesanan, detail pesanan, status pesanan |
| Sprint 5 | Dashboard Admin & pengujian integrasi menjelang UTS |
