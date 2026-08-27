## Full-Stack Project Setup

The project is a full-stack application built with Vue.js for the frontend and Laravel for the backend. The frontend communicates with the Laravel REST API to manage authentication, posts, categories, CMS pages, and other application data.

### Required Software

Make sure the following software is installed:

- Node.js and npm
- PHP
- Composer
- MySQL

### Frontend Setup

Navigate to the Vue project:

```bash
cd task-07-vue-app
```

Install dependencies:

```bash
npm install
```

Create the environment file if needed and configure the Laravel API URL:

```env
VITE_API_BASE_URL=http://127.0.0.1:8000/api
```

Start the Vue development server:

```bash
npm run dev
```

### Backend Setup

Navigate to the Laravel project:

```bash
cd task-11-laravel-api
```

Install PHP dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

On Windows PowerShell, you can use:

```powershell
Copy-Item .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Configure the database connection in `.env`.

Required database environment variables include:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

Do not commit real credentials or secrets to the repository.

### Database Setup

Run the migrations:

```bash
php artisan migrate
```

To populate the database with the available seed data:

```bash
php artisan db:seed
```

The database can also be recreated and seeded using:

```bash
php artisan migrate:fresh --seed
```

### Run the Backend

Start the Laravel development server:

```bash
php artisan serve
```

By default, the Laravel application runs at:

```text
http://127.0.0.1:8000
```

The Vue frontend communicates with the API through the `VITE_API_BASE_URL` environment variable.

### Authentication Flow

Authentication is handled by Laravel Sanctum using API tokens.

The general authentication flow is:

1. The user logs in from the Vue frontend.
2. Laravel validates the credentials and returns a Sanctum access token.
3. Vue stores the token and uses it as a Bearer token for authenticated API requests.
4. Protected operations such as creating, updating, and deleting posts, as well as managing CMS pages, require authentication.
5. Laravel authorization policies ensure that users can only update or delete their own posts.
6. Invalid or expired authentication returns a `401 Unauthorized` response, while unauthorized ownership actions return `403 Forbidden`.

Laravel remains the final authority for authentication and authorization even when the Vue interface hides actions that the current user cannot perform.

### Full-Stack Flow

Posts and categories are loaded from the Laravel API and displayed by the Vue frontend.

The integrated application supports:

- User authentication
- Loading posts and categories from Laravel
- Backend search and pagination
- Creating posts
- Updating owned posts
- Deleting owned posts with confirmation
- Authorization-aware frontend controls
- Loading, empty, success, and error states
- Handling `401`, `403`, `404`, validation, and server errors

Successful create, update, and delete operations are reflected in the frontend without requiring a manual full-page refresh.

The integrated application supports:

- User authentication
- Loading posts and categories from Laravel
- Backend search and pagination
- Creating posts
- Updating owned posts
- Deleting owned posts with confirmation
- Authorization-aware frontend controls
- Dynamic CMS pages using slugs
- Public published-page rendering
- Authenticated page management
- Creating and editing CMS pages
- Draft and published page statuses
- Page validation and duplicate slug handling
- Loading, empty, success, and error states
- Handling `401`, `403`, `404`, validation, and server errors

Successful create, update, and delete operations are reflected in the frontend without requiring a manual full-page refresh.

### CMS Development Concepts

Tasks 18 and 19 introduced the main concepts used in CMS development.

Pages are stored in the database and can be loaded dynamically using their slugs instead of creating a separate hardcoded Vue page for every piece of content.

Pages can contain multiple reusable content blocks such as Hero, Text, and Call to Action blocks. Each block has a type, position, and its own content data. Vue uses reusable components for these block types and dynamically renders the correct component based on the data returned by Laravel.

The CMS management interface allows authenticated users to create and edit pages and to add, update, delete, and reorder their content blocks.

Public presentation is separated from content management. Public users can view published pages, while page and block management operations are protected and require authentication.
### Running Tests

#### Laravel Tests

Navigate to the Laravel project and run:

```bash
php artisan test
```

The Laravel feature tests cover important API behavior including authentication, protected endpoints, post creation, validation, authorization, and successful post retrieval.

#### Vue Tests

Navigate to the Vue project and run:

```bash
npx vitest run
```

Vue tests use Vitest and Vue Test Utils. API behavior is mocked where appropriate so frontend tests do not depend on a live Laravel server.

### Running the Full Application

Run both applications in separate terminals.

**Terminal 1 — Laravel:**

```bash
cd task-11-laravel-api
php artisan serve
```

**Terminal 2 — Vue:**

```bash
cd task-07-vue-app
npm run dev
```

Then open the URL displayed by the Vue development server in the browser.