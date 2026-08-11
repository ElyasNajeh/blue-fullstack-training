<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'

import PostsCard from '@/components/PostsCard.vue'

import { useFetch } from '@/composable/usePosts'

const route = useRoute()
const router = useRouter()
const searchQuery = ref(route.query.q || '')
watch(searchQuery, (newValue) => {
  router.replace({
    query: {
      q: newValue,
    },
  })
})
const { data: posts, loading, error, status, load } = useFetch()

function loadPosts() {
  load(`/?_limit=6`)
}

const filteredPosts = computed(() => {
  return (posts.value || []).filter((post) => {
    return post.title.toLowerCase().includes(searchQuery.value.toLowerCase())
  })
})

onMounted(() => {
  loadPosts()
})
</script>

<template>
  <section id="posts">
    <h2>Latest Posts</h2>

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
      <button @click="loadPosts">Retry</button>
    </div>

    <div v-else-if="!posts || posts.length === 0" class="posts-state">
      <h3>No Posts Available</h3>
      <p>There are currently no posts to display.</p>
    </div>

    <div v-else class="posts-grid">
      <PostsCard
        v-for="post in filteredPosts"
        :key="post.id"
        :id="post.id"
        :title="post.title"
        :body="post.body"
      />
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
    grid-template-columns: repeat(2, 1fr);

    gap: 20px;
  }

  .posts-search {
    max-width: 500px;

    margin-bottom: 30px;
  }

  .posts-search input {
    padding: 12px 16px;

    font-size: 0.95rem;
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

  .posts-grid {
    grid-template-columns: 1fr;

    gap: 18px;
  }

  .posts-state {
    margin: 20px auto;
    padding: 30px 20px;
  }
  .posts-search {
    margin-bottom: 25px;
  }

  .posts-search input {
    padding: 11px 14px;

    font-size: 0.9rem;
  }
}
</style>
