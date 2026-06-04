# Panduan Lengkap Deployment TraciF - Azure IaaS (VM & Load Balancer)
**[Edisi Khusus: Azure for Students]**

Dokumen ini adalah panduan langkah demi langkah berbasis **UI Azure Portal** untuk membangun arsitektur IaaS (*Infrastructure as a Service*) yang tangguh untuk **TraciF Premium Hospitality System**. 

Arsitektur ini menggunakan **2 Virtual Machines (VM)** yang dihubungkan melalui **Azure Load Balancer** untuk *High Availability*, serta 1 **Shared Database** menggunakan Azure Database for MySQL. 

Semua langkah disesuaikan dengan batasan dan *benefit* dari langganan **Azure for Students** (memanfaatkan *instance* B1s yang gratis/murah).

---

## 1. Persiapan Awal (Prasyarat)
1. Langganan **Azure for Students** yang aktif.
2. Kode sumber TraciF sudah di-*push* ke **GitHub** (Publik, atau jika Privat, siapkan Personal Access Token).
3. **Terminal** di laptop Anda (Command Prompt / PowerShell di Windows, atau Terminal di Mac/Linux) untuk *remote SSH*.

---

## 2. Membuat Resource Group & Virtual Network
Kita harus membuat wadah utama jaringan agar VM dan Database bisa saling berkomunikasi dengan aman.

1. Buka [Azure Portal](https://portal.azure.com).
2. Cari dan pilih **Resource groups** > klik **+ Create**.
   - **Subscription**: Azure for Students
   - **Resource group**: `TraciF-RG`
   - **Region**: `Southeast Asia` (Sangat disarankan karena dekat dengan Indonesia).
   - Klik **Review + create** > **Create**.
3. Cari dan pilih **Virtual networks** > klik **+ Create**.
   - **Resource group**: Pilih `TraciF-RG`.
   - **Name**: `TraciF-VNet`.
   - **Region**: `Southeast Asia`.
   - Tab *IP Addresses*: Biarkan *default* (biasanya `10.0.0.0/16` dengan subnet `default` `10.0.0.0/24`).
   - Klik **Review + create** > **Create**.

---

## 3. Membuat Shared Database (MySQL Flexible Server)
Karena kita akan menggunakan 2 VM, aplikasi *tidak boleh* menyimpan *database* di dalam VM itu sendiri (jika tidak, data VM1 dan VM2 akan berbeda). Kita menggunakan *database* terpusat.

1. Cari **Azure Database for MySQL flexible servers** > klik **+ Create**.
2. Tab **Basics**:
   - **Resource group**: `TraciF-RG`.
   - **Server name**: `tracif-db-server` (harus unik sedunia).
   - **Region**: `Southeast Asia`.
   - **MySQL version**: `8.0`.
   - **Workload type**: Pilih `Development` (agar bisa memilih spesifikasi rendah).
   - **Compute + storage**: Klik *Configure server*, pilih *Burstable* `B1ms` (sangat direkomendasikan untuk Azure for Students agar kredit awet).
   - **Admin username**: `adminuser`
   - **Password**: `TraciF!Secret123` (Catat kredensial ini baik-baik).
3. Tab **Networking**:
   - **Network connectivity**: Pilih *Public access (allowed IP addresses)*.
   - Centang **"Allow public access from any Azure service within Azure to this server"**. (Sangat krusial agar VM bisa terhubung).
4. Klik **Review + create** > **Create** (Tunggu 5-10 menit).
5. Setelah jadi, buka *server* tersebut, masuk ke menu **Databases** (kiri), klik **+ Add**, beri nama `tracif_db`, lalu Save.

---

## 4. Membuat Virtual Machine (VM1 dan VM2)

Kita akan membuat VM1 terlebih dahulu. Setelah selesai, **ulangi langkah yang persis sama** untuk membuat VM2 (hanya bedakan namanya menjadi `TraciF-VM2`).

1. Cari **Virtual machines** > klik **+ Create** > **Azure virtual machine**.
2. Tab **Basics**:
   - **Resource group**: `TraciF-RG`.
   - **Virtual machine name**: `TraciF-VM1` (Nanti untuk VM kedua, isi `TraciF-VM2`).
   - **Region**: `Southeast Asia`.
   - **Availability options**: Pilih `Availability zone`. Centang Zone `1` (Untuk VM2 nanti, centang Zone `2` agar jika satu pusat data mati, aplikasi tetap hidup).
   - **Security type**: `Standard`.
   - **Image**: `Ubuntu Server 22.04 LTS - x64 Gen2`.
   - **Size**: Pilih `Standard_B1s` (Gratis/sangat murah untuk Azure for Students).
   - **Authentication type**: `Password` (Untuk kemudahan saat ini, meski SSH Key lebih aman).
   - **Username**: `azureuser`
   - **Password**: `TraciF!Admin123`
   - **Public inbound ports**: Pilih `Allow selected ports`.
   - **Select inbound ports**: Centang **HTTP (80)** dan **SSH (22)**.
3. Tab **Networking**:
   - Pastikan **Virtual network** memilih `TraciF-VNet` yang dibuat di langkah 2.
4. Klik **Review + create** > **Create**. Tunggu hingga VM siap. 
5. Buka halaman *Overview* VM tersebut, **catat Public IP Address**-nya.
6. **[PENTING]** Ulangi Langkah 4 ini untuk membuat **TraciF-VM2**.

---

## 5. Konfigurasi VM via Terminal (Remote SSH)
Kita akan menyetel lingkungan Laravel secara identik di VM1 dan VM2 melalui terminal jarak jauh (*remote terminal*).

Buka terminal di komputer Anda (Command Prompt / PowerShell / Terminal Mac) dan hubungkan ke VM1:
```bash
ssh azureuser@<IP_PUBLIC_VM1>
```
*(Masukkan password `TraciF!Admin123` saat diminta. Teks tidak akan muncul saat diketik).*

Setelah masuk ke dalam Ubuntu di Azure, jalankan instalasi berurutan ini:

### 5.1. Install Web Server & PHP 8.2
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install software-properties-common curl -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install nginx git unzip -y
sudo apt install php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip -y
```

### 5.2. Install Composer
```bash
curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

### 5.3. Clone Repository TraciF
```bash
cd /var/www/
sudo git clone https://github.com/USERNAME/REPO_TRACIF.git tracif
cd tracif

# Atur perizinan agar Nginx bisa membaca dan menulis
sudo chown -R $USER:www-data /var/www/tracif
sudo find /var/www/tracif -type f -exec chmod 664 {} \;
sudo find /var/www/tracif -type d -exec chmod 775 {} \;
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
```

### 5.4. Setup Environment (.env) & Database
```bash
cp .env.example .env
nano .env
```
Ubah pengaturan *database* di dalam file `.env` mengarah ke Azure MySQL:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=http://<IP_PUBLIC_VM1>

DB_CONNECTION=mysql
DB_HOST=tracif-db-server.mysql.database.azure.com
DB_PORT=3306
DB_DATABASE=tracif_db
DB_USERNAME=adminuser
DB_PASSWORD=TraciF!Secret123
```
Simpan (Ctrl+O, Enter, Ctrl+X). Lanjutkan dengan instalasi Laravel:
```bash
composer install --optimize-autoloader --no-dev
php artisan key:generate
php artisan optimize:clear
```
**[HANYA DI VM1]** Jalankan migrasi:
```bash
php artisan migrate --force
php artisan db:seed --force
```
*(Jangan jalankan migrasi di VM2 karena database-nya sama/berbagi dengan VM1).*

### 5.5. Konfigurasi Nginx
```bash
sudo nano /etc/nginx/sites-available/tracif
```
Masukkan konfigurasi berikut:
```nginx
server {
    listen 80;
    server_name _;
    root /var/www/tracif/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```
Aktifkan konfigurasi dan *restart* Nginx:
```bash
sudo ln -s /etc/nginx/sites-available/tracif /etc/nginx/sites-enabled/
sudo unlink /etc/nginx/sites-enabled/default
sudo systemctl restart nginx
exit
```

> [!IMPORTANT]
> **ULANGI** seluruh Langkah 5 ini untuk **VM2** (`ssh azureuser@<IP_PUBLIC_VM2>`). Ingat, abaikan bagian `php artisan migrate` di VM2.

---

## 6. Setup Azure Load Balancer
Saat ini Anda punya dua VM yang bisa diakses dari IP masing-masing. Load Balancer akan menyatukan mereka dalam satu IP.

1. Cari **Load balancers** di Azure Portal > klik **+ Create**.
2. Tab **Basics**:
   - **Resource group**: `TraciF-RG`.
   - **Name**: `TraciF-LB`.
   - **Region**: `Southeast Asia`.
   - **Type**: `Public`.
   - **Tier**: `Regional`.
   - **SKU**: `Standard`.
3. Tab **Frontend IP configuration**:
   - Klik **+ Add a frontend IP configuration**.
   - **Name**: `LoadBalancerFrontEnd`.
   - **Public IP address**: Klik *Create new*, beri nama `TraciF-LB-IP`.
   - Klik **Add**.
4. Klik **Review + create** > **Create**.

Setelah Load Balancer jadi, buka *resource* tersebut untuk melakukan konfigurasi lanjutan:

### 6.1. Backend Pools (Menambahkan VM)
1. Di menu Load Balancer kiri, klik **Backend pools** > **+ Add**.
2. **Name**: `TraciF-BackendPool`.
3. **Virtual network**: Pilih `TraciF-VNet`.
4. Di bagian *IP Configurations*, klik **+ Add**. Pilih `TraciF-VM1` dan `TraciF-VM2`.
5. Klik **Save**.

### 6.2. Health Probes (Pengecek Kesehatan VM)
Load Balancer perlu tahu apakah VM Anda hidup atau mati agar tidak mengirim *traffic* ke VM yang mati.
1. Di menu kiri, klik **Health probes** > **+ Add**.
2. **Name**: `TraciF-HealthProbe`.
3. **Protocol**: `TCP`.
4. **Port**: `80`.
5. **Interval**: `5` (detik).
6. Klik **Save**.

### 6.3. Load Balancing Rules (Aturan Distribusi)
1. Di menu kiri, klik **Load balancing rules** > **+ Add**.
2. **Name**: `TraciF-LBRule`.
3. **IP Version**: `IPv4`.
4. **Frontend IP address**: Pilih `LoadBalancerFrontEnd` yang tadi dibuat.
5. **Backend pool**: Pilih `TraciF-BackendPool`.
6. **Protocol**: `TCP`, **Port**: `80`, **Backend port**: `80`.
7. **Health probe**: Pilih `TraciF-HealthProbe`.
8. Klik **Save**.

---

## 7. Pengujian (Failover & High Availability)
Sistem *Enterprise* TraciF kini telah mengudara dengan keamanan IaaS.

1. Buka Load Balancer (`TraciF-LB`) di Azure Portal. Catat **Public IP Address**-nya di halaman *Overview*.
2. Buka IP tersebut di *browser* (misal: `http://123.45.67.89`). Halaman **TraciF** harus terbuka dengan sempurna. Anda kini mengakses salah satu VM secara otomatis.
3. **Failover Test (Uji Ketangguhan)**:
   - Buka menu **Virtual machines**, klik `TraciF-VM1`, lalu klik tombol **Stop**. Tunggu hingga statusnya *Stopped*.
   - Segarkan (*Refresh*) halaman `http://123.45.67.89` di *browser* Anda.
   - Aplikasi TraciF **harus tetap hidup**! Load Balancer telah mengarahkan Anda ke `TraciF-VM2` secara otomatis karena mendeteksi VM1 sedang *down*.

> [!SUCCESS]
> **SELESAI!** Arsitektur IaaS Anda kini setara dengan standar perhotelan premium (Enterprise). Memiliki performa tinggi, toleransi kesalahan (*fault-tolerant*), dan beban yang terdistribusi sempurna.
