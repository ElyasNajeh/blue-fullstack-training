# Blue Full-Stack Training - October CMS

This project is part of the Blue Information Technology Full-Stack Training Program and covers practical October CMS development.

---

## Setup

### Requirements

- PHP
- Composer
- MySQL
- Git

### Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Configure the database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=october_cms
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Run migrations and start the project:

```bash
php artisan migrate
php artisan october:migrate
php artisan serve
```

Website:

```text
http://127.0.0.1:8000
```

Backend:

```text
http://127.0.0.1:8000/admin
```

---

## Task 20 - October CMS Fundamentals

- Created and activated the custom `blue-training` theme.
- Created a reusable main layout.
- Added reusable Header, Footer, and Hero partials.
- Created Home, About, and Contact CMS pages.
- Added CMS-managed editable content.
- Added navigation and basic responsive styling.
- Compared October CMS concepts with the custom CMS implementation from Tasks 18–19.

---

## Task 21 - October CMS Plugin & Services

- Created the custom `Elyas.Services` plugin.
- Created a database-backed `Service` model and migration.
- Added validation for required Service fields.
- Implemented backend CRUD management for Services.
- Added active/inactive status and display ordering.
- Configured practical backend list and form views.
- Created and registered a reusable Services CMS component.
- Added a configurable maximum Services property.
- Created a public `/services` page with dynamic database content.
- Displayed only active Services in the configured order.
- Added reusable Service markup and empty-state behavior.
- Added responsive styling for the Services section.
- Verified backend updates are reflected on the public page.

---

## Project Structure

```text
plugins/
└── elyas/
    └── services/
        ├── components/
        ├── controllers/
        ├── models/
        ├── updates/
        └── Plugin.php

themes/
└── blue-training/
    ├── assets/
    ├── content/
    ├── layouts/
    ├── pages/
    └── partials/
```

---

## Security

Real database credentials, administrator credentials, license keys, and other secrets are not committed to the repository.