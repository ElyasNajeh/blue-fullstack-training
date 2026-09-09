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

## Task 24 - October CMS Dynamic Page Builder

- Added a database-backed dynamic `Page` entity.
- Added page title, unique slug, published/draft status, SEO title, SEO description, and timestamps.
- Implemented backend CRUD management for Dynamic Pages.
- Added backend permission protection for managing Dynamic Pages.
- Added reusable content sections for building dynamic pages.
- Implemented four supported section types: Hero, Text Content, Image + Text, and Call to Action (CTA).
- Added section-specific content fields for each section type.
- Added display ordering and active/inactive state for page sections.
- Configured the backend page editor to add, edit, order, and remove multiple sections.
- Created reusable theme partials for rendering each section type.
- Added a dynamic public page route using the page slug.
- Loaded and rendered active page sections dynamically in their configured order.
- Restricted public access to published pages only.
- Added not-found handling for invalid slugs and draft pages.
- Added dynamic page navigation integration.
- Added dynamic SEO title and description metadata with page-title fallback.
- Added validation for required page fields, unique slugs, valid status values, and section data.
- Created and tested multiple dynamic pages with different section combinations.
- Added responsive styling for all dynamic page section types.
- Verified backend changes are reflected dynamically on the public website.

---

## Task 25 - October CMS Blog / News Module

- Added a database-backed `BlogCategory` entity with name, unique slug, status, display order, and timestamps.
- Added a database-backed `BlogPost` entity with title, unique slug, excerpt, content, category, featured image, publication status, published date, and timestamps.
- Added validation for required Blog Category and Blog Post fields.
- Added backend CRUD management for Blog Categories and Blog Posts.
- Added backend permission protection for managing Blog/News content.
- Added Blog Categories and Blog Posts to the backend navigation.
- Added featured image upload support for Blog Posts.
- Added Draft and Published publication statuses.
- Restricted public Blog content to Published posts whose publication date is not in the future.
- Created a reusable Blog Listing component.
- Displayed Blog Posts with their Category and Featured Image.
- Added database-backed pagination to the public Blog listing.
- Added public Blog search by title, excerpt, and content.
- Added Category filtering using database-backed Blog Categories.
- Supported Search and Category filtering together while preserving pagination.
- Added a dynamic Blog Details page using the post slug.
- Displayed the Blog Post title, featured image, category, published date, and main content.
- Added not-found handling for unknown, Draft, and unavailable Blog Posts.
- Added a Related Posts section using other Published posts from the same Category.
- Excluded the current Blog Post from Related Posts and limited the number of related items.
- Added dynamic SEO metadata using the Blog Post title and excerpt.
- Added the Blog page to the public website navigation.
- Added responsive styling for Blog listing, search, filters, pagination, details, and related posts.
- Reused October CMS components and theme markup across the Blog module.
- Verified search, category filtering, pagination, Blog details, Related Posts, publication rules, SEO metadata, and responsive behavior.

---

## Task 26 - October CMS Document Library

- Added a database-backed `DocumentCategory` entity with name, unique slug, status, display order, and timestamps.
- Added a database-backed `Document` entity with title, unique slug, short description, category, attached file, publication status, publication date, download counter, and timestamps.
- Added validation for required Document Category and Document fields.
- Added unique slug validation for Document Categories and Documents.
- Added October CMS file attachment support for Documents.
- Added server-side file validation for supported document types and maximum file size.
- Supported PDF, DOC/DOCX, XLS/XLSX, and PPT/PPTX uploads.
- Added backend CRUD management for Document Categories and Documents.
- Added backend permission protection for managing the Document Library.
- Added Document Categories and Documents to the backend navigation.
- Added Draft and Published document statuses.
- Restricted the public Document Library to eligible Published Documents.
- Created a reusable Document Library component.
- Added a public `/documents` page using the existing theme.
- Displayed document title, category, description, file type, and publication/upload date.
- Added database-backed search by document title and description.
- Added Category filtering and supported Search and Category filtering together.
- Added database-backed pagination while preserving active search and filter values.
- Added a public Download action for available document files.
- Added download counter tracking for valid document download requests.
- Prevented unavailable or unpublished Documents from being downloaded through the public library.
- Tested replacing an existing Document attachment while preserving its content record and metadata.
- Verified the public library uses the latest attached file after replacement.
- Added clear empty states for an empty library and searches or filters with no results.
- Added clear feedback for Documents with missing attached files.
- Added validation feedback for unsupported file uploads.
- Added the Documents page to the public website navigation.
- Added responsive styling for the Document Library, filters, document cards, downloads, and pagination.
- Verified backend management, permissions, validation, search, filtering, pagination, downloads, file replacement, and missing-file behavior.

---

## Task 27 - October CMS Audit Log & Administrative Activity Tracking

- Reviewed the existing backend permissions for Services, Categories, Contact Messages, Dynamic Pages, Blog/News, and Documents.
- Added a database-backed `AuditLog` entity for tracking important administrative actions.
- Added backend user ID and username tracking for audit entries.
- Added action type, module/entity, record ID, description, metadata, and timestamp information to Audit Logs.
- Implemented a reusable `AuditLogger` class to centralize administrative activity logging.
- Added audit tracking to Blog Posts and Documents.
- Added Create, Update, Delete, and Status Change activity tracking.
- Added structured metadata for relevant status changes.
- Avoided logging insignificant actions such as normal page views.
- Added a read-only Audit Log section to the October CMS backend.
- Added backend permission protection for accessing the Audit Log.
- Displayed date/time, backend user, action, module/entity, record ID, and description in the Audit Log list.
- Added Audit Log filtering by action type and module/entity.
- Added an individual Audit Log details view.
- Displayed available structured metadata in the Audit Log details view.
- Disabled normal backend editing and manual deletion of Audit Log records to protect audit integrity.
- Ensured Audit Log entries remain available independently of the original content record.
- Restricted logged metadata to explicitly selected values.
- Excluded passwords, authentication tokens, session IDs, API keys, environment secrets, authentication headers, and uploaded file contents from Audit Logs.
- Verified administrative actions are stored with the responsible backend user and timestamp.

### Audit Logging Approach

Administrative activity is recorded through a reusable `AuditLogger` class rather than duplicating the database logging logic across controllers or models. Existing content models call the shared logger for meaningful lifecycle events such as Create, Update, Delete, and Status Change.

The current implementation tracks Blog Posts and Documents and can be extended to additional modules with minimal duplication.

### Audit Log Access & Integrity

The Audit Log backend section is protected by the `elyas.services.audit_logs` permission. Audit entries are read-only through the backend interface and cannot be manually edited or deleted.

### Sensitive Data

Audit metadata contains only explicitly selected information relevant to an administrative action. Passwords, tokens, session IDs, API keys, authentication headers, private environment values, credentials, and uploaded file contents must never be stored in Audit Logs.

### Required Update Command

After pulling the latest changes, run:

---

## Task 28 - October CMS Dashboard, Reports & Data Export

- Added a dedicated administrative Dashboard to the October CMS backend.
- Added backend permission protection for Dashboard access.
- Added six KPI summary cards using real project data.
- Added Published Blog Posts and Draft Blog Posts KPI counts.
- Added Total Documents and Total Document Downloads KPI values.
- Added New Contact Messages and Total Services KPI values.
- Added Latest Contact Messages to the Dashboard.
- Added Recent Audit Log Activity to the Dashboard.
- Limited recent activity sections to a practical number of records.
- Added direct links from recent activity sections to their relevant backend sections.
- Created a separate administrative Reports page.
- Used existing Audit Log data as the source for administrative activity reports.
- Added report filtering by Date From, Date To, Module, and Action Type.
- Applied report filters directly to database queries.
- Added filtered summary values for Total, Create, Update, and Delete actions.
- Added a detailed report table with date/time, user, action, module, record ID, and description.
- Added pagination to the detailed report results.
- Added a clear empty state when no report records match the selected filters.
- Added CSV export for administrative activity reports.
- Ensured CSV exports respect the currently active report filters.
- Added clear CSV column headings and meaningful export filenames.
- Excluded sensitive information from report and CSV output.
- Added separate backend permission protection for Reports.
- Used database aggregation, limits, and pagination for Dashboard and Report queries.
- Avoided loading complete datasets where database queries could perform the calculation.
- Verified KPI values and report results against the existing backend data.
- Verified report filters update both summary values and detailed results.
- Verified CSV exports contain the expected filtered records.

---

## Task 29 - Final QA & Production Readiness

- Completed functional regression testing across the main public and backend features.
- Re-tested backend permissions using non-superuser accounts and direct restricted URLs.
- Verified server-side validation and clear error handling for invalid and missing inputs.
- Reviewed Document upload/download security, file-type validation, size limits, and missing-file behavior.
- Reviewed the repository to ensure credentials, passwords, tokens, and private environment values are not committed.
- Tested public website links, search, filters, pagination, empty states, not-found behavior, and responsive layouts.
- Reviewed backend lists, forms, navigation, permissions, filters, and validation messages.
- Tested important data relationships, publication status changes, file replacement, and Audit Log preservation.
- Reviewed queries for pagination, limits, eager loading, aggregate queries, and obvious N+1 issues.
- Verified Dashboard KPI values, Reports, filters, summaries, and CSV exports against stored data.
- Reviewed production configuration requirements and final project readiness.

### QA Findings

| Finding | Module | Severity | Status | Resolution |
| --- | --- | --- | --- | --- |
| Document uploads needed stronger file validation | Documents | High | Fixed | Added server-side type and size validation |
| Missing files could cause unavailable downloads | Documents | Medium | Fixed | Added missing-file handling |
| Administrative changes were not centrally tracked | Audit Log | Medium | Fixed | Added reusable activity logging |
| Large report results required controlled loading | Reports | Medium | Fixed | Added filtering and pagination |
| Production requirements were not documented | Documentation | Low | Fixed | Added production-readiness notes |

### Production Readiness

Before production deployment:

- Set `APP_ENV=production` and `APP_DEBUG=false`.
- Configure the production application URL and database environment variables.
- Configure mail settings if required.
- Keep `.env`, passwords, tokens, and other credentials outside version control.
- Ensure storage and cache directories are writable.
- Configure HTTPS and production web-server settings.
- Run the required migrations and clear/rebuild application caches.

### Final Notes

- Main backend sections are protected using permissions.
- Public Draft/Inactive content is not exposed.
- Uploaded Documents are validated on the server.
- Public not-found and empty states are handled.
- Pagination and database-level queries are used where appropriate.
- No known critical issues remain after final QA.

### Dashboard KPIs

The administrative Dashboard displays six summary indicators:

- Published Blog Posts
- Draft Blog Posts
- Total Documents
- Total Document Downloads
- New Contact Messages
- Total Services

### Reporting & Export

The Reports section analyzes administrative activity recorded by the Audit Log. Reports can be filtered by date range, module, and action type. The active filters affect the database query, summary values, detailed results, pagination, and CSV export.

### Performance

Dashboard and reporting queries use database-level operations such as `count()`, `sum()`, `limit()`, and `paginate()` instead of loading complete datasets into memory when unnecessary.

### Access Control

Dashboard and Reports are protected by dedicated backend permissions. Users without the required permission cannot access the corresponding backend controller directly.

```bash
php artisan october:migrate
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