# Blue Information Technology Website

## Project Description

This project is part of the Blue Information Technology Full-Stack Training Program.

The website was originally built using HTML, CSS, and JavaScript, then migrated to Vue.js with reusable components, routing, reactive state, API integration, Pinia state management, and automated testing.

---

## Technologies Used

- HTML5
- CSS3
- JavaScript
- Vue.js 3
- Vue Router
- Pinia
- Vite
- Vitest
- Vue Test Utils
- jsdom
- JSONPlaceholder API
- Git & GitHub

---

## Project Structure

```text
task-07-vue-app/
│
├── src/
│   ├── __tests__/
│   │   ├── postsStore.spec.js
│   │   ├── PostsCard.spec.js
│   │   └── CreatePostView.spec.js
│   │
│   ├── assets/
│   │   ├── blue.png
│   │   └── main.css
│   │
│   ├── components/
│   │   ├── SiteHeader.vue
│   │   ├── SiteFooter.vue
│   │   ├── ServiceCard.vue
│   │   ├── PostsCard.vue
│   │   ├── PostDetails.vue
│   │   └── FavoritesPosts.vue
│   │
│   ├── composable/
│   │   └── usePosts.js
│   │
│   ├── router/
│   │   └── index.js
│   │
│   ├── stores/
│   │   └── posts.js
│   │
│   ├── views/
│   │   ├── HomeView.vue
│   │   ├── ServicesView.vue
│   │   ├── PostsView.vue
│   │   ├── PostDetailsView.vue
│   │   ├── FavoritesView.vue
│   │   ├── CreatePostView.vue
│   │   ├── ContactView.vue
│   │   └── NotFoundView.vue
│   │
│   ├── App.vue
│   └── main.js
│
├── .env.example
├── index.html
├── package.json
├── vite.config.js
└── README.md
```

---

## How to Run

Install dependencies:

```bash
npm install
```

Create a `.env` file:

```env
VITE_API_BASE_URL=https://jsonplaceholder.typicode.com
```

Start the development server:

```bash
npm run dev
```

---

# Task Summary

## Tasks 01–06

- Built the original website using HTML, CSS, and JavaScript.
- Added responsive design, accessibility, and form validation.
- Added dynamic content, filtering, API integration, search, and UI states.
- Completed functional and responsive testing.

---

## Task 07 – Vue.js

- Migrated the website to Vue.js.
- Created reusable Vue components.
- Used reactive state with `ref()` and `computed()`.
- Implemented component communication using props and emits.
- Integrated the JSONPlaceholder API.
- Added service filtering and live post search.
- Added loading, error, retry, and empty states.

---

## Task 08 – Vue Router & Composables

- Added Vue Router and route-based navigation.
- Created separate views for application pages.
- Added active navigation with `RouterLink`.
- Added lazy-loaded routes and a Not Found route.
- Added dynamic post routes using `/posts/:id`.
- Added invalid ID and post not found handling.
- Created a reusable API composable.
- Added route-aware post search using query parameters.
- Preserved search state through URL refresh.

---

## Task 09 – Pinia State Management & Post Creation

- Added Pinia for shared application state.
- Added favorites with localStorage persistence.
- Added a Favorites page and favorites counter.
- Added a Create Post form with validation.
- Added POST request handling with loading, success, error, retry, and form reset states.

---

## Task 10 – Frontend Testing & QA

- Added automated testing using Vitest and Vue Test Utils.
- Tested favorites, localStorage persistence, PostsCard behavior, and Create Post validation/submission.
- Added environment-based API configuration using `VITE_API_BASE_URL`.
- Verified the production build and preview.
- Completed final frontend regression testing.

---

---

## Task 15 – Vue & Laravel Integration

- Connected the Vue frontend to the Laravel REST API.
- Replaced JSONPlaceholder with the Laravel backend.
- Integrated login, logout, and authenticated user retrieval.
- Added authentication state management using Pinia.
- Added Sanctum Bearer tokens to protected API requests.
- Loaded posts and categories from Laravel.
- Connected create, update, and delete post operations to the backend.
- Added handling for 401 Unauthorized and 403 Forbidden responses.
- Added post ownership handling for update and delete operations.

---

## Tasks 16–17 – Full-Stack Integration, Security & Testing

- Completed the end-to-end post CRUD flow.
- Added backend-powered post search.
- Integrated Laravel pagination with Vue.
- Added delete confirmation.
- Added protected frontend routes.
- Added authentication token validation.
- Added authorization-aware UI for post owners.
- Improved loading, empty, success, and error states.
- Added reusable API request logic.
- Added automated frontend testing using Vitest and Vue Test Utils.

---

## Task 18 – CMS-Oriented Pages Module

- Added dynamic CMS-oriented pages to the Vue application.
- Added dynamic page routing using page slugs.
- Loaded published page content from the Laravel API.
- Added loading, not-found, and server-error states for dynamic pages.
- Added an authenticated Pages Management interface.
- Added Create Page functionality.
- Added Edit Page functionality.
- Added draft and published page statuses.
- Added backend validation feedback to page forms.
- Added handling for duplicate page slugs.
- Protected page management routes using authentication.

# Frontend Handover - Task 10

## Overview

The frontend is built with Vue.js and includes routing, Pinia state management, reusable components, API integration, favorites, post creation, and automated testing.

## Structure

- `components/` – Reusable UI components.
- `views/` – Route-level pages.
- `stores/` – Pinia shared state.
- `composable/` – API request logic.
- `router/` – Application routes.
- `__tests__/` – Automated tests.

## Setup

Install dependencies:

```bash
npm install
```

Create the environment configuration:

```env
VITE_API_BASE_URL=http://127.0.0.1:8000/api

```

Run the development server:

```bash
npm run dev
```

## Testing

Run all automated tests:

```bash
npm test -- --run
```

Tests cover favorites, localStorage persistence, PostsCard behavior, and Create Post validation/submission.

## Production

Create the production build:

```bash
npm run build
```

Run the production preview:

```bash
npm run preview
```

## Known Limitations

- Laravel REST API
- Laravel Sanctum Authentication

## Final QA

- Regression QA: Passed
- Known Issues: None

---

## Vue Concepts Used

- `ref()`
- `computed()`
- `watch()`
- `onMounted()`
- `defineProps()`
- `defineEmits()`
- `v-for`
- `v-if`
- `v-model`
- `RouterLink`
- `RouterView`
- `useRoute()`
- `useRouter()`
- Composables
- Dynamic Routes
- Query Parameters
- Lazy Loading
- Pinia
- `defineStore()`
- `storeToRefs()`
- Shared State
- localStorage Persistence
- Form Validation
- POST Requests
- `async/await`
- Vitest
- Vue Test Utils
- API Mocking
- Environment Variables

---

## Challenges

None
