# Blue Training - October CMS

## Project Description

This project is part of the Blue Information Technology Full-Stack Training Program.

The purpose of this project is to practice the main concepts of October CMS by building a simple website using a custom theme, reusable layouts and partials, multiple pages, and editable CMS content.

---

## Requirements

Make sure the following are installed:

- PHP
- Composer
- MySQL
- Git

---

## Installation

Install the project dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the database connection in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=october_cms
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Run the database migrations:

```bash
php artisan migrate
```

Start the application:

```bash
php artisan serve
```

The website will be available at:

```text
http://127.0.0.1:8000
```

Do not commit real passwords, license keys, or other environment secrets.

---

## Backend Administration

The October CMS backend can be accessed at:

```text
http://127.0.0.1:8000/admin
```

A local administrator account is required to access the backend. Real administrator credentials are not included in the repository.

---

## Theme Structure

A custom theme named `blue-training` was created for this project.

The main structure includes:

```text
blue-training/
├── assets/
├── content/
├── layouts/
├── pages/
└── partials/
```

The shared `default` layout contains the main HTML structure and uses reusable partials instead of duplicating common sections.

### Pages

The website includes:

- Home (`/`)
- About (`/about`)
- Contact (`/contact`)

### Reusable Partials

The project includes reusable partials for:

- Header
- Footer
- Hero section

The Header and Footer are shared through the main layout, while the Hero partial is used on the Home page.

---

## Editable CMS Content

The Home page contains content that can be edited through the October CMS backend.

Two content files are used:

- `home-title.htm`
- `home-description.htm`

This allows the Hero title and description to be changed through the CMS without manually editing the page layout or Hero partial.

---

## Navigation and Responsive Design

Navigation is available between the Home, About, and Contact pages.

Each page has its own URL, and refreshing an internal page continues to display the correct page.

Basic responsive styling was also added so the website remains readable and organized on desktop and mobile screen sizes.

---

## CMS Concept Comparison

In Tasks 18–19, CMS functionality was created manually using Laravel and Vue. Laravel handled pages and content blocks through the backend API, while Vue dynamically rendered the returned content using reusable components.

October CMS provides similar concepts directly through its CMS structure.

- **Pages** represent individual website pages and URLs.
- **Layouts** provide the shared structure used by multiple pages.
- **Partials** are reusable sections similar to reusable Vue components.
- **Editable Content** separates manageable website content from the page structure.

In the previous implementation, we created the page management APIs, block management, and dynamic rendering ourselves. With October CMS, many of these CMS concepts are already provided and organized by the platform.

---

## Setup Notes

During setup, the MySQL database had to be created before October CMS could connect successfully.

The October CMS migrations also had to be completed before the custom theme could be activated correctly.

Another issue occurred when the previous Laravel project was still running on port `8000`. After stopping it and running the server from the October CMS project, the custom theme was displayed correctly.

---

## Security

Real credentials and secrets are not committed to the repository. Database passwords, administrator credentials, license keys, and other private configuration remain in the local `.env` file.