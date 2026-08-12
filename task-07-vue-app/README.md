# Blue Information Technology Website

## Project Description

This project is part of the Blue Information Technology Full-Stack Training Program.

The website was originally built using HTML, CSS, and JavaScript, then migrated to Vue.js with reusable components, routing, reactive state, API integration, and reusable composables.

---

## Technologies Used

- HTML5
- CSS3
- JavaScript
- Vue.js 3
- Vue Router
- Vite
- JSONPlaceholder API
- Git & GitHub
- Pinia
---

## Project Structure

```text
task-07-vue-app/
│
├── src/
├── assets/
│   ├── blue.png
│   └── main.css
│
├── components/
│   ├── SiteHeader.vue
│   ├── SiteFooter.vue
│   ├── ServiceCard.vue
│   ├── PostsCard.vue
│   ├── PostDetails.vue
│   └── FavoritesPosts.vue
│
├── composables/
│   └── usePosts.js
│
├── router/
│   └── index.js
│
├── stores/
│   └── posts.js
│
├── views/
│   ├── HomeView.vue
│   ├── ServicesView.vue
│   ├── PostsView.vue
│   ├── PostDetailsView.vue
│   ├── FavoritesView.vue
│   ├── CreatePostView.vue
│   ├── ContactView.vue
│   └── NotFoundView.vue
│
├── App.vue
└── main.js
├── index.html
├── package.json
├── vite.config.js
└── README.md
```

---

## How to Run

```bash
npm install
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
- Created separate Views for application pages.
- Added active navigation with `RouterLink`.
- Added lazy-loaded routes.
- Added a Not Found route.
- Added dynamic post routes using `/posts/:id`.
- Created a post details page using route parameters.
- Added invalid ID and post not found handling.
- Created a reusable API composable.
- Reused API logic across post views.
- Added route-aware post search using query parameters.
- Preserved search state through URL refresh.

---

## Task 09 – Pinia State Management & Post Creation

- Added Pinia for centralized application state management.
- Moved posts, post details, loading, error, and status states to a Pinia store.
- Separated state for the posts list, post details, and post creation requests.
- Added a favorites feature using shared Pinia state.
- Added favorite and remove-from-favorite functionality across post views.
- Added a computed favorites count.
- Persisted favorite post IDs using localStorage.
- Added a dedicated Favorites page for displaying saved posts.
- Added navigation to the Favorites page with the current favorites count.
- Added a Create Post page using `v-model` for form state.
- Added field-level validation for title, body, and user ID.
- Added minimum-length and positive-number validation.
- Added a live character counter for the post body.
- Added POST request support to the reusable posts composable.
- Added loading and disabled states while creating a post.
- Added success feedback with the returned post ID.
- Added error handling and retry functionality while preserving form data.
- Reset the form only after a successful request.
- Tested both successful and failed post submission flows.

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
- Computed Store State
- localStorage Persistence
- Form Validation
- Form Submission
- POST Requests
- `async/await`
---

## Challenges

None