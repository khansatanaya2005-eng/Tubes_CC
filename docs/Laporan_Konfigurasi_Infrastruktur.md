# Laporan Konfigurasi Infrastruktur Cloud
**Proyek:** TraciF Hospitality System

Laporan ini mendokumentasikan langkah-langkah detail dalam melakukan konfigurasi infrastruktur cloud secara _High Availability_ (HA), yang meliputi Web Server, Database Server, dan Load Balancer.

---

## 1. Konfigurasi Web Server

Bagian ini menjelaskan proses setup web server dari tahap penyediaan _Virtual Machine_ hingga aplikasi web berhasil di-deploy.

### 1.1 Proses Pembuatan Instance/Server
Pembuatan _instance_ menggunakan layanan IaaS (contoh: Azure Virtual Machine).
- **Langkah-langkah:**
  1. Buka portal cloud dan navigasi ke menu **Virtual Machines** > **Create**.
  2. Tentukan _Resource Group_, _Region_ (misal: Southeast Asia), dan _Availability Zone_ (untuk redudansi).
  3. Berikan nama instance (misal: `VM-APP-01`).
  4. Pilih image sistem operasi (contoh: **Ubuntu Server 22.04 LTS**).
  5. Pilih spesifikasi _Size_ komputasi yang optimal (misal: `Standard_B2ats_v2`).
  6. Atur metode autentikasi menggunakan _SSH Public Key_ atau _Password_.
  7. Buka _inbound port_ untuk **SSH (22)** agar bisa diremote dan **HTTP (80)** untuk akses web.
  8. Klik **Review + Create** untuk membuat instance.

> **Lokasi Screenshot:** `[Masukkan Screenshot halaman "Overview" pada VM-APP-01 dan VM-APP-02 di Azure Portal yang menampilkan Status "Running", Public IP, dan Size di sini]`

**Penjelasan:** Screenshot di atas membuktikan bahwa dua _instance_ Virtual Machine (VM-APP-01 dan VM-APP-02) telah berhasil dibuat dan saat ini beroperasi normal (_Running_) dengan spesifikasi yang telah ditentukan.

### 1.2 Instalasi dan Konfigurasi Web Server
Akses server yang sudah berjalan untuk menginstal perangkat lunak web server (Nginx) dan PHP.
- **Langkah-langkah:**
  1. Lakukan remote login via SSH (misal: `ssh azureuser@<IP_Public_VM>`).
  2. Perbarui _repository_ sistem operasi: `sudo apt update && sudo apt upgrade -y`.
  3. Instal Nginx dan PHP: `sudo apt install nginx php8.2-fpm php8.2-mysql php8.2-xml php8.2-curl zip unzip curl git -y`.
  4. Konfigurasikan _Server Block_ Nginx (di `/etc/nginx/sites-available/default`) agar merutekan seluruh _request_ HTTP `/` ke direktori web root (`/var/www/tracif/public/index.php`).
  5. Tambahkan _security headers_ Nginx seperti `X-Frame-Options` dan `X-XSS-Protection`.
  6. Terapkan konfigurasi dengan me-restart Nginx: `sudo systemctl restart nginx`.

> **Lokasi Screenshot:** `[Masukkan Screenshot Terminal VM yang menampilkan output status service Nginx (contoh: 'systemctl status nginx') yang sedang aktif/berjalan di sini]`

**Penjelasan:** Tampilan terminal di atas memvalidasi bahwa perangkat lunak _web server_ Nginx telah terinstal dengan benar dan layanan (_service_) sedang aktif melayani permintaan jaringan pada port 80.

### 1.3 Deployment Aplikasi ke Web Server
Proses menempatkan _source code_ dan mengonfigurasi _environment_ aplikasi.
- **Langkah-langkah:**
  1. Pindah ke direktori web server: `cd /var/www/`.
  2. Kloning repositori _source code_ proyek: `sudo git clone <URL_Repository_GitHub> tracif`.
  3. Atur kepemilikan (_ownership_) direktori ke Nginx: `sudo chown -R $USER:www-data /var/www/tracif`.
  4. Masuk ke folder proyek, instal Composer, dan unduh dependensi PHP: `composer install --optimize-autoloader --no-dev`.
  5. Salin template variabel environment: `cp .env.example .env` dan edit nilainya dengan editor teks.
  6. Eksekusi optimasi framework (Laravel cache): `php artisan config:cache` dan `php artisan route:cache`.

> **Lokasi Screenshot:** `[Masukkan Screenshot Terminal VM yang menampilkan isi direktori '/var/www/tracif' (contoh: 'ls -la') untuk membuktikan source code telah ada dan permission-nya benar di sini]`

**Penjelasan:** Direktori proyek telah terisi penuh dengan _source code_ dari repositori, dan seluruh hak akses (_permission_) file telah disesuaikan agar dapat diakses dengan aman oleh *web server* Nginx.

### 1.4 Verifikasi Aplikasi Berjalan
Memastikan layanan web telah dapat menerima permintaan dari _client_ internet.
- **Langkah-langkah:**
  1. Dapatkan alamat IP Publik (_Public IP_) langsung dari VM aplikasi.
  2. Ketikkan IP Publik tersebut di kolom URL browser.
  3. Pastikan halaman _homepage_ (atau halaman _login_ aplikasi) berhasil termuat sepenuhnya tanpa adanya error *502 Bad Gateway* atau *500 Internal Server Error*.

> **Lokasi Screenshot:** `[Masukkan Screenshot Browser yang sedang membuka alamat IP Publik VM-APP-01/VM-APP-02 secara langsung dan menampilkan halaman web aplikasi yang sudah berjalan normal di sini]`

**Penjelasan:** Aplikasi web TraciF telah sukses di-_deploy_ ke dalam _instance_ VM. Pengujian akses secara langsung memvalidasi bahwa aplikasi dan segala pengaturan internalnya bekerja tanpa ada kesalahan teknis (_error_ 500/502).

---

## 2. Konfigurasi Database Server

Aplikasi menggunakan arsitektur _shared database_ menggunakan basis data terkelola (PaaS) agar beberapa Web Server dapat menyimpan dan membaca data di satu titik pusat secara konsisten.

### 2.1 Instalasi Database Server
Penyediaan instance Managed Database Server (contoh: Azure Database for MySQL Flexible Server).
- **Langkah-langkah:**
  1. Pada portal, pilih layanan pembuatan Database Server (seperti **MySQL flexible servers**).
  2. Masukkan nama server (misal: `tracif-mysql-prod`) dan pastikan ia berada di region yang sama dengan VM Web Server agar latensinya rendah.
  3. Pada opsi spesifikasi komputasi/penyimpanan (_Compute & Storage_), pilih _Burstable_ spesifikasi sesuai kebutuhan (misal `B1ms`, storage `20 GiB`).
  4. Konfigurasi pengaturan _Networking_ dan pastikan opsi _Allow public access from Azure services_ diaktifkan agar VM web server bisa terhubung langsung.
  5. Lakukan peninjauan akhir dan klik **Create**.

> **Lokasi Screenshot:** `[Masukkan Screenshot halaman "Overview" pada Azure Database for MySQL yang menampilkan nama server, Status "Available", dan rincian Compute size di sini]`

**Penjelasan:** Instance Azure Database for MySQL Flexible Server telah aktif (_Available_) sebagai basis data terpusat. Infrastruktur ini siap melayani _query_ masuk dari kedua VM Web Server secara aman.

### 2.2 Pembuatan Database dan User Database
- **Langkah-langkah:**
  1. Pada tahap pembuatan Database, tentukan kredensial autentikasi. Masukkan **Administrator login** (misal: `adminuser`) dan **Password** administrator.
  2. Setelah server database berhasil dialokasikan, _schema_ database untuk aplikasi dibuat.
  3. Ini dapat dilakukan secara opsional lewat _cloud shell_ / terminal VM dengan cara me-remote database, lalu mengeksekusi *query*: `CREATE DATABASE tracif_db;`. (Pada Laravel, database ini sering kali otomatis tercipta bila dikonfigurasikan dari kode awal).

> **Lokasi Screenshot:** `[Masukkan Screenshot menu "Databases" pada halaman pengaturan Azure Database for MySQL yang menampilkan daftar database yang telah ada (termasuk 'tracif_db') di sini]`

**Penjelasan:** Skema database `tracif_db` telah berhasil diciptakan pada server database _cloud_. Ruang basis data inilah yang akan murni didedikasikan bagi aplikasi untuk menyimpan seluruh data operasionalnya.

### 2.3 Konfigurasi Koneksi antara Aplikasi dan Database
Menautkan aplikasi web ke instance _database cloud_ baru.
- **Langkah-langkah:**
  1. Di VM Web Server, edit kembali file _environment_ (`nano /var/www/tracif/.env`).
  2. Konfigurasikan kredensial koneksi database sebagai berikut:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=tracif-mysql-prod.mysql.database.azure.com
     DB_PORT=3306
     DB_DATABASE=tracif_db
     DB_USERNAME=adminuser
     DB_PASSWORD=<Password_Administrator_Database>
     ```
  3. Simpan perubahan file dan bersihkan *config cache* (`php artisan config:clear`).

> **Lokasi Screenshot:** `[Masukkan Screenshot Terminal yang menampilkan sebagian isi file .env (contoh: 'cat .env | grep DB_') untuk menunjukkan bahwa koneksi DB_HOST sudah diarahkan ke cloud MySQL di sini]`

**Penjelasan:** Konfigurasi _environment_ pada aplikasi web (`.env`) berhasil disesuaikan. Aplikasi tidak lagi merujuk ke database lokal, melainkan langsung ke alamat jaringan Database Server Azure.

### 2.4 Pengujian Koneksi Database
- **Langkah-langkah:**
  1. Di dalam terminal VM Web Server, eksekusi perintah migrasi tabel: `php artisan migrate --force`.
  2. Jika ada _seed data_ (data awal wajib), jalankan: `php artisan db:seed --force`.
  3. Bila koneksi sukses, terminal akan menampilkan konfirmasi tabel-tabel (_migrations_) yang berhasil dibuat. Jika gagal, akan muncul *Timeout* / *Connection Refused*.
  4. Coba lakukan pendaftaran *user* baru melalui web browser. Jika data *user* tersimpan, database sudah berfungsi optimal.

> **Lokasi Screenshot:** `[Masukkan Screenshot Terminal saat menjalankan perintah 'php artisan migrate:status' yang menampilkan tabel-tabel database dengan status "Ran" (sudah dimigrasi) di sini]`

**Penjelasan:** Hasil dari perintah _migrate status_ membuktikan bahwa struktur tabel aplikasi berhasil dieksekusi masuk ke database cloud, yang secara otomatis memvalidasi bahwa VM memiliki hak akses penuh ke Database Server tanpa isu jaringan.

---

## 3. Konfigurasi Load Balancer

Load Balancer difungsikan sebagai _Single Point of Contact_ (gerbang masuk utama) bagi trafik user internet, untuk kemudian mendistribusikan trafik tersebut ke _backend_ web server (`VM-APP-01` dan `VM-APP-02`).

### 3.1 Proses Pembuatan Load Balancer
- **Langkah-langkah:**
  1. Pada portal cloud, cari layanan **Load Balancers** > **Create**.
  2. Tentukan _Region_ yang persis sama dengan region VM dan Database.
  3. Tetapkan _SKU_ sebagai **Standard** dan _Type_ sebagai **Public**.
  4. Di menu **Frontend IP Configuration**, tambahkan _Frontend IP_ baru. Buat sebuah statis _Public IP Address_ baru yang berlabel _Zone-Redundant_. Alamat IP ini yang akan dipetakan ke _Domain Name_ publik aplikasi nantinya.

> **Lokasi Screenshot:** `[Masukkan Screenshot halaman "Frontend IP configuration" pada panel Load Balancer yang menampilkan IP Publik utamanya di sini]`

**Penjelasan:** Load Balancer telah memiliki **Frontend IP Configuration** statis. Alamat IP ini sekarang berfungsi sebagai pintu gerbang (*single point of entry*) satu-satunya untuk semua trafik klien (*user*) ke aplikasi.

### 3.2 Daftar Backend Server yang Digunakan
Mendaftarkan target tujuan lalu lintas web.
- **Langkah-langkah:**
  1. Masuk ke halaman pengelolaan Load Balancer yang telah terbentuk.
  2. Navigasi ke **Backend pools** > Klik **Add**.
  3. Masukkan nama pool (misal: `BackendPool-TraciF`) dan pilih _Virtual Network_ infrastruktur proyek.
  4. Pada opsi target _IP Configurations_ (NIC), klik **Add** lalu tandai (centang) instance `VM-APP-01` dan `VM-APP-02`.
  5. Simpan pengaturan. Kini Load Balancer telah terikat dengan dua web server sekaligus.

> **Lokasi Screenshot:** `[Masukkan Screenshot halaman "Backend pools" pada Load Balancer yang memperlihatkan list VM-APP-01 dan VM-APP-02 telah berada di dalamnya dan berstatus sehat/running di sini]`

**Penjelasan:** _Backend pool_ sudah menampung dan mengonfirmasi keberadaan `VM-APP-01` dan `VM-APP-02`. Load Balancer telah sukses menghubungkan dirinya ke _interface_ jaringan kedua server tersebut.

### 3.3 Konfigurasi Routing dan Distribusi Trafik ke Backend Server
Membuat aturan bagaimana pembagian trafik (HTTP) terjadi.
- **Langkah-langkah:**
  1. Masuk ke menu **Load balancing rules** > **Add**.
  2. Pilih _Frontend IP Address_ dan _Backend pool_ yang baru dibuat tadi.
  3. Atur agar protokol **TCP**, **Port Frontend: 80**, dan **Backend port: 80**.
  4. Buat dan atur **Health Probe** (Pengecekan Kesehatan). Konfigurasikan agar Load Balancer secara otomatis *ping* target setiap 5 detik ke Port 80 (HTTP). Jika web server mati, trafik akan dihentikan sementara ke server tersebut.
  5. Atur _Session persistence_ ke `None` agar setiap koneksi *refresh* didistribusikan secara dinamis.
  6. Klik **Save** untuk menerapkan peraturan.

> **Lokasi Screenshot:** `[Masukkan Screenshot halaman "Load balancing rules" pada Load Balancer yang menampilkan daftar rule (contoh: rule HTTP port 80) beserta Health Probe yang digunakan di sini]`

**Penjelasan:** Peraturan load balancing (*rule*) untuk merutekan port 80 HTTP telah diterapkan, lengkap bersamaan dengan mekanisme pengawasan *Health Probe*. Trafik siap didistribusikan secara dinamis.

### 3.4 Pengujian Load Balancing
Menguji distribusi merata dan sistem cadangan otomatis (_failover_).
- **Langkah-langkah:**
  1. *Uji Distribusi Trafik:* Akses Alamat IP Publik Load Balancer melalui _web browser_. Jika terdapat _banner_ / _hostname variable_ visual pada aplikasi, lakukan _hard refresh_ (Ctrl+F5) berulang kali untuk memastikan tampilan berasal dari web server yang berbeda (berpindah antara `VM-APP-01` dan `VM-APP-02`).
  2. *Uji Failover:* Dari sisi portal cloud, lakukan penonaktifan paksa (opsi **Stop**) pada `VM-APP-01`.
  3. Pada _browser_, lakukan _refresh_ aplikasi web. Situs harus tetap termuat normal karena trafik secara otomatis seluruhnya dilemparkan (*failover*) ke `VM-APP-02` yang masih aktif berkat deteksi _Health Probe_.

> **Lokasi Screenshot:** `[Masukkan Screenshot Browser yang mengakses IP Load Balancer BERDAMPINGAN dengan layar Azure Portal yang menunjukkan salah satu VM sengaja dimatikan (Status: Stopped), namun web tetap bisa diakses di sini]`

**Penjelasan:** Pengujian _failover_ berhasil secara sempurna. Mematikan paksa salah satu VM (_node down_) tidak menyebabkan _downtime_ bagi pengguna karena Load Balancer seketika mendeteksi kegagalan tersebut dan merutekan seluruh _request_ pengguna ke VM cadangan yang masih aktif. Tujuan penerapan _High Availability_ tercapai.
