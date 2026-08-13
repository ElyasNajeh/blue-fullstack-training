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
VITE_API_BASE_URL=https://jsonplaceholder.typicode.com
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

JSONPlaceholder simulates post creation and does not permanently save created posts.

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