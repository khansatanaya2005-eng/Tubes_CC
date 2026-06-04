<div align="center">
  <img src="public/images/tracif-logo.png" alt="TraciF Logo" width="150"/>
  <h1>TraciF</h1>
  <p><strong>Enterprise Cloud-Native Sales Management System</strong></p>

  <p>
    <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 11">
    <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php" alt="PHP 8.2+">
    <img src="https://img.shields.io/badge/MySQL-8.0-005C87?style=for-the-badge&logo=mysql" alt="MySQL 8.0">
    <img src="https://img.shields.io/badge/Microsoft_Azure-0089D6?style=for-the-badge&logo=microsoft-azure&logoColor=white" alt="Azure">
    <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  </p>
</div>

---

## 📖 Master Documentation
> [!IMPORTANT]
> This README provides a quick overview. For the **Complete Enterprise Transformation Report**, including Azure Architecture, Nginx Configurations, Security Assessments, Cost Optimizations, and DevOps Planning, please see:
> 👉 **[TraciF Enterprise Report](docs/TraciF_Enterprise_Report.md)**

---

## 1. Project Overview

**TraciF** is an enterprise-grade Point of Sale (POS) and Customer Relationship Management (CRM) system designed for retail and wholesale businesses. It enables real-time transaction tracking, fast-moving inventory management, and centralized customer history logging. Engineered for the Cloud, it features a highly available architecture designed for Microsoft Azure.

## 2. Features

- **RBAC Authentication**: Secure role-based access control.
- **Inventory Management**: Product cataloging with image uploads.
- **CRM Database**: Centralized customer tracking.
- **Point of Sale (POS)**: Internal shopping cart and checkout system.
- **Real-Time Notifications**: In-app alerts for new transactions.
- **Visual Analytics**: Interactive performance dashboard.

## 3. Technology Stack

- **Backend**: Laravel 11.x, PHP 8.2+
- **Frontend**: Tailwind CSS, Alpine.js, Blade
- **Database**: MySQL 8.0
- **Cloud Infrastructure**: Microsoft Azure (VMs, MySQL Flexible Server, Load Balancer)
- **CI/CD**: GitHub Actions

## 4. Quick Architecture

TraciF utilizes a standard 3-Tier Layered Architecture deployed across a horizontally scalable cloud topology:
- **Load Balancer**: Nginx reverse proxy distributing traffic.
- **Compute Layer**: Multiple Azure VMs (Standard_B1s) running PHP 8.2-FPM.
- **Data Layer**: Centralized Azure Database for MySQL Flexible Server.

## 5. Installation

```bash
# Clone the repository
git clone https://github.com/khansatanaya2005-eng/Tubes_CC.git tracif
cd tracif

# Install PHP dependencies
composer install

# Install Frontend dependencies
npm install
npm run build
```

## 6. Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate Application Key
php artisan key:generate

# Link Storage
php artisan storage:link
```
Ensure your `.env` is configured with your database credentials. For production, **strictly ensure** `APP_DEBUG=false`.

## 7. Running the Application

```bash
# Run database migrations and seeders
php artisan migrate --seed

# Start the local development server
php artisan serve
```

## 8. Testing

Testing strategies are defined in the Enterprise Report. To run the automated suite:
```bash
php artisan test
```

## 9. Quick Deployment Overview

TraciF is configured for Azure Web Apps and VMs. Push to the `main` branch to trigger the GitHub Actions workflow, which automatically installs dependencies and deploys the production build to Azure.

For the extensive Nginx Load Balancer and multi-VM deployment guide, see the [Master Report](docs/TraciF_Enterprise_Report.md).

## 10. Contributors

| Nama | NIM | Role |
|------|-----|------|
| Satanaya Khan | [Update NIM] | Lead Developer / Cloud Architect |
| Faris Naufal | [Update NIM] | Senior Full Stack Developer |

## License

This project is licensed under the MIT License.
