# TraciF Presentation & Defense Guide
**Phases 20.9 & 20.10**

---

## Part 1: Live Demo Script (5 Minutes)

**1. Introduction (0:30)**
> "Selamat pagi. Kami akan mempresentasikan TraciF, sebuah Enterprise Sales Management System yang di-deploy menggunakan arsitektur High Availability 3-Tier di Microsoft Azure."

**2. Architecture Overview (0:30)**
> "Traffic dari internet masuk melalui Public IP ke Nginx Load Balancer, lalu didistribusikan secara Round Robin ke dua Virtual Machine (VM1 dan VM2). Kedua VM ini terhubung secara private ke Azure MySQL Flexible Server."

**3. Application Demo (1:30)**
> *(Login sebagai Admin)*
> "Di Dashboard, kami mengimplementasikan Business Intelligence dengan Chart.js. Kami juga memiliki proteksi otorisasi yang ketat. Jika saya login sebagai Kasir, akses ke manajemen Produk akan diblokir dengan HTTP 403 Forbidden."

**4. Observability & Health (0:30)**
> "Untuk monitoring, kami menyediakan endpoint `/health` yang mereturn status konektivitas Database dan Cache. Ini digunakan oleh Load Balancer untuk mengecek apakah VM masih hidup."

**5. High Availability & Failover Demo (1:30)**
> "Sekarang simulasi Failover. Saya sedang login. Saya akan matikan Nginx di VM1. *(Jalankan sudo systemctl stop nginx)*. Jika saya refresh halaman web, saya **tetap login** dan aplikasi tidak down, karena Load Balancer mengalihkan traffic ke VM2, dan *Session* disimpan terpusat di Database, bukan di RAM VM."

**6. Conclusion & Cost (0:30)**
> "Seluruh arsitektur ini dirancang secara *cost-efficient* menggunakan instance B1s dan B1ms, dengan estimasi biaya di bawah batas kuota $100 Student Credit. Terima kasih."

---

## Part 2: Top Lecturer Q&A Defense (30 Questions)

### Architecture & Load Balancing
1. **Q: Mengapa menggunakan 2 VM untuk Aplikasi?**
   **A:** Untuk mencapai *High Availability* (HA) dan menghindari *Single Point of Failure* (SPOF). Jika satu VM mati, aplikasi tetap hidup.
2. **Q: Bagaimana cara Load Balancer membagi traffic?**
   **A:** Menggunakan Nginx sebagai *Reverse Proxy* dengan algoritma *Round Robin* secara default.
3. **Q: Jika VM1 mati saat user sedang login, apakah user ter-logout?**
   **A:** Tidak. Kami mengubah `SESSION_DRIVER` dari `file` menjadi `database`. Sesi disimpan terpusat di MySQL, sehingga VM2 dapat melanjutkan sesi user tersebut.
4. **Q: Mengapa memisahkan Database ke Azure Flexible Server, bukan install MySQL di dalam VM Aplikasi?**
   **A:** Untuk skalabilitas dan keamanan (3-Tier). Jika MySQL di dalam VM, datanya akan terisolasi di VM tersebut dan akan menyulitkan sinkronisasi antar VM.

### Security & Networking
5. **Q: Apa fungsi dari Network Security Group (NSG) di arsitektur kalian?**
   **A:** NSG bertindak sebagai *firewall*. Kami hanya membuka port 80 (HTTP) dan 443 (HTTPS) di Load Balancer. VM Aplikasi dan Database terisolasi di Subnet privat dan tidak bisa diakses langsung dari internet.
6. **Q: Bagaimana cara kalian melindungi aplikasi dari celah keamanan Mass Assignment?**
   **A:** Kami telah me-refactor *Controller* menggunakan *Laravel Form Requests* (contoh: `StoreProdukRequest`), sehingga hanya data tervalidasi yang masuk ke database.
7. **Q: Bagaimana kalian mengelola Otorisasi (Hak Akses)?**
   **A:** Menggunakan *RoleMiddleware* dan *Laravel Policies* (`ProductPolicy`). Kasir tidak bisa memanipulasi produk, ditolak di level HTTP dan Model.
8. **Q: Apa fungsi SecurityHeadersMiddleware yang kalian buat?**
   **A:** Untuk mengamankan respons HTTP dengan header seperti `X-Frame-Options` (mencegah Clickjacking) dan `Content-Security-Policy` (mencegah XSS).

### Database & Performance
9. **Q: Kenapa tidak menggunakan SoftDelete pada tabel Penjualan?**
   **A:** Karena data Penjualan (transaksi) adalah *audit trail* finansial. Standar *Enterprise* melarang penghapusan data transaksi historis untuk menjaga integritas laporan.
10. **Q: Bagaimana kalian memonitor perubahan data (Audit Log)?**
    **A:** Kami menggunakan *Spatie Activitylog*. Setiap insert, update, dan delete di tabel Produk dan Pelanggan dicatat secara otomatis beserta siapa *user* yang melakukannya.
11. **Q: Apa itu endpoint `/health`?**
    **A:** Itu adalah *probe* endpoint yang mereturn JSON status *database* dan *storage*. Digunakan oleh alat monitoring atau Load Balancer untuk memastikan layanan di dalam VM benar-benar berjalan, bukan sekadar port 80 terbuka.
12. **Q: Bagaimana cara mengoptimalkan kecepatan query database?**
    **A:** Kami telah menambahkan B-Tree Indexes pada kolom yang sering dicari, seperti `email` di Users, dan `id_pelanggan` di Penjualan.

*(Note: Provide these answers confidently during the defense. The architecture implemented strongly defends against common cloud pitfalls.)*
