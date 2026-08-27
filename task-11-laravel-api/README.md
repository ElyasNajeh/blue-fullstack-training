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
### Task 15: Vue & Laravel Full-Stack Integration

Task 15 connects the Vue.js frontend with the Laravel backend API to create a complete full-stack application.

The task focuses on replacing temporary frontend data with real Laravel API data, integrating authentication using Laravel Sanctum, loading posts and categories from the backend, and connecting create, update, and delete operations between Vue and Laravel.

Main topics included:

- Vue and Laravel API integration
- Environment-based API configuration
- Laravel Sanctum authentication
- Login and logout integration
- Authenticated user state using Pinia
- Bearer token authentication
- Protected frontend requests
- Loading posts from Laravel
- Loading categories from Laravel
- Creating posts from Vue
- Updating existing posts
- Deleting posts
- Post ownership handling
- Backend validation and error handling
- Handling `401 Unauthorized` responses
- Handling `403 Forbidden` responses
- Loading, error, and success states
- Vue Router integration for create and edit pages

#### Authentication Integration

The Vue application uses the Laravel authentication endpoints to log users in, retrieve the authenticated user, and log users out.

The authentication state is managed using Pinia, and the Sanctum access token is included in protected API requests using the `Authorization: Bearer` header.

#### Posts Integration

Posts are loaded directly from the Laravel `/api/posts` endpoint instead of temporary frontend data.

The frontend displays post information returned by the backend, including:

- Title
- Body
- Status
- Category
- Author

#### Categories Integration

Categories are loaded from the Laravel `/api/categories` endpoint and used dynamically in the Create Post and Edit Post forms.

This avoids maintaining a separate hardcoded category list in the frontend.

#### Create Post

Authenticated users can create new posts from the Vue application.

The Create Post form sends the post title, body, status, and category to the Laravel API using an authenticated request.

The interface handles successful creation, authentication errors, and request failures.

#### Update Post

Posts can be updated through the Vue Edit Post view.

The existing post data is loaded into the form, including its title, body, status, and category.

Only the owner of a post is allowed to update it. Unauthorized users are shown an access-denied state instead of the edit form.

#### Delete Post

Authenticated users can delete their own posts directly from the Posts view.

Laravel Policies enforce ownership on the backend. If a user attempts to delete another user's post, the API returns `403 Forbidden`, and the frontend displays an appropriate message instead of treating the operation as successful.

#### Authorization Handling

Frontend authorization improves the user experience by displaying appropriate states and messages, while Laravel remains responsible for enforcing the actual security rules on the backend.

Protected operations include:

- Creating posts
- Updating owned posts
- Deleting owned posts

The frontend handles authentication and authorization failures without exposing passwords, secret keys, or hardcoded access tokens.

### Tasks 16–17: Full-Stack Integration, Security & Testing

Tasks 16–17 complete and improve the Vue and Laravel full-stack application by focusing on end-to-end functionality, frontend route protection, authorization-aware UI, reusable API logic, user feedback states, and automated testing.

The tasks build on the previous Vue and Laravel integration and ensure that the application works as a complete full-stack system with proper authentication, authorization, pagination, filtering, error handling, and testing.

Main topics included:

- Complete end-to-end CRUD flow
- Backend-powered post search and filtering
- Laravel pagination integrated with Vue
- Delete confirmation before removing posts
- UI updates after create, update, and delete operations
- Frontend route protection
- Authentication state validation
- Handling expired or invalid authentication tokens
- Authorization-aware UI
- Showing Edit and Delete actions only to post owners
- Laravel Policies as the final authorization layer
- Handling `401 Unauthorized`
- Handling `403 Forbidden`
- Handling `404 Not Found`
- Loading, empty, success, and error states
- Disabled submit buttons while requests are processing
- Reusable API/composable logic
- Environment-based API configuration
- Laravel Feature Tests
- Vue automated tests using Vitest
- Mocking API behavior in frontend tests

#### End-to-End CRUD Flow

The Vue frontend is fully connected to the Laravel API for post management.

Users can load and search posts, navigate through paginated results, create new posts, update their own posts, and delete their own posts with a confirmation step.

Successful CRUD operations are reflected in the interface without requiring a manual full-page refresh.

#### Frontend Route Protection

Protected Vue routes such as Create Post and Edit Post require authentication.

The application validates the stored authentication token and redirects unauthenticated users to the appropriate login state when necessary.

#### Authorization-Aware UI

The frontend uses the authenticated user state to display Edit and Delete controls only when the logged-in user owns the post.

This improves the user experience, while Laravel Policies remain responsible for the final backend authorization and security checks.

#### Search and Pagination

Post searching is handled using Laravel query parameters instead of filtering only the currently loaded frontend data.

Pagination is also controlled by the Laravel API, allowing the Vue application to navigate between backend result pages.

#### Automated Testing

Laravel Feature Tests were added to verify important backend API behavior, including:

- Successful user login
- Unauthenticated access to protected endpoints
- Authenticated post creation
- Validation failure for invalid post data
- Preventing users from updating another user's post
- Preventing users from deleting another user's post
- Successful posts list response

Vue tests use Vitest and Vue Test Utils to verify important frontend behavior without depending on a live backend API.

The frontend tests cover form validation and application behavior using mocked API responses.

### Task 18: CMS-Oriented Pages Module

Task 18 extends the full-stack application by introducing a simple CMS-oriented Pages module backed by Laravel and rendered dynamically in Vue.

The task focuses on managing database-backed page content, separating public content from authenticated management operations, dynamically rendering published pages using slugs, and providing authenticated interfaces for creating and editing pages.

Main topics included:

- Database-backed Pages content model
- Unique page slugs
- Draft and published page statuses
- Public published-page API
- Dynamic page rendering using Vue Router
- Loading, not-found, and server-error states
- Authenticated page management
- Create and edit page forms
- Laravel validation
- Duplicate slug prevention
- Vue handling of backend validation errors
- Laravel Sanctum protection for management endpoints

### Task 19: Reusable CMS Content Blocks

Task 19 extends the CMS Pages module by introducing reusable content blocks that allow pages to have flexible and dynamically rendered content.

The task focuses on creating reusable blocks, connecting multiple ordered blocks to pages, managing blocks through protected APIs and the Vue management interface, and dynamically rendering different block types in public pages.

Main topics included:

- Reusable content blocks
- Page-to-block relationships
- Block types and flexible content data
- Block display ordering
- Protected block management APIs
- Creating, updating, deleting, and reordering blocks
- CMS-style block management interface
- Dynamic block rendering
- Reusable Vue block components
- Hero, Text, and Call to Action blocks
- Unsupported block fallback handling
- Separation between public presentation and authenticated management

#### CMS Development Concepts

Pages are stored in the database and loaded dynamically using their slugs instead of creating a separate hardcoded Vue page for each page.

Each page can contain multiple reusable content blocks. Blocks have a type, display position, and content data, allowing different types of content to be stored and ordered on the same page.

The Vue frontend uses reusable components for supported block types and dynamically selects the correct component based on the block type returned by Laravel.

Content management is separated from public presentation. Public users can view published page content, while authenticated users can manage pages and their content blocks through protected management functionality.