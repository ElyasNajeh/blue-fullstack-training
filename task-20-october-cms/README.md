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

## Task 22 - October CMS Relationships & Media

- Added a database-backed Service Category model and migration.
- Implemented backend CRUD management for Service Categories.
- Added category status, display ordering, and unique slug validation.
- Added a Category-to-Services relationship.
- Updated the Service backend form with a Category relationship dropdown.
- Displayed Category information in the backend Services list.
- Added Service image attachments with backend upload, change, and remove support.
- Enhanced the public Services component to load Categories and images efficiently.
- Added dynamic Category filtering to the public Services page.
- Excluded inactive Services and Categories from public output.
- Applied configured display ordering to Categories and Services.
- Added a dynamic `/services/:id` Service details page.
- Added clean not-found handling for missing or unpublished Services.
- Added reusable and responsive markup for Service listings and details.
- Verified Category filtering, ordering, status behavior, relationships, images, and backend updates.

---

## Task 23 - October CMS Permissions, Settings & AJAX Contact Management

- Added separate backend permissions for managing Services, Service Categories, and Contact Messages.
- Applied permissions to backend controllers and navigation.
- Verified permissions using a non-superuser backend account with different access scenarios.
- Added plugin Contact Settings for managing contact email, phone number, address, and help text.
- Displayed configured contact information dynamically on the public Contact page.
- Added a database-backed `ContactMessage` model with name, email, subject, message, status, and timestamps.
- Added `New` and `Read` message statuses.
- Created a responsive public Contact Us form using the existing October CMS theme.
- Implemented Contact form submission using the October CMS AJAX framework.
- Added server-side required-field and email validation.
- Added field-level validation errors and success feedback.
- Prevented invalid Contact messages from being saved.
- Added loading behavior during AJAX submissions to reduce duplicate submissions.
- Added backend Contact Message management with list, detail, status update, and delete functionality.
- Protected Contact Messages using backend permissions.
- Organized Services, Categories, and Contact Messages in the backend navigation.
- Verified Contact Settings changes are reflected publicly without editing theme markup.

### Contact Message Flow

1. A visitor submits the Contact form.
2. October CMS processes the request through an AJAX handler.
3. The request is validated on the server.
4. Valid messages are stored in the database with `New` status.
5. Authorized backend administrators can view, update, or delete messages.

### Validation & Security

- Contact form validation is performed on the server.
- Required fields and valid email addresses are enforced.
- Invalid submissions are not stored.
- Backend sections are protected using October CMS permissions.
- Non-superusers can only access sections they have permission to manage.
- Sensitive credentials and secrets are not committed to the repository.

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