# TraciF - Azure Student Optimized Deployment Guide
**[Enterprise Architecture - Cost Optimized Edition]**

This guide provides a step-by-step procedure to deploy the **TraciF Premium Hospitality System** using an Enterprise IaaS architecture (Load Balancer + 2 VMs + Shared Database) while remaining strictly within the **$100 Azure for Students credit limit**.

---

## 1. Prerequisites
- **Azure for Students** subscription active.
- Access to Azure Portal.
- SSH client (Terminal/PuTTY).
- TraciF GitHub Repository.

---

## 2. Infrastructure Setup (UI Steps)

### 2.1 Resource Group & Networking
1. Go to **Resource Groups** > Create.
   - Name: `RG-TRACIF-PROD`
   - Region: `Southeast Asia`
2. Go to **Virtual Networks** > Create.
   - Name: `VNet-TraciF`
   - Subnets: Create `Subnet-App` (10.0.1.0/24) and `Subnet-DB` (10.0.2.0/24).

### 2.2 Shared Database (Azure MySQL Flexible Server)
*Cost Optimization: B1ms compute, 20 GiB storage, no HA.*
1. Go to **Azure Database for MySQL flexible servers** > Create.
2. **Project details**:
   - **Subscription**: Azure for Students
   - **Resource group**: `RG-TRACIF-PROD`
3. **Server details**:
   - **Server name**: `tracif-mysql-prod`
   - **Region**: `Southeast Asia`
   - **Availability zone**: `No preference`
4. **Authentication**:
   - **Administrator login**: `adminuser`
   - **Password**: `TraciF!Secret123`
5. **Workload details**:
   - **Workload type**: `Development` (This quickly configures the server for cost savings).
   - **Compute + storage**: `Burstable, Standard_B1ms`, `20 GiB` storage.
   - **High availability**: Unchecked / None (Do not enable).
6. **Backup configuration**:
   - **Backup redundancy option**: `Locally-redundant` (Ensure Geo-redundancy is unchecked).
7. **Networking**:
   - Allow public access from Azure services (for VMs to connect).

### 2.3 Virtual Machines (VM-APP-01 & VM-APP-02)
*Cost Optimization: B1s sizes, Standard HDD/SSD, Auto-shutdown.*
1. Go to **Virtual Machines** > Create.
2. **Basics**:
   - Name: `VM-APP-01`
   - Region: `Southeast Asia` (Availability Zone 1)
   - Image: `Ubuntu Server 22.04 LTS`
   - Size: `Standard_B1s`
   - Authentication: SSH Public Key or Password.
3. **Disks**: `Standard SSD` (Avoid Premium SSD).
4. **Networking**: Select `VNet-TraciF` > `Subnet-App`.
5. **Management**: **Enable Auto-shutdown** at `22:00` (Timezone: `Asia/Jakarta`).
6. Repeat steps to create `VM-APP-02` in Availability Zone 2.

### 2.4 Azure Load Balancer
1. Go to **Load Balancers** > Create.
2. Name: `LB-TRACIF-PROD`, Type: `Public`, SKU: `Standard`.
3. **Frontend IP**: Create new public IP.
4. **Backend Pool**: Add `VM-APP-01` and `VM-APP-02`.
5. **Health Probe**: Port `80`, Protocol `TCP`, Interval `5s`.
6. **Load Balancing Rule**: Forward Port 80 to Backend Port 80.

---

## 3. Server Configuration & Production Hardening (SSH)

SSH into `VM-APP-01` and run the following. (Repeat for `VM-APP-02` EXCEPT the database migration step).

### 3.1 Install Dependencies
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install software-properties-common curl git unzip -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install nginx php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip supervisor -y
```

### 3.2 Setup TraciF
```bash
cd /var/www/
sudo git clone https://github.com/YOUR-ORG/TraciF.git tracif
sudo chown -R $USER:www-data /var/www/tracif
cd tracif
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
composer install --optimize-autoloader --no-dev
cp .env.example .env
nano .env
```
*(Set DB_HOST to `tracif-mysql-prod.mysql.database.azure.com`, setup APP_URL to LB IP).*

### 3.3 Production Hardening
**Laravel Optimization:**
```bash
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
**(VM-APP-01 ONLY) Migrate Database:**
```bash
php artisan migrate --force
php artisan db:seed --force
```

**Nginx Configuration:**
Configure `/etc/nginx/sites-available/default` with secure headers:
```nginx
server {
    listen 80;
    root /var/www/tracif/public;
    index index.php index.html;
    
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";
    
    location / { try_files $uri $uri/ /index.php?$query_string; }
    location ~ \.php$ { include snippets/fastcgi-php.conf; fastcgi_pass unix:/var/run/php/php8.2-fpm.sock; }
}
```
Restart Nginx: `sudo systemctl restart nginx`

**Supervisor (Queue Workers):**
Create `/etc/supervisor/conf.d/tracif-worker.conf`:
```ini
[program:tracif-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/tracif/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
```
Start Supervisor: `sudo supervisorctl reread && sudo supervisorctl update && sudo supervisorctl start tracif-worker:*`

---

## 4. Security Hardening (NSG)

1. Go to the Network Security Groups (NSG) attached to your VMs.
2. **Restrict SSH (Port 22)**: Change Source from `Any` to `Your IP Address`.
3. **HTTP (Port 80)**: Allow from `Internet` (or restrict to Load Balancer IP if preferred).
4. **MySQL (Port 3306)**: The DB is already isolated to Azure internal services.

> [!SUCCESS]
> **Deployment Complete.** The infrastructure is now highly available, production-hardened, and cost-optimized for Azure Students.
