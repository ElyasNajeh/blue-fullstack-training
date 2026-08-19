# Blue Full-Stack Training

This repository contains my progress throughout the Blue Information Technology Full-Stack Training program.

The training started with frontend fundamentals using HTML, CSS, and JavaScript, then moved to Vue.js for building component-based frontend applications. Starting from Task 11, the training moves into backend development using PHP and Laravel.

## Training Progress

### Tasks 01–06: HTML, CSS & JavaScript

The first six tasks focused on frontend fundamentals and building responsive web pages using HTML, CSS, and JavaScript.

Main topics included:

- Semantic HTML
- CSS styling and responsive design
- JavaScript fundamentals
- DOM manipulation
- Event handling
- Working with data and APIs
- Building interactive frontend features

### Tasks 07–10: Vue.js

Tasks 07–10 introduced Vue.js and focused on building frontend applications using a component-based architecture.

Main topics included:

- Vue 3 fundamentals
- Components and props
- Vue Router
- Reactive state
- API integration
- Loading and error states
- Reusable components
- Pinia state management

### Task 11: Laravel Backend Foundations

Task 11 introduces backend development using PHP and Laravel.

The task focuses on understanding the Laravel project structure, creating API routes, returning JSON responses, organizing logic using controllers, working with dynamic route parameters, and validating incoming HTTP requests.

### Laravel Project Structure

#### `app/`

This contain approximately the main project ,the main backend and (Models,Controllers) .

#### `app/Http/Controllers/`

Controllers Responsible is to return resonse to frontend .

#### `routes/`

When the frontend send the request to specific end-point in backend , the routes direct the request to the suitable controller so controller can deal with request .

#### `config/`

the config contain general settings like cache, connection with database,mails.

#### `database/`

this file who managed database like migrations (to create and alter tables) and seeders to add mock data, then in general to manage and adminstrate all things belong to databases .

#### `public/`

like entry point to all the program due to we can't share sensitive folders .

#### `storage/`

contains files generated or used while the application is running, such as logs, cache,

#### `tests/`

to write automated tests and run it .

#### `.env` and `.env.example`

env represent Environment variables we can't put it in the code like secret-key etc.. , and some variables may be changed 
in production so we can change it very quickly, and the other thing, me as developer when i participate in project i don't have any idea waht is the environment variables so i see the .env .example and copy the file so i can add the real data. 

#### Artisan

like commands , so i can tell laravel what to do from these commands, like start the server to be in development , or create files in certain places.

#### Composer

like npm in js, so we can manage the packages from Composer.

### Task 12: Laravel Database & CRUD API

Task 12 continues backend development using Laravel and introduces database integration with MySQL.

The task focuses on connecting Laravel with a MySQL database, creating database tables using migrations, working with Eloquent models, implementing CRUD API operations, validating requests, handling not-found responses, and adding sample data using seeders.

Main topics included:

- MySQL database connection
- Laravel migrations
- Eloquent models
- Mass assignment and fillable fields
- Database-backed REST API
- CRUD operations
- Request validation
- HTTP status codes and JSON responses
- 404 response handling
- Database seeders

#### Posts API Endpoints

- `GET /api/posts` - Return all posts.
- `GET /api/posts/{id}` - Return a post by ID.
- `POST /api/posts` - Create a new post.
- `PUT /api/posts/{id}` - Update an existing post.
- `DELETE /api/posts/{id}` - Delete a post.

### Task 13: Laravel Relationships, Filtering & Pagination

Task 13 extends the Laravel REST API by introducing relationships between posts and categories and improving how API data is retrieved and returned.

The task focuses on creating categories, defining Eloquent relationships, using API Resources, filtering and sorting posts, implementing pagination, and improving query efficiency using eager loading.

Main topics included:

- Categories table, model, and seeder
- Database foreign keys
- Eloquent `hasMany` and `belongsTo` relationships
- Category validation using `category_id`
- Categories API
- Laravel API Resources
- Filtering posts by title, status, and category
- Sorting by title and creation date
- Ascending and descending sorting
- Laravel pagination
- Controlled `per_page` values
- Eager loading
- Avoiding the N+1 query problem

#### Categories API Endpoints

- `GET /api/categories` - Return all categories.
- `POST /api/categories` - Create a new category.

#### Posts Query Parameters

The posts endpoint supports filtering, sorting, and pagination using query parameters.

Examples:

- `/api/posts?search=laravel`
- `/api/posts?status=published`
- `/api/posts?category_id=2`
- `/api/posts?sort=title&direction=asc`
- `/api/posts?sort=created_at&direction=desc`
- `/api/posts?per_page=10&page=2`

Filters, sorting, and pagination can also be combined in the same request.

### Task 14: Laravel Authentication & Authorization

Task 14 extends the Laravel REST API by adding token-based authentication and authorization using Laravel Sanctum.

The task focuses on user registration and login, issuing and revoking API tokens, protecting write operations, assigning posts to authenticated users, enforcing post ownership using Laravel Policies, and returning safe author information through API Resources.

Main topics included:

- Laravel Sanctum authentication
- User registration and login
- Secure password hashing
- Personal access tokens
- Bearer token authentication
- Protected API routes using `auth:sanctum`
- Authenticated user retrieval
- Token revocation and logout
- Post ownership using `user_id`
- User and Post Eloquent relationships
- Automatic post ownership assignment
- Laravel Policies
- Authorization for update and delete operations
- `401 Unauthorized` handling
- `403 Forbidden` handling
- Safe author data in API Resources
- Eager loading of post relationships

#### Authentication API Endpoints

- `POST /api/register` - Register a new user.
- `POST /api/login` - Authenticate a user and return an access token.
- `GET /api/me` - Return the currently authenticated user.
- `POST /api/logout` - Revoke the current access token.

#### Protected Posts API Endpoints

The post read endpoints remain publicly accessible:

- `GET /api/posts` - Return posts.
- `GET /api/posts/{id}` - Return a post by ID.

The following write operations require a valid Sanctum Bearer token:

- `POST /api/posts` - Create a post for the authenticated user.
- `PUT /api/posts/{id}` - Update a post only if the authenticated user owns it.
- `DELETE /api/posts/{id}` - Delete a post only if the authenticated user owns it.

#### Post Ownership

Each newly created post is automatically assigned to the authenticated user. The API does not accept an arbitrary `user_id` from the client when creating a post.

The ownership relationship is defined using Eloquent:

- User `hasMany` Posts.
- Post `belongsTo` User.

Laravel Policies are used to ensure that users can only update or delete their own posts.

#### Post API Resource

Post responses include useful category and author information while avoiding sensitive user data.

Author information includes only safe fields such as:

- `id`
- `name`

Sensitive information such as passwords, remember tokens, and access tokens is not exposed in API responses.