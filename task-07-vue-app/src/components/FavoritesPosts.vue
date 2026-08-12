<script setup>
import { RouterLink } from 'vue-router'

import { usePostStore } from '@/stores/posts'

defineProps({
  posts: {
    type: Array,
    default: () => [],
  },

  loading: {
    type: Boolean,
    default: false,
  },
})

const postStore = usePostStore()
</script>

<template>
  <section id="favorites">
    <h2>Favorite Posts</h2>

    <!-- Loading State -->
    <div v-if="loading" class="posts-state">
      <div class="spinner"></div>
      <p>Loading favorite posts...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="posts-state error-state">
      <h3>Something went wrong</h3>
      <p>Failed to load favorite posts.</p>
    </div>

    <!-- Empty State -->
    <div v-else-if="posts.length === 0" class="posts-state">
      <h3>No Favorite Posts</h3>
      <p>You haven't added any posts to your favorites yet.</p>
    </div>

    <!-- Favorite Posts -->
    <div v-else class="posts-grid">
      <article v-for="post in posts" :key="post.id" class="post-card">
        <h3>{{ post.title }}</h3>

        <p>{{ post.body }}</p>

        <div class="post-actions">
          <RouterLink :to="`/posts/${post.id}`"> View Details </RouterLink>

          <button class="favorite-btn favorite" @click="postStore.toggleFavorite(post.id)">
            Remove from Favorite
          </button>
        </div>
      </article>
    </div>
  </section>
</template>

<style scoped>
/* =========================
   Favorites Section
========================= */

#favorites {
  width: 100%;
  max-width: 1200px;

  margin: 0 auto;
  padding: 70px 30px;

  background-color: var(--background-color);
}

#favorites > h2 {
  margin-bottom: 35px;

  color: var(--secondary-color);

  font-size: 2.2rem;
  font-weight: 700;

  text-align: center;
}

/* =========================
   Posts Grid
========================= */

.posts-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);

  gap: 25px;
}

/* =========================
   Loading / Error / Empty
========================= */

.posts-state {
  width: 100%;
  max-width: 550px;

  margin: 30px auto;
  padding: 35px 25px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  text-align: center;

  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
}

.posts-state h3 {
  margin-bottom: 10px;

  color: var(--secondary-color);
}

.posts-state p {
  color: #666;

  line-height: 1.6;
}

/* =========================
   Loading Spinner
========================= */

.spinner {
  width: 42px;
  height: 42px;

  margin: 0 auto 18px;

  border: 4px solid var(--border-color);
  border-top-color: var(--primary-color);
  border-radius: 50%;

  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

/* =========================
   Error State
========================= */

.error-state {
  border-left: 4px solid #dc3545;
}

.error-state h3 {
  color: #dc3545;
}

/* =========================
   Post Card
========================= */

.post-card {
  display: flex;
  flex-direction: column;

  min-height: 230px;

  padding: 25px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);

  transition: var(--transition);
}

.post-card:hover {
  transform: translateY(-5px);

  border-color: var(--primary-color);

  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.post-card h3 {
  margin-bottom: 15px;

  color: var(--secondary-color);

  font-size: 1.15rem;
  line-height: 1.4;

  text-transform: capitalize;
}

.post-card p {
  color: #666;

  font-size: 0.95rem;
  line-height: 1.7;
}

/* =========================
   Post Actions
========================= */

.post-actions {
  display: flex;
  align-items: center;
  gap: 8px;

  margin-top: auto;
  padding-top: 20px;
}

/* =========================
   View Details
========================= */

.post-actions a {
  display: inline-block;

  padding: 8px 14px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border-radius: var(--border-radius);

  font-size: 0.85rem;
  font-weight: 600;

  text-decoration: none;

  transition: var(--transition);
}

.post-actions a:hover {
  background-color: var(--secondary-color);

  transform: translateY(-2px);
}

/* =========================
   Remove Favorite Button
========================= */

.favorite-btn {
  padding: 8px 14px;

  background-color: #dc3545;
  color: var(--white-color);

  border: 1px solid #dc3545;
  border-radius: var(--border-radius);

  font-size: 0.85rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

.favorite-btn:hover {
  background-color: #b02a37;
  border-color: #b02a37;

  transform: translateY(-2px);
}

/* =========================
   Tablet
========================= */

@media (max-width: 768px) {
  #favorites {
    padding: 55px 20px;
  }

  #favorites > h2 {
    font-size: 1.9rem;
  }

  .posts-grid {
    grid-template-columns: repeat(2, 1fr);

    gap: 20px;
  }

  .post-card {
    min-height: 210px;

    padding: 22px;
  }
}

/* =========================
   Mobile
========================= */

@media (max-width: 480px) {
  #favorites {
    padding: 45px 15px;
  }

  #favorites > h2 {
    margin-bottom: 25px;

    font-size: 1.7rem;
  }

  .posts-grid {
    grid-template-columns: 1fr;

    gap: 18px;
  }

  .post-card {
    min-height: auto;

    padding: 20px;
  }

  .post-card h3 {
    font-size: 1.05rem;
  }

  .post-card p {
    font-size: 0.9rem;
  }

  .post-actions {
    flex-wrap: wrap;
  }

  .posts-state {
    margin: 20px auto;

    padding: 30px 20px;
  }
}
</style>
