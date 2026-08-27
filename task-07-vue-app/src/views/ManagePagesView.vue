<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL

const pages = ref([])
const loading = ref(false)
const error = ref(false)

async function loadPages() {
  try {
    loading.value = true
    error.value = false

    const response = await fetch(`${API_BASE_URL}/manage/pages`, {
      headers: {
        Accept: 'application/json',
        Authorization: `Bearer ${authStore.token}`,
      },
    })

    if (!response.ok) {
      throw new Error('Failed to load pages')
    }

    const result = await response.json()

    pages.value = result.data
  } catch (err) {
    error.value = true
    console.log(err)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadPages()
})
</script>

<template>
  <section class="manage-pages">
    <div class="header">
      <h1>Manage Pages</h1>

      <RouterLink to="/manage/pages/create"> Create Page </RouterLink>
    </div>

    <p v-if="loading">Loading pages...</p>

    <p v-else-if="error">Failed to load pages.</p>

    <p v-else-if="pages.length === 0">No pages available.</p>

    <div v-else>
      <article v-for="page in pages" :key="page.id">
        <h2>{{ page.title }}</h2>

        <p>Slug: {{ page.slug }}</p>

        <p>Status: {{ page.status }}</p>

        <RouterLink :to="`/manage/pages/${page.id}/edit`"> Edit </RouterLink>
      </article>
    </div>
  </section>
</template>
<style scoped>
.manage-pages {
  width: 100%;
  max-width: 1100px;
  min-height: 550px;

  margin: 0 auto;
  padding: 60px 30px;
}

/* =========================
   Header
========================= */

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;

  margin-bottom: 35px;
}

.header h1 {
  color: var(--secondary-color);

  font-size: 2rem;
  font-weight: 700;
}

.header a {
  display: inline-flex;
  align-items: center;
  justify-content: center;

  padding: 11px 20px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border: 1px solid var(--primary-color);
  border-radius: var(--border-radius);

  font-size: 0.9rem;
  font-weight: 600;
  text-decoration: none;

  transition: var(--transition);
}

.header a:hover {
  background-color: var(--secondary-color);
  border-color: var(--secondary-color);

  transform: translateY(-2px);
}

/* =========================
   Pages Grid
========================= */

.manage-pages > div:last-child:not(.header) {
  display: grid;
  grid-template-columns: repeat(2, 1fr);

  gap: 20px;
}

/* =========================
   Page Card
========================= */

.manage-pages article {
  padding: 25px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);

  transition: var(--transition);
}

.manage-pages article:hover {
  border-color: var(--primary-color);

  transform: translateY(-3px);

  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.manage-pages article h2 {
  margin-bottom: 15px;

  color: var(--secondary-color);

  font-size: 1.2rem;
}

.manage-pages article p {
  margin-bottom: 8px;

  color: #666;

  font-size: 0.9rem;
}

.manage-pages article p:nth-of-type(2) {
  margin-bottom: 20px;
}

/* =========================
   Edit Button
========================= */

.manage-pages article a {
  display: inline-flex;
  align-items: center;
  justify-content: center;

  padding: 9px 20px;

  background-color: #6f5bd3;
  color: var(--white-color);

  border: 1px solid #6f5bd3;
  border-radius: var(--border-radius);

  font-size: 0.9rem;
  font-weight: 600;
  text-decoration: none;

  transition: var(--transition);
}

.manage-pages article a:hover {
  background-color: #5b49bd;
  border-color: #5b49bd;

  transform: translateY(-2px);
}

/* =========================
   Loading / Error / Empty
========================= */

.manage-pages > p {
  max-width: 550px;

  margin: 40px auto;
  padding: 30px;

  background-color: var(--white-color);
  color: #666;

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  text-align: center;

  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
}

/* =========================
   Tablet
========================= */

@media (max-width: 768px) {
  .manage-pages {
    padding: 50px 20px;
  }

  .header h1 {
    font-size: 1.8rem;
  }

  .manage-pages > div:last-child:not(.header) {
    grid-template-columns: 1fr;
  }
}

/* =========================
   Mobile
========================= */

@media (max-width: 480px) {
  .manage-pages {
    padding: 40px 15px;
  }

  .header {
    flex-direction: column;
    align-items: stretch;
  }

  .header h1 {
    font-size: 1.6rem;
    text-align: center;
  }

  .header a {
    width: 100%;
  }

  .manage-pages article {
    padding: 20px;
  }
}
</style>
