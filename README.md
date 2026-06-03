# 🛒 Sales Management System - Cloud Computing Project

<p align="center">
  <strong>Sistem Manajemen Penjualan Terpadu dengan Arsitektur Cloud Computing</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/MySQL-8.0-005C87?style=for-the-badge&logo=mysql" alt="MySQL 8.0">
  <img src="https://img.shields.io/badge/Tailwind%20CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Vite-5.x-646CFF?style=for-the-badge&logo=vite" alt="Vite">
</p>

---

## 📋 Daftar Isi

- [Tentang Proyek](#tentang-proyek)
- [Fitur Utama](#fitur-utama)
- [Tech Stack](#tech-stack)
- [Prasyarat](#prasyarat)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Database](#database)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Struktur Proyek](#struktur-proyek)
- [API & Fitur](#api--fitur)
- [Testing](#testing)
- [Deployment](#deployment)
- [Troubleshooting](#troubleshooting)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)
- [Tim Pengembang](#tim-pengembang)

---

## 🎯 Tentang Proyek

**Sales Management System** adalah aplikasi web modern yang dibangun menggunakan Laravel 11 dan dirancang untuk memenuhi kebutuhan tugas Cloud Computing. Sistem ini menyediakan solusi lengkap untuk mengelola:

- **Katalog Produk**: Manajemen produk dengan gambar dan detail lengkap
- **Data Pelanggan**: Database pelanggan dengan informasi kontak dan riwayat transaksi
- **Penjualan & Pesanan**: Pencatatan transaksi penjualan dengan detail barang per pesanan
- **Notifikasi Real-time**: Sistem notifikasi untuk pesanan baru
- **Manajemen Pengguna**: Sistem autentikasi dan otorisasi dengan role berbeda

Proyek ini mengimplementasikan best practices dalam cloud computing termasuk scalability, security, dan maintainability.

---

## ✨ Fitur Utama

### 🔐 Autentikasi & Autorisasi
- ✅ Sistem login/register yang aman
- ✅ Role-based access control (RBAC)
- ✅ Proteksi CSRF dan XSS
- ✅ Password hashing dengan bcrypt
- ✅ Session management

### 📦 Manajemen Produk
- ✅ CRUD lengkap untuk produk
- ✅ Upload gambar produk dengan validasi
- ✅ Kategori produk
- ✅ Stok management
- ✅ Harga dinamis

### 👥 Manajemen Pelanggan
- ✅ Database pelanggan komprehensif
- ✅ Tracking riwayat pembelian
- ✅ Informasi kontak dan alamat
- ✅ Status keanggotaan

### 📊 Manajemen Penjualan
- ✅ Pencatatan order penjualan
- ✅ Detail line item per order
- ✅ Perhitungan total dan diskon otomatis
- ✅ Invoice generation
- ✅ Laporan penjualan

### 🔔 Sistem Notifikasi
- ✅ Notifikasi pesanan baru real-time
- ✅ Email notifications
- ✅ In-app notification center
- ✅ Notification history tracking

### 🎨 User Interface
- ✅ Responsive design dengan Tailwind CSS
- ✅ Admin dashboard
- ✅ Blade templating
- ✅ Modern & professional UI
- ✅ Mobile-friendly interface

---

## 🏗️ Tech Stack

### Backend
| Technology | Version | Purpose |
|-----------|---------|---------|
| **Laravel** | 11.x | Framework PHP |
| **PHP** | 8.2+ | Server-side language |
| **MySQL** | 8.0+ | Database |
| **Composer** | Latest | PHP package manager |

### Frontend
| Technology | Version | Purpose |
|-----------|---------|---------|
| **Tailwind CSS** | 3.x | Utility-first CSS framework |
| **Vite** | 5.x | Build tool & dev server |
| **JavaScript** | ES6+ | Client-side interactivity |
| **Blade** | 11.x | Template engine |

### Development Tools
| Tool | Version | Purpose |
|-----|---------|---------|
| **Node.js** | 18+ | JavaScript runtime |
| **npm** | 9+ | Package manager |
| **PHPUnit** | Latest | Testing framework |
| **Git** | Latest | Version control |

---

## 📋 Prasyarat

Sebelum memulai, pastikan Anda telah menginstall:

### Software Requirements
```bash
✓ PHP 8.2 atau lebih tinggi
✓ MySQL Server 8.0 atau lebih tinggi
✓ Node.js 18.x atau lebih tinggi
✓ npm 9.x atau lebih tinggi
✓ Composer (PHP dependency manager)
✓ Git
```

### Environment Check
```bash
# Cek PHP version
php -v

# Cek MySQL version
mysql --version

# Cek Node.js version
node -v

# Cek npm version
npm -v

# Cek Composer version
composer --version
```

---

## 🚀 Instalasi

### Step 1: Clone Repository
```bash
git clone https://github.com/khansatanaya2005-eng/Tubes_CC.git
cd kelompokcc
```

### Step 2: Install PHP Dependencies
```bash
composer install
```

### Step 3: Install Node Dependencies
```bash
npm install
```

### Step 4: Copy Environment File
```bash
cp .env.example .env
```

### Step 5: Generate Application Key
```bash
php artisan key:generate
```

### Step 6: Configure Database
Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tubes_cc
DB_USERNAME=root
DB_PASSWORD=
```

### Step 7: Run Migrations
```bash
php artisan migrate
```

### Step 8: Seed Database (Optional)
```bash
php artisan db:seed
```

### Step 9: Build Frontend Assets
```bash
npm run build
```

---

## ⚙️ Konfigurasi

### Environment Variables
File `.env` berisi konfigurasi penting:

```env
# App Configuration
APP_NAME="Sales Management System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tubes_cc
DB_USERNAME=root
DB_PASSWORD=

# Mail Configuration (jika menggunakan email)
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@example.com

# Cache Configuration
CACHE_DRIVER=file

# Queue Configuration
QUEUE_CONNECTION=sync
```

### Konfigurasi Database
Buat database MySQL baru:

```sql
CREATE DATABASE tubes_cc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Konfigurasi Aplikasi
Edit `config/app.php` jika diperlukan untuk:
- Timezone
- Locale
- Encryption cipher

---

## 🗄️ Database

### Database Schema

#### Users Table
Tabel untuk menyimpan data pengguna dan admin.

```
users
├── id (PK)
├── username (UNIQUE)
├── email (UNIQUE)
├── nama_lengkap
├── password
├── role (admin/user)
└── timestamps
```

#### Pelanggan Table
Tabel untuk menyimpan data pelanggan.

```
pelanggans
├── id (PK)
├── nama_pelanggan
├── email
├── no_telepon
├── alamat
└── timestamps
```

#### Produk Table
Tabel untuk menyimpan data produk.

```
produks
├── id (PK)
├── nama_produk
├── deskripsi
├── harga
├── stok
├── gambar
└── timestamps
```

#### Penjualan Table
Tabel untuk menyimpan data transaksi penjualan.

```
penjualans
├── id (PK)
├── pelanggan_id (FK)
├── user_id (FK)
├── total_harga
├── status
└── timestamps
```

#### Detail Penjualan Table
Tabel untuk menyimpan detail item dalam setiap penjualan.

```
detail_penjualans
├── id (PK)
├── penjualan_id (FK)
├── produk_id (FK)
├── jumlah
├── harga_satuan
├── subtotal
└── timestamps
```

#### Notifications Table
Tabel untuk menyimpan notifikasi sistem.

```
notifications
├── id (PK)
├── user_id (FK)
├── type
├── title
├── message
├── read_at
└── timestamps
```

### Running Migrations
```bash
# Run semua migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset semua migrations
php artisan migrate:reset

# Refresh migrations (reset + run)
php artisan migrate:refresh

# Refresh dengan seeding
php artisan migrate:refresh --seed
```

---

## 🏃 Menjalankan Aplikasi

### Development Mode

#### Terminal 1: Start Laravel Development Server
```bash
php artisan serve
```
Server akan berjalan di `http://localhost:8000`

#### Terminal 2: Start Vite Development Server
```bash
npm run dev
```
Assets akan di-build otomatis saat dimodifikasi.

### Production Mode

#### Build Frontend Assets
```bash
npm run build
```

#### Run with Production Settings
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📁 Struktur Proyek

```
kelompokcc/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Request handlers
│   │   └── Requests/             # Form validation
│   ├── Models/                   # Eloquent models
│   │   ├── User.php
│   │   ├── Pelanggan.php
│   │   ├── Produk.php
│   │   ├── Penjualan.php
│   │   ├── DetailPenjualan.php
│   │   └── ...
│   ├── Notifications/            # Notification classes
│   └── Providers/                # Service providers
├── bootstrap/                    # Bootstrap files
├── config/                       # Configuration files
├── database/
│   ├── migrations/              # Database migrations
│   ├── seeders/                 # Database seeders
│   └── factories/               # Model factories for testing
├── public/
│   ├── index.php               # Entry point
│   ├── images/                 # Public images
│   └── storage/                # Public storage
├── resources/
│   ├── css/                    # CSS files
│   │   └── app.css
│   ├── js/                     # JavaScript files
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/                  # Blade templates
│       ├── welcome.blade.php
│       ├── admin/              # Admin pages
│       ├── auth/               # Authentication pages
│       ├── layouts/            # Layout templates
│       ├── components/         # Reusable components
│       └── profile/            # User profile pages
├── routes/
│   ├── web.php                 # Web routes
│   ├── api.php                 # API routes
│   ├── auth.php                # Auth routes
│   └── console.php             # Console commands
├── storage/                    # File storage
│   ├── app/                    # Application files
│   ├── logs/                   # Application logs
│   └── framework/              # Framework files
├── tests/                      # Test files
│   ├── Feature/               # Feature tests
│   └── Unit/                  # Unit tests
├── vendor/                     # Composer dependencies
├── .env.example               # Example environment file
├── artisan                    # Laravel CLI
├── composer.json              # PHP dependencies
├── package.json               # JavaScript dependencies
├── tailwind.config.js         # Tailwind configuration
├── vite.config.js             # Vite configuration
├── phpunit.xml                # PHPUnit configuration
└── README.md                  # This file
```

---

## 🔌 API & Fitur

### Authentication Routes
```
POST   /login                   # Login user
POST   /register                # Register new user
POST   /logout                  # Logout user
GET    /forgot-password         # Forgot password form
POST   /forgot-password         # Send reset email
GET    /reset-password/{token}  # Reset password form
POST   /reset-password          # Reset password
```

### Dashboard Routes
```
GET    /dashboard               # Main dashboard
GET    /profile                 # User profile
PUT    /profile                 # Update profile
```

### Admin Routes (Protected)
```
# Produk Management
GET    /admin/produk            # List all products
POST   /admin/produk            # Create product
GET    /admin/produk/{id}       # Show product details
PUT    /admin/produk/{id}       # Update product
DELETE /admin/produk/{id}       # Delete product

# Pelanggan Management
GET    /admin/pelanggan         # List all customers
POST   /admin/pelanggan         # Create customer
GET    /admin/pelanggan/{id}    # Show customer details
PUT    /admin/pelanggan/{id}    # Update customer
DELETE /admin/pelanggan/{id}    # Delete customer

# Penjualan Management
GET    /admin/penjualan         # List all sales
POST   /admin/penjualan         # Create sale
GET    /admin/penjualan/{id}    # Show sale details
PUT    /admin/penjualan/{id}    # Update sale
DELETE /admin/penjualan/{id}    # Delete sale

# Reports
GET    /admin/reports           # Sales reports
GET    /admin/reports/daily     # Daily report
GET    /admin/reports/monthly   # Monthly report
```

### Notification Routes
```
GET    /notifications           # Get all notifications
GET    /notifications/read      # Mark as read
DELETE /notifications/{id}      # Delete notification
```

---

## 🧪 Testing

### Run All Tests
```bash
php artisan test
```

### Run Specific Test
```bash
php artisan test --filter=testLoginUser
```

### Run With Coverage
```bash
php artisan test --coverage
```

### Unit Tests
```bash
php artisan test tests/Unit
```

### Feature Tests
```bash
php artisan test tests/Feature
```

---

## 🌐 Deployment

### Pre-deployment Checklist
- [ ] Set `.env` to production
- [ ] Set `APP_DEBUG=false`
- [ ] Run migrations on production database
- [ ] Build frontend assets with `npm run build`
- [ ] Cache configuration: `php artisan config:cache`
- [ ] Cache routes: `php artisan route:cache`
- [ ] Cache views: `php artisan view:cache`

### Deploy to Production Server

#### Option 1: Manual Deployment
```bash
# Clone repository
git clone https://github.com/khansatanaya2005-eng/Tubes_CC.git

# Install dependencies
composer install --no-dev
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate --force

# Build assets
npm run build

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Option 2: Using Docker (Recommended for Cloud)
```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    mysql-client \
    libpq-dev \
    && docker-php-ext-install pdo_mysql

# Copy project
COPY . /app
WORKDIR /app

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies
RUN npm install
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data /app

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
```

### Server Requirements for Production
- **Processor**: Minimal 2 cores, recommended 4+
- **Memory**: Minimal 2GB RAM, recommended 4GB+
- **Storage**: Minimal 10GB free space
- **PHP Extensions**: 
  - PDO (MySQL)
  - OpenSSL
  - Tokenizer
  - Ctype
  - JSON
  - Mbstring

---

## 🆘 Troubleshooting

### Common Issues & Solutions

#### Issue: "Class not found" Error
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Regenerate autoload
composer dump-autoload
```

#### Issue: Database Connection Error
```bash
# Check .env database configuration
# Ensure MySQL server is running
# Test connection:
php artisan tinker
>>> DB::connection()->getPdo();
```

#### Issue: Assets Not Loading
```bash
# Rebuild assets
npm run dev

# Or for production
npm run build

# Clear Laravel cache
php artisan cache:clear
```

#### Issue: Permission Denied on storage/
```bash
# Fix permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# On Windows, ensure write permissions
```

#### Issue: 419 Session Expired
```bash
# Clear sessions
php artisan session:table
php artisan migrate

# Or manually clear
rm -rf storage/framework/sessions/*
```

---

## 📝 Kontribusi

Kami menerima kontribusi untuk meningkatkan proyek. Silakan ikuti langkah-langkah berikut:

1. **Fork** repository
2. **Clone** fork Anda
3. **Create** branch fitur (`git checkout -b feature/AmazingFeature`)
4. **Commit** perubahan (`git commit -m 'Add some AmazingFeature'`)
5. **Push** ke branch (`git push origin feature/AmazingFeature`)
6. **Open** Pull Request

### Kontribusi Guidelines
- Ikuti PSR-12 coding standards
- Tambahkan tests untuk fitur baru
- Update dokumentasi
- Gunakan meaningful commit messages

---

## 📄 Lisensi

Proyek ini dilindungi di bawah lisensi MIT. Lihat file [LICENSE](LICENSE) untuk detail lengkap.

---

## 👥 Tim Pengembang

Proyek ini adalah hasil kolaborasi tim untuk mata kuliah **Cloud Computing - Semester 6**:

| Nama | NIM | Role |
|------|-----|------|
| Satanaya Khan | - | Lead Developer |
| Faris Naufal | - | Full Stack Developer |
| Tim Lainnya | - | Contributors |

### Kontak & Support
- **Issues**: [GitHub Issues](https://github.com/khansatanaya2005-eng/Tubes_CC/issues)
- **Email**: khansatanaya2005@telkom.ac.id

---

## 📚 Resources & Dokumentasi

### Official Documentation
- [Laravel 11 Documentation](https://laravel.com/docs/11.x)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Vite Documentation](https://vitejs.dev/guide/)

### Tutorial & Guides
- [Laravel Best Practices](https://laravel.com/docs/11.x/contributions#code-style)
- [PHP-FIG PSR Standards](https://www.php-fig.org/)

### Tools & References
- [Laravel Artisan Commands](https://laravel.com/docs/11.x/artisan)
- [Eloquent ORM Guide](https://laravel.com/docs/11.x/eloquent)
- [Blade Templating Engine](https://laravel.com/docs/11.x/blade)

---

## 📊 Project Status

- ✅ Initial Setup Completed
- ✅ Database Design & Migration
- ✅ Core Features Implemented
- ⏳ Testing Phase
- ⏳ Optimization & Performance Tuning
- ⏳ Deployment Ready

---

## 🎓 Cloud Computing Implementation

Proyek ini mengimplementasikan konsep-konsep Cloud Computing:

### Scalability
- ✅ Database design yang scalable
- ✅ Stateless application architecture
- ✅ Session management terpisah

### Availability
- ✅ Error handling yang robust
- ✅ Database backup strategy
- ✅ Logging & monitoring

### Security
- ✅ Authentication & Authorization
- ✅ CSRF Protection
- ✅ SQL Injection Prevention
- ✅ XSS Protection
- ✅ Password hashing

### Maintainability
- ✅ Clean code practices
- ✅ Modular architecture
- ✅ Comprehensive documentation
- ✅ Version control with Git

---

**Last Updated**: June 3, 2026  
**Version**: 1.0.0  
**Status**: Active Development

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
