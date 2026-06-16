<div align="center">
  <img src="public/images/tracif-logo.png" alt="TraciF Logo" width="150"/>
  <h1>TraciF Hospitality System</h1>
  <p><strong>Aplikasi Manajemen Restoran Berbasis Cloud Terintegrasi</strong></p>

  <p>
    <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 11">
    <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php" alt="PHP 8.2+">
    <img src="https://img.shields.io/badge/MySQL-8.0-005C87?style=for-the-badge&logo=mysql" alt="MySQL 8.0">
    <img src="https://img.shields.io/badge/Microsoft_Azure-0089D6?style=for-the-badge&logo=microsoft-azure&logoColor=white" alt="Azure">
    <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  </p>
</div>

---

## 📖 Tentang Proyek

**TraciF Hospitality System** adalah aplikasi manajemen restoran modern yang difungsikan untuk mempermudah operasional F&B. Aplikasi ini mendukung input pesanan pelanggan, monitoring grafik penjualan secara _real-time_, dan pengelolaan pembayaran secara online. Proyek ini di-hosting menggunakan arsitektur *High Availability* di Microsoft Azure.

---

## 🚀 Fitur Utama

- **Katalog Menu Digital**: Katalog produk/menu makanan dan minuman untuk pelanggan.
- **Sistem Pemesanan Mandiri (Direct Ordering)**: Memungkinkan pelanggan melakukan _checkout_ langsung dari aplikasi.
- **Dashboard Analitik & Monitoring**: Grafik interaktif performa penjualan dan pesanan untuk pengelola restoran.
- **Manajemen Produk (Menu)**: Admin dapat menambahkan, mengubah, atau menghapus menu.
- **Order Tracking**: Pemantauan status pesanan secara *real-time* (Pending, Processing, Completed).
- **Manajemen Pelanggan**: Basis data pelanggan yang terpusat.
- **Laporan Penjualan**: Rekapitulasi transaksi dan pendapatan untuk restoran.

---

## 🛠️ Komponen Teknologi

| Komponen | Keterangan |
|----------|------------|
| **Frontend** | HTML, CSS, JavaScript (Tailwind CSS, Alpine.js, Blade) |
| **Backend** | PHP Laravel 11.x |
| **Database** | MySQL |
| **Web Server** | Nginx + PHP-FPM |
| **Platform Cloud** | Microsoft Azure |

---

## ☁️ Arsitektur Infrastruktur Cloud (Azure)

TraciF dirancang menggunakan pendekatan _Highly Available_ (HA) dengan mendistribusikan beban kerja secara seimbang ke beberapa server menggunakan arsitektur berikut:
1. **Load Balancer**: Azure Standard Public Load Balancer sebagai pintu masuk utama yang mendistribusikan trafik HTTP.
2. **Web Server (Compute)**: 2x Virtual Machine (VM-APP-01 & VM-APP-02) berbasis Ubuntu 22.04 LTS yang menjalankan Nginx dan PHP-FPM.
3. **Database Server**: Azure Database for MySQL Flexible Server yang bertindak sebagai _shared database_ agar semua transaksi tersinkronisasi.

> [!NOTE]  
> Laporan lengkap tentang konfigurasi arsitektur cloud, _load balancing_, dan cara menduplikasi infrastruktur ini tersedia di [Laporan Konfigurasi Infrastruktur Cloud](docs/Laporan_Konfigurasi_Infrastruktur.md).

---

## 📁 Struktur Direktori Proyek

Proyek ini dibangun di atas _framework_ Laravel dengan struktur hierarki standar berikut:

```text
tracif/
├── app/                  # Berisi core logic aplikasi (Controllers, Models, Middleware)
├── bootstrap/            # Skrip pemuat awal (_bootstrapping_) aplikasi
├── config/               # File konfigurasi global aplikasi
├── database/             # File Migrations (skema tabel) dan Seeders (data dummy awal)
├── docs/                 # Berisi laporan praktikum dan panduan deployment (Markdown)
├── public/               # Aset yang dapat diakses publik (gambar, CSS ter-build, JS, index.php)
├── resources/            # Berisi _views_ (Blade templates) dan _raw assets_ (Tailwind CSS/JS)
├── routes/               # Berisi definisi rute URL/endpoint aplikasi (web.php)
├── storage/              # Tempat penyimpanan log, *cache* framework, dan file unggahan pengguna
├── .env.example          # Template file environment (variabel sistem)
├── artisan               # *Command-line interface* (CLI) bawaan Laravel
├── composer.json         # Konfigurasi dan daftar dependensi *backend* (PHP)
├── package.json          # Konfigurasi dan daftar dependensi *frontend* (NPM)
└── README.md             # File dokumentasi utama ini
```

---

## 💻 Instalasi Lokal (Development)

Jika Anda ingin menjalankan aplikasi ini di komputer lokal, jalankan perintah berikut:

```bash
# 1. Clone repository
git clone https://github.com/khansatanaya2005-eng/Tubes_CC.git tracif
cd tracif

# 2. Install dependensi backend
composer install

# 3. Copy file environment dan atur koneksi DB Anda
cp .env.example .env

# 4. Generate Application Key
php artisan key:generate

# 5. Link folder storage
php artisan storage:link

# 6. Install dependensi frontend & build
npm install
npm run build

# 7. Jalankan migrasi dan seeder database
php artisan migrate --seed

# 8. Jalankan server lokal
php artisan serve
```

---

## 👥 Tim Pengembang (Kelompok CC)

Aplikasi dan infrastruktur ini dibangun oleh:

| Nama | Peran |
|------|-------|
| Satanaya Khan | Lead Developer / Cloud Architect |
| Faris Naufal | Senior Full Stack Developer |

---
