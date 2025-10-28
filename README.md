<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🎓 Alumni Management API

REST API untuk sistem pengelolaan data alumni yang dibangun dengan Laravel 12 dan Laravel Sanctum. API ini menyediakan fitur lengkap untuk manajemen data alumni dengan dua level akses: **Admin** dan **Alumni**.

## 📋 Fitur Utama

### 🔐 Sistem Autentikasi Ganda

-   **Admin Authentication** - Untuk pengelola sistem yang memiliki akses penuh
-   **Alumni Authentication** - Untuk alumni yang dapat mengelola profil pribadi mereka
-   Token-based authentication menggunakan Laravel Sanctum
-   Password hashing dengan bcrypt

### 👨‍💼 Admin Features

-   ✅ CRUD (Create, Read, Update, Delete) data alumni
-   ✅ Filter alumni berdasarkan tahun kelulusan
-   ✅ Filter alumni berdasarkan status pekerjaan
-   ✅ Pencarian alumni (nama, NIM, email, perusahaan)
-   ✅ Statistik alumni (total, status pekerjaan, tahun lulus, rata-rata IPK)
-   ✅ Pagination & sorting
-   ✅ Soft delete untuk keamanan data

### 🎓 Alumni Features

-   ✅ Login dengan email dan password
-   ✅ Melihat profil pribadi lengkap
-   ✅ Update informasi pekerjaan (status, perusahaan, posisi, gaji)
-   ✅ Update informasi kontak (telepon, alamat, sosial media)
-   ✅ Ganti password
-   ✅ Tidak dapat mengakses data alumni lain

## 🛠️ Tech Stack

-   **Framework:** Laravel 12
-   **Authentication:** Laravel Sanctum
-   **Database:** MySQL
-   **API Style:** RESTful API
-   **Response Format:** JSON
-   **Architecture:** MVC Pattern

## 📦 Instalasi

### Prerequisites

```bash
- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Git
```

### Langkah Instalasi

1. **Clone Repository**

```bash
git clone https://github.com/rahmathidayatlubis/laravel12-api-employee-system.git
cd direktori-projek
```

2. **Install Dependencies**

```bash
composer install
```

3. **Setup Environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**
   Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alumni_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

5. **Buat Database**

```sql
CREATE DATABASE alumni_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

6. **Jalankan Migration & Seeder**

```bash
php artisan migrate --seed
```

7. **Jalankan Server**

```bash
php artisan serve
```

API akan berjalan di `http://127.0.0.1:8000`

## 🔑 Default Credentials

### Admin Account

```
Email: admin@alumni.com
Password: password123
```

### Alumni Account (Test)

```
Email: alumni1@example.com
Password: password123
```

## 📚 API Endpoints

### Authentication Endpoints

#### Admin

```http
POST   /api/admin/register      # Register admin baru
POST   /api/admin/login         # Login admin
POST   /api/admin/logout        # Logout admin
GET    /api/admin/me            # Get profil admin
```

#### Alumni

```http
POST   /api/alumni/login            # Login alumni
GET    /api/alumni/profile          # Get profil alumni
PUT    /api/alumni/profile          # Update profil alumni
POST   /api/alumni/change-password  # Ganti password
POST   /api/alumni/logout           # Logout alumni
```

### Alumni Management (Admin Only)

```http
GET    /api/alumni                  # Get all alumni (dengan filter)
POST   /api/alumni                  # Create alumni baru
GET    /api/alumni/{id}             # Get detail alumni
PUT    /api/alumni/{id}             # Update data alumni
DELETE /api/alumni/{id}             # Delete alumni (soft delete)
GET    /api/alumni-statistics       # Get statistik alumni
```

### Query Parameters (Filter & Search)

```
?tahun_lulus=2024              # Filter by tahun lulus
?status_pekerjaan=bekerja      # Filter by status pekerjaan
?jurusan=Teknik Informatika    # Filter by jurusan
?search=keyword                # Search nama, NIM, email, perusahaan
?per_page=15                   # Pagination (default: 15)
?page=1                        # Page number
?sort_by=nama_lengkap          # Sort field
?sort_order=asc                # Sort direction (asc/desc)
?active_only=true              # Filter hanya alumni aktif
```

## 📝 Request & Response Examples

### 1. Admin Login

**Request:**

```http
POST /api/admin/login
Content-Type: application/json

{
  "email": "admin@alumni.com",
  "password": "password123"
}
```

**Response:**

```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "Admin User",
            "email": "admin@alumni.com"
        },
        "access_token": "1|abc123...",
        "token_type": "Bearer"
    }
}
```

### 2. Create Alumni (Admin)

**Request:**

```http
POST /api/alumni
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "nim": "2024001001",
  "nama_lengkap": "Ahmad Rizki",
  "email": "ahmad@example.com",
  "password": "password123",
  "tahun_masuk": 2020,
  "tahun_lulus": 2024,
  "jurusan": "Teknik Informatika",
  "program_studi": "S1",
  "ipk": 3.75,
  "status_pekerjaan": "bekerja",
  "nama_perusahaan": "PT. Digital Innovation",
  "posisi_pekerjaan": "Software Engineer",
  "kota": "Jakarta",
  "provinsi": "DKI Jakarta"
}
```

### 3. Alumni Update Profile

**Request:**

```http
PUT /api/alumni/profile
Authorization: Bearer {alumni_token}
Content-Type: application/json

{
  "status_pekerjaan": "bekerja",
  "nama_perusahaan": "PT. Tech Startup",
  "posisi_pekerjaan": "Frontend Developer",
  "gaji_range": 8500000,
  "no_telepon": "081234567890"
}
```

### 4. Filter Alumni

**Request:**

```http
GET /api/alumni?tahun_lulus=2024&status_pekerjaan=bekerja&per_page=10
Authorization: Bearer {admin_token}
```

**Response:**

```json
{
  "data": [
    {
      "id": 1,
      "nim": "2024001001",
      "nama_lengkap": "Ahmad Rizki",
      "email": "ahmad@example.com",
      "akademik": {
        "tahun_lulus": 2024,
        "jurusan": "Teknik Informatika",
        "ipk": 3.75
      },
      "pekerjaan": {
        "status": "bekerja",
        "nama_perusahaan": "PT. Digital Innovation",
        "posisi": "Software Engineer"
      }
    }
  ],
  "links": {...},
  "meta": {...}
}
```

## 🎯 Status Pekerjaan

Nilai yang valid untuk `status_pekerjaan`:

-   `bekerja` - Sedang bekerja
-   `wirausaha` - Wirausaha/bisnis sendiri
-   `melanjutkan_studi` - Melanjutkan studi S2/S3
-   `mencari_kerja` - Sedang mencari pekerjaan
-   `lainnya` - Status lainnya

## 🔒 Authorization

Semua endpoint yang memerlukan autentikasi harus menyertakan header:

```http
Authorization: Bearer {your_token_here}
```

Token didapatkan setelah login berhasil dan disimpan di response `access_token`.

## 🗄️ Database Schema

### Tabel `users` (Admin)

-   id, name, email, password, timestamps

### Tabel `alumni`

-   **Identitas:** id, nim, nama_lengkap, email, password, no_telepon
-   **Akademik:** tahun_masuk, tahun_lulus, jurusan, program_studi, ipk
-   **Pekerjaan:** status_pekerjaan, nama_perusahaan, posisi_pekerjaan, bidang_pekerjaan, gaji_range
-   **Alamat:** alamat_lengkap, kota, provinsi
-   **Sosial Media:** linkedin_url, instagram_username
-   **Lainnya:** catatan, is_active, timestamps, soft_deletes

## 📞 Support

Jika ada pertanyaan atau masalah, silakan buat issue di repository ini.

---

**Built with Laravel 12 + Sanctum**
