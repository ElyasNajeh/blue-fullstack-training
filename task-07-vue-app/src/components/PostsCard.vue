<script setup>
import { RouterLink } from 'vue-router'
import { defineEmits } from 'vue'
import { storeToRefs } from 'pinia'

import { usePostStore } from '@/stores/posts'

const postStore = usePostStore()

const { favoriteIDs, favoriteCnt } = storeToRefs(postStore)

defineProps({
  posts: {
    type: Array,
    default: () => [],
  },

  loading: {
    type: Boolean,
    default: false,
  },

  error: {
    type: Boolean,
    default: false,
  },
  deleteError: {
    type: String,
    default: '',
  },
})

const searchQuery = defineModel()

const emit = defineEmits(['retry', 'delete', 'clear-delete-error'])
</script>
<template>
  <section id="posts">
    <h2>Latest Posts</h2>

    <div class="posts-navigation">
      <RouterLink to="/posts/create" class="create-post-link"> Create Post </RouterLink>

      <RouterLink to="/favorites" class="favorites-link">
        Favorites
        <span>{{ favoriteCnt }}</span>
      </RouterLink>
    </div>

    <div class="posts-search">
      <input type="text" v-model="searchQuery" placeholder="Search posts by title..." />
    </div>

    <div v-if="loading" class="posts-state">
      <div class="spinner"></div>
      <p>Loading posts...</p>
    </div>

    <div v-else-if="error" class="posts-state error-state">
      <h3>Something went wrong</h3>
      <p>Failed to load posts. Please try again.</p>

      <button @click="emit('retry')">Retry</button>
    </div>

    <div v-else-if="posts.length === 0" class="posts-state">
      <h3>No Posts Available</h3>
      <p>There are currently no posts to display.</p>
    </div>
    <div v-if="deleteError" class="delete-error">
      <p>{{ deleteError }}</p>

      <button @click="emit('clear-delete-error')">Back to Posts</button>
    </div>
    <div v-else class="posts-grid">
      <article v-for="post in posts" :key="post.id" class="post-card">
        <h3>{{ post.title }}</h3>

        <p>{{ post.body }}</p>

        <div class="post-info">
          <span>
            <strong>Status:</strong>
            {{ post.status }}
          </span>

          <span>
            <strong>Category:</strong>
            {{ post.category?.name || 'No category' }}
          </span>

          <span>
            <strong>Author:</strong>
            {{ post.author?.name || 'Unknown' }}
          </span>
        </div>

        <div class="post-actions">
          <RouterLink :to="`/posts/${post.id}`"> View Details </RouterLink>

          <RouterLink :to="`/posts/${post.id}/edit`" class="update-btn"> Update </RouterLink>

          <button
            class="favorite-btn"
            :class="{ favorite: favoriteIDs.includes(post.id) }"
            @click="postStore.toggleFavorite(post.id)"
          >
            {{ favoriteIDs.includes(post.id) ? 'Remove from Favorite' : 'Add to Favorite' }}
          </button>

          <button class="delete-btn" @click="emit('delete', post.id)">Delete</button>
        </div>
      </article>
    </div>
  </section>
</template>
<style scoped>
/* =========================
   Posts Section
========================= */

#posts {
  width: 100%;
  max-width: 1200px;

  margin: 0 auto;
  padding: 70px 30px;

  background-color: var(--background-color);
}

#posts > h2 {
  margin-bottom: 35px;

  color: var(--secondary-color);

  font-size: 2.2rem;
  font-weight: 700;

  text-align: center;
}

/* =========================
   Delete Error
========================= */

.delete-error {
  margin-bottom: 20px;
  padding: 14px 18px;

  background-color: #f8d7da;
  color: #842029;

  border: 1px solid #f5c2c7;
  border-radius: var(--border-radius);

  font-size: 0.95rem;
  font-weight: 500;
}

.delete-error p {
  margin-bottom: 12px;
}

.delete-error button {
  padding: 9px 16px;

  background-color: #842029;
  color: var(--white-color);

  border: none;
  border-radius: var(--border-radius);

  font-size: 0.9rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

.delete-error button:hover {
  opacity: 0.9;
  transform: translateY(-2px);
}

/* =========================
   Posts Navigation
========================= */

.posts-navigation {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 10px;

  margin-bottom: 20px;
}

.create-post-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;

  padding: 10px 16px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border: 1px solid var(--primary-color);
  border-radius: var(--border-radius);

  font-size: 0.9rem;
  font-weight: 600;
  text-decoration: none;

  transition: var(--transition);
}

.create-post-link:hover {
  background-color: var(--secondary-color);
  border-color: var(--secondary-color);

  transform: translateY(-2px);
}

.favorites-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;

  padding: 10px 16px;

  background-color: var(--white-color);
  color: var(--primary-color);

  border: 1px solid var(--primary-color);
  border-radius: var(--border-radius);

  font-size: 0.9rem;
  font-weight: 600;
  text-decoration: none;

  transition: var(--transition);
}

.favorites-link span {
  display: flex;
  align-items: center;
  justify-content: center;

  min-width: 24px;
  height: 24px;

  padding: 0 7px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border-radius: 50%;

  font-size: 0.8rem;
}

.favorites-link:hover {
  background-color: var(--primary-color);
  color: var(--white-color);

  transform: translateY(-2px);
}

.favorites-link:hover span {
  background-color: var(--white-color);
  color: var(--primary-color);
}

/* =========================
   Posts Search
========================= */

.posts-search {
  width: 100%;
  max-width: 600px;

  margin: 0 auto 35px;
}

.posts-search input {
  width: 100%;

  padding: 13px 18px;

  background-color: var(--white-color);
  color: var(--text-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  font-size: 1rem;

  outline: none;

  transition: var(--transition);
}

.posts-search input::placeholder {
  color: #999;
}

.posts-search input:focus {
  border-color: var(--primary-color);

  box-shadow: 0 0 0 3px rgba(0, 174, 239, 0.12);
}

/* =========================
   Posts Grid
========================= */

.posts-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));

  gap: 25px;
}

/* =========================
   Post Card
========================= */

.post-card {
  display: flex;
  flex-direction: column;

  min-width: 0;
  min-height: 280px;

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

.post-info {
  display: flex;
  flex-direction: column;
  gap: 6px;

  margin-top: 15px;

  color: #666;

  font-size: 0.85rem;
}

.post-info strong {
  color: var(--secondary-color);
}

/* =========================
   Post Actions
========================= */

.post-actions {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));

  gap: 10px;

  margin-top: auto;
  padding-top: 22px;
}

.post-actions a,
.post-actions button {
  display: flex;
  align-items: center;
  justify-content: center;

  width: 100%;
  min-width: 0;
  min-height: 42px;

  padding: 10px 8px;

  border-radius: var(--border-radius);

  font-family: inherit;
  font-size: 0.85rem;
  font-weight: 600;
  line-height: 1.2;
  text-align: center;
  text-decoration: none;

  cursor: pointer;

  transition: var(--transition);
}

/* =========================
   View Details
========================= */

.post-actions a:not(.update-btn) {
  background-color: var(--primary-color);
  color: var(--white-color);

  border: 1px solid var(--primary-color);
}

.post-actions a:not(.update-btn):hover {
  background-color: var(--secondary-color);
  border-color: var(--secondary-color);

  transform: translateY(-2px);
}

/* =========================
   Update Button
========================= */

.post-actions .update-btn {
  background-color: #6f5bd3;
  color: var(--white-color);

  border: 1px solid #6f5bd3;
}

.post-actions .update-btn:hover {
  background-color: #5b49bd;
  border-color: #5b49bd;

  transform: translateY(-2px);
}

/* =========================
   Favorite Button
========================= */

.favorite-btn {
  background-color: var(--white-color);
  color: var(--primary-color);

  border: 1px solid var(--primary-color);
}

.favorite-btn:hover {
  background-color: var(--primary-color);
  color: var(--white-color);

  transform: translateY(-2px);
}

.favorite-btn.favorite {
  background-color: #dc3545;
  color: var(--white-color);

  border-color: #dc3545;
}

.favorite-btn.favorite:hover {
  background-color: #bb2d3b;
  border-color: #bb2d3b;
}

/* =========================
   Delete Button
========================= */

.delete-btn {
  background-color: #dc3545;
  color: var(--white-color);

  border: 1px solid #dc3545;
}

.delete-btn:hover {
  background-color: #bb2d3b;
  border-color: #bb2d3b;

  transform: translateY(-2px);
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

.error-state button {
  margin-top: 18px;
  padding: 10px 24px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border: none;
  border-radius: var(--border-radius);

  font-size: 0.95rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

.error-state button:hover {
  background-color: #0096d6;

  transform: translateY(-2px);
}

/* =========================
   Tablet
========================= */

@media (max-width: 768px) {
  #posts {
    padding: 55px 20px;
  }

  #posts > h2 {
    font-size: 1.9rem;
  }

  .posts-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 20px;
  }

  .post-card {
    min-height: 270px;

    padding: 22px;
  }

  .posts-search {
    max-width: 500px;

    margin-bottom: 30px;
  }

  .posts-search input {
    padding: 12px 16px;

    font-size: 0.95rem;
  }

  .post-actions {
    gap: 8px;
  }

  .post-actions a,
  .post-actions button {
    padding: 9px 6px;

    font-size: 0.8rem;
  }
}

/* =========================
   Mobile
========================= */

@media (max-width: 480px) {
  #posts {
    padding: 45px 15px;
  }

  #posts > h2 {
    margin-bottom: 25px;

    font-size: 1.7rem;
  }

  .posts-navigation {
    justify-content: center;
    flex-wrap: wrap;
  }

  .posts-search {
    margin-bottom: 25px;
  }

  .posts-search input {
    padding: 11px 14px;

    font-size: 0.9rem;
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
    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 8px;
  }

  .post-actions a,
  .post-actions button {
    min-height: 40px;

    padding: 9px 6px;

    font-size: 0.78rem;
  }

  .posts-state {
    margin: 20px auto;
    padding: 30px 20px;
  }
}
</style>
