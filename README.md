# Citizen Grievance Redressal Portal

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel)
![License](https://img.shields.io/badge/License-GPL--3.0--or--later-blue?style=for-the-badge)

A multi-role Laravel 12 web application for citizens to file grievances and for government officers/admins to resolve them.

## Features

- **Three roles** — Citizen (file & track grievances), Officer (resolve assigned grievances), Admin (manage users, departments, categories, assignments)
- **Department & Category hierarchy** — Grievances categorized by department (e.g., Municipal Corporation, Water Board) and sub-category
- **Status workflow** — Submitted → Under Review → In Progress → Resolved → Closed
- **Comments & Attachments** — Citizens and officers can comment; file uploads supported
- **Email notifications** — Status changes and assignments trigger email alerts (logged to `storage/logs` by default)
- **Dashboard analytics** — Per-role dashboards with grievance statistics

## Architecture

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 11 (PHP 8.3) |
| Database | MySQL 8.0 |
| Frontend | Blade templates with Bootstrap |
| Containerization | Docker & Docker Compose |
| Session | File-based (configurable) |

## Quick Start (Docker)

### Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (v24+)

### Setup

```bash
# 1. Clone and enter the project
git clone https://github.com/gaganjainse/grievance-portal.git
cd grievance-portal

# 2. Copy environment file and configure
copy .env.example .env    # Windows
# cp .env.example .env    # Linux/macOS

# 3. Build and start containers
docker compose up -d

# 4. The app is now running at:
#    http://localhost:8000
```

### Seeded Accounts

The seeder creates the following test accounts (all passwords: `password`):

| Email | Role |
|-------|------|
| admin@grievance.gov | Admin |
| officer1@grievance.gov | Officer (Municipal Corporation) |
| officer2@grievance.gov | Officer (Water Board) |
| citizen1@example.com | Citizen |
| citizen2@example.com | Citizen |

### Departments (seeded)

- Municipal Corporation, Water Board, Electricity Board, Health Department, Education Department, Transport Department, Revenue Department, Forest & Environment

## Docker Services

| Service | Port | Description |
|---------|------|-------------|
| `app` | 8000 | Laravel app (PHP 8.3 + Composer) |
| `mysql` | 3307 | MySQL 8.0 (internal port 3306) |

## Manual Setup (without Docker)

```bash
# PHP 8.3+, Composer, MySQL 8.0 required
composer install
copy .env.example .env   # configure DB credentials
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Routes

| Path | Role | Description |
|------|------|-------------|
| `/login` | — | Login page |
| `/register` | — | Registration |
| `/citizen/dashboard` | Citizen | Dashboard + file grievance |
| `/officer/dashboard` | Officer | Assigned grievances |
| `/admin/dashboard` | Admin | Full management |

## License

GPL-3.0-or-later — see [LICENSE](LICENSE).
## 📚 Docs

Fleet-wide reading compilation: [shesh-docs](https://github.com/gaganjainse/shesh-docs).
