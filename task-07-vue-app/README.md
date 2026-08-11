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

---

## Project Structure

```text
task-07-vue-app/
│
├── src/
│   ├── assets/
│   │   ├── blue.png
│   │   └── main.css
│   │
│   ├── components/
│   │   ├── SiteHeader.vue
│   │   ├── SiteFooter.vue
│   │   ├── ServiceCard.vue
│   │   └── PostsCard.vue
│   │
│   ├── composables/
│   │   └── usePosts.js
│   │
│   ├── router/
│   │   └── index.js
│   │
│   ├── views/
│   │   ├── HomeView.vue
│   │   ├── ServicesView.vue
│   │   ├── PostsView.vue
│   │   ├── PostDetailsView.vue
│   │   ├── ContactView.vue
│   │   └── NotFoundView.vue
│   │
│   ├── App.vue
│   └── main.js
│
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

---

## Challenges

None