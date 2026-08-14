# 🏛️ grievance-portal

> **Citizen Grievance Redressal Portal.** A multi-role Laravel web application for
> citizens to file grievances and for government officers/admins to resolve them.

![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php) ![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel) ![License](https://img.shields.io/badge/License-GPL--3.0--or--later-blue) ![CI](https://github.com/gaganjainse/grievance-portal/actions/workflows/ci.yml/badge.svg)

- **License:** GPL-3.0-or-later
- **Owner:** Gagan Jain ([@gaganjainse](https://github.com/gaganjainse))
- **Stack:** Laravel 12 (PHP 8.3) · MySQL 8 · Blade + Bootstrap · Docker

---

## Features

- **Three roles** — Citizen (file & track), Officer (resolve assigned), Admin (manage users, departments, categories, assignments)
- **Department & Category hierarchy** — grievances categorized by department and sub-category
- **Status workflow** — Submitted → Under Review → In Progress → Resolved → Closed
- **Comments & Attachments** — file uploads supported
- **Email notifications** — status changes and assignments trigger alerts (logged to `storage/logs` by default)
- **Dashboard analytics** — per-role dashboards with grievance statistics

## Quick start (Docker)

```bash
git clone https://github.com/gaganjainse/grievance-portal.git
cd grievance-portal
cp .env.example .env
docker compose up -d     # http://localhost:8000
```

## Testing

```bash
./vendor/bin/phpunit     # PHPUnit suite
```

## Status

CI green. Security: [SECURITY.md](SECURITY.md).

## Documentation index

- **Compiled reading:** [shesh-docs](https://github.com/gaganjainse/shesh-docs)

## License

GPL-3.0-or-later — see [LICENSE](LICENSE).
