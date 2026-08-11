<script setup>
import { useRoute, RouterLink } from 'vue-router'
import { ref, onMounted, computed } from 'vue'

import { useFetch } from '@/composable/usePosts'

const route = useRoute()
const postId = ref(route.params.id)

const invalidId = ref(false)

const { data: post, loading, error, status, load } = useFetch()

const notFound = computed(() => {
  return status.value === 404
})

function loadPost() {
  if (!/^\d+$/.test(postId.value)) {
    invalidId.value = true
    return
  }

  load(`/${postId.value}`)
}

onMounted(() => {
  loadPost()
})
</script>

<template>
  <section class="post-details">
    <h1>Post Details</h1>

    <!-- Loading State -->
    <div v-if="loading" class="post-state">
      <div class="spinner"></div>
      <p>Loading post...</p>
    </div>

    <!-- Invalid ID -->
    <div v-else-if="invalidId" class="post-state error-state">
      <h3>Invalid Post ID</h3>
      <p>The post ID must be a valid number.</p>
    </div>

    <!-- Post Not Found -->
    <div v-else-if="notFound" class="post-state error-state">
      <h3>Post Not Found</h3>
      <p>The requested post does not exist.</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="post-state error-state">
      <h3>Something went wrong</h3>
      <p>Failed to load the post. Please try again.</p>

      <button @click="loadPost">Retry</button>
    </div>

    <!-- Post Details -->
    <article v-else-if="post" class="post-content">
      <span>Post #{{ post.id }}</span>

      <h2>{{ post.title }}</h2>

      <p>{{ post.body }}</p>
    </article>

    <RouterLink to="/posts" class="back-link"> Back to Posts </RouterLink>
  </section>
</template>
<style scoped>
/* =========================
   Post Details
========================= */

.post-details {
  width: 100%;
  max-width: 900px;
  min-height: 500px;

  margin: 0 auto;
  padding: 70px 30px;

  text-align: center;
}

.post-details > h1 {
  margin-bottom: 35px;

  color: var(--secondary-color);

  font-size: 2.2rem;
  font-weight: 700;
}

/* =========================
   Post Content
========================= */

.post-content {
  padding: 35px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  text-align: left;

  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
}

.post-content span {
  display: inline-block;

  margin-bottom: 15px;
  padding: 6px 12px;

  background-color: var(--background-color);
  color: var(--primary-color);

  border-radius: var(--border-radius);

  font-size: 0.85rem;
  font-weight: 600;
}

.post-content h2 {
  margin-bottom: 20px;

  color: var(--secondary-color);

  font-size: 1.6rem;
  line-height: 1.4;

  text-transform: capitalize;
}

.post-content p {
  color: #666;

  font-size: 1rem;
  line-height: 1.8;
}

/* =========================
   Loading / Error State
========================= */

.post-state {
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

.post-state h3 {
  margin-bottom: 10px;

  color: var(--secondary-color);
}

.post-state p {
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
  background-color: var(--secondary-color);

  transform: translateY(-2px);
}

/* =========================
   Back Link
========================= */

.back-link {
  display: inline-block;

  margin-top: 30px;
  padding: 11px 22px;

  background-color: var(--secondary-color);
  color: var(--white-color);

  border-radius: var(--border-radius);

  font-size: 0.95rem;
  font-weight: 600;

  text-decoration: none;

  transition: var(--transition);
}

.back-link:hover {
  background-color: var(--primary-color);

  transform: translateY(-2px);
}

/* =========================
   Tablet
========================= */

@media (max-width: 768px) {
  .post-details {
    padding: 55px 20px;
  }

  .post-details > h1 {
    font-size: 1.9rem;
  }

  .post-content {
    padding: 28px;
  }

  .post-content h2 {
    font-size: 1.4rem;
  }
}

/* =========================
   Mobile
========================= */

@media (max-width: 480px) {
  .post-details {
    min-height: 400px;

    padding: 45px 15px;
  }

  .post-details > h1 {
    margin-bottom: 25px;

    font-size: 1.7rem;
  }

  .post-content {
    padding: 22px 18px;
  }

  .post-content h2 {
    font-size: 1.2rem;
  }

  .post-content p {
    font-size: 0.9rem;
  }

  .post-state {
    margin: 20px auto;
    padding: 30px 20px;
  }

  .back-link {
    margin-top: 25px;

    padding: 10px 18px;

    font-size: 0.9rem;
  }
}
</style>
