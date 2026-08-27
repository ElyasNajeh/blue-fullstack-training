<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute, RouterLink } from 'vue-router'

import HeroBlock from '@/components/blocks/HeroBlock.vue'
import TextBlock from '@/components/blocks/TextBlock.vue'
import CtaBlock from '@/components/blocks/CtaBlock.vue'

const route = useRoute()

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL

const page = ref(null)
const loading = ref(false)
const notFound = ref(false)
const serverError = ref(false)

const blockComponents = {
  hero: HeroBlock,
  text: TextBlock,
  cta: CtaBlock,
}

function getBlockComponent(type) {
  return blockComponents[type] || null
}

async function loadPage() {
  try {
    loading.value = true
    page.value = null
    notFound.value = false
    serverError.value = false

    const response = await fetch(`${API_BASE_URL}/pages/${route.params.slug}`)

    if (response.status === 404) {
      notFound.value = true
      return
    }

    if (!response.ok) {
      serverError.value = true
      return
    }

    const result = await response.json()

    page.value = result.data
  } catch (error) {
    serverError.value = true
    console.log(error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadPage()
})

watch(
  () => route.params.slug,
  () => {
    loadPage()
  },
)
</script>

<template>
  <section class="dynamic-page">
    <!-- Loading -->
    <div v-if="loading" class="page-state">
      <div class="spinner"></div>
      <p>Loading page...</p>
    </div>

    <!-- Not Found -->
    <div v-else-if="notFound" class="page-state error-state">
      <h1>Page Not Found</h1>

      <p>The requested page does not exist or is not published.</p>

      <RouterLink to="/" class="back-link"> Back to Home </RouterLink>
    </div>

    <!-- Server Error -->
    <div v-else-if="serverError" class="page-state error-state">
      <h1>Something went wrong</h1>

      <p>Failed to load the page. Please try again.</p>

      <button type="button" class="retry-btn" @click="loadPage">Retry</button>
    </div>

    <!-- Page -->
    <article v-else-if="page" class="page-content">
      <h1>{{ page.title }}</h1>

      <!-- Empty Blocks -->
      <p v-if="!page.content_blocks?.length" class="empty-blocks">No content available.</p>

      <!-- Dynamic Blocks -->
      <template v-for="block in page.content_blocks" :key="block.id">
        <component
          :is="getBlockComponent(block.type)"
          v-if="getBlockComponent(block.type)"
          :data="block.data"
        />

        <!-- Unsupported Block -->
        <div v-else class="unsupported-block">Unsupported content block.</div>
      </template>

      <RouterLink to="/" class="back-link"> Back to Home </RouterLink>
    </article>
  </section>
</template>
<style scoped>
/* =========================
   Dynamic Page
========================= */

.dynamic-page {
  width: 100%;
  max-width: 900px;
  min-height: 550px;

  margin: 0 auto;
  padding: 70px 30px;
}

/* =========================
   Page Content
========================= */

.page-content {
  padding: 40px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
}

.page-content h1 {
  margin-bottom: 25px;

  color: var(--secondary-color);

  font-size: 2.2rem;
  font-weight: 700;
}

.page-content p {
  margin-bottom: 30px;

  color: var(--text-color);

  font-size: 1rem;
  line-height: 1.8;

  white-space: pre-line;
}

/* =========================
   Back Link
========================= */

.back-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;

  padding: 10px 20px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border: 1px solid var(--primary-color);
  border-radius: var(--border-radius);

  font-size: 0.9rem;
  font-weight: 600;
  text-decoration: none;

  transition: var(--transition);
}

.back-link:hover {
  background-color: var(--secondary-color);
  border-color: var(--secondary-color);

  transform: translateY(-2px);
}

/* =========================
   Loading / Error States
========================= */

.page-state {
  padding: 40px 30px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  text-align: center;

  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
}

.page-state h1 {
  margin-bottom: 12px;

  color: var(--secondary-color);

  font-size: 1.7rem;
}

.page-state p {
  margin-bottom: 22px;

  color: #666;

  line-height: 1.6;
}

/* =========================
   Error
========================= */

.error-state {
  border-top: 4px solid #dc3545;
}

.error-state h1 {
  color: #dc3545;
}

/* =========================
   Retry
========================= */

.retry-btn {
  padding: 10px 22px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border: none;
  border-radius: var(--border-radius);

  font-family: inherit;
  font-size: 0.9rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

.retry-btn:hover {
  background-color: var(--secondary-color);

  transform: translateY(-2px);
}

/* =========================
   Spinner
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
   Tablet
========================= */

@media (max-width: 768px) {
  .dynamic-page {
    padding: 55px 20px;
  }

  .page-content {
    padding: 30px;
  }

  .page-content h1 {
    font-size: 1.9rem;
  }
}

/* =========================
   Mobile
========================= */

@media (max-width: 480px) {
  .dynamic-page {
    padding: 45px 15px;
  }

  .page-content,
  .page-state {
    padding: 25px 20px;
  }

  .page-content h1 {
    font-size: 1.6rem;
  }

  .back-link,
  .retry-btn {
    width: 100%;
  }
}
</style>
