<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL
const pageId = route.params.id

const title = ref('')
const slug = ref('')
const content = ref('')
const statusValue = ref('draft')

const loading = ref(true)
const updating = ref(false)
const error = ref('')
const validationErrors = ref({})

async function loadPage() {
  try {
    loading.value = true
    error.value = ''

    const response = await fetch(`${API_BASE_URL}/manage/pages`, {
      headers: {
        Accept: 'application/json',
        Authorization: `Bearer ${authStore.token}`,
      },
    })

    if (!response.ok) {
      throw new Error('Failed to load page')
    }

    const result = await response.json()

    const page = result.data.find((page) => page.id === Number(pageId))

    if (!page) {
      error.value = 'Page not found.'
      return
    }

    title.value = page.title
    slug.value = page.slug
    content.value = page.content
    statusValue.value = page.status
  } catch (err) {
    error.value = 'Failed to load page.'
    console.log(err)
  } finally {
    loading.value = false
  }
}

async function updatePage() {
  try {
    updating.value = true
    error.value = ''
    validationErrors.value = {}

    const response = await fetch(`${API_BASE_URL}/pages/${pageId}`, {
      method: 'PUT',

      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        Authorization: `Bearer ${authStore.token}`,
      },

      body: JSON.stringify({
        title: title.value.trim(),
        slug: slug.value.trim(),
        content: content.value.trim(),
        status: statusValue.value,
      }),
    })

    const result = await response.json()

    if (response.status === 422) {
      validationErrors.value = result.errors
      return
    }

    if (!response.ok) {
      error.value = 'Failed to update page.'
      return
    }

    router.push('/manage/pages')
  } catch (err) {
    error.value = 'Server error. Please try again.'
    console.log(err)
  } finally {
    updating.value = false
  }
}

function goBack() {
  router.push('/manage/pages')
}

onMounted(() => {
  loadPage()
})
</script>

<template>
  <section class="page-form">
    <h1>Edit Page</h1>

    <p v-if="loading">Loading page...</p>

    <div v-else-if="error && !title">
      <p>{{ error }}</p>

      <button type="button" @click="goBack">Back to Pages</button>
    </div>

    <form v-else @submit.prevent="updatePage">
      <div>
        <label for="title">Title</label>

        <input id="title" v-model="title" type="text" />

        <p v-if="validationErrors.title">
          {{ validationErrors.title[0] }}
        </p>
      </div>

      <div>
        <label for="slug">Slug</label>

        <input id="slug" v-model="slug" type="text" />

        <p v-if="validationErrors.slug">
          {{ validationErrors.slug[0] }}
        </p>
      </div>

      <div>
        <label for="content">Content</label>

        <textarea id="content" v-model="content" rows="8"></textarea>

        <p v-if="validationErrors.content">
          {{ validationErrors.content[0] }}
        </p>
      </div>

      <div>
        <label for="status">Status</label>

        <select id="status" v-model="statusValue">
          <option value="draft">Draft</option>
          <option value="published">Published</option>
        </select>

        <p v-if="validationErrors.status">
          {{ validationErrors.status[0] }}
        </p>
      </div>

      <div class="form-actions">
        <button type="button" class="back-btn" @click="goBack">Back</button>

        <button type="submit" class="update-btn" :disabled="updating">
          {{ updating ? 'Updating...' : 'Update Page' }}
        </button>
      </div>

      <p v-if="error">
        {{ error }}
      </p>
    </form>
  </section>
</template>
<style scoped>
.page-form {
  width: 100%;
  max-width: 800px;
  min-height: 550px;

  margin: 0 auto;
  padding: 60px 25px;
}

.page-form > h1 {
  margin-bottom: 30px;

  color: var(--secondary-color);

  font-size: 2rem;
  font-weight: 700;
  text-align: center;
}

/* =========================
   Form
========================= */

.page-form form {
  padding: 35px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
}

.page-form form > div:not(.form-actions) {
  display: flex;
  flex-direction: column;

  margin-bottom: 22px;
}

.page-form label {
  margin-bottom: 8px;

  color: var(--secondary-color);

  font-size: 0.95rem;
  font-weight: 600;
}

/* =========================
   Inputs
========================= */

.page-form input,
.page-form textarea,
.page-form select {
  width: 100%;

  padding: 12px 15px;

  background-color: var(--white-color);
  color: var(--text-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  font-family: inherit;
  font-size: 0.95rem;

  outline: none;

  transition: var(--transition);
}

.page-form textarea {
  min-height: 160px;
  resize: vertical;
}

.page-form input:focus,
.page-form textarea:focus,
.page-form select:focus {
  border-color: var(--primary-color);

  box-shadow: 0 0 0 3px rgba(0, 174, 239, 0.12);
}

/* =========================
   Validation
========================= */

.page-form form > div > p {
  margin-top: 7px;

  color: #dc3545;

  font-size: 0.85rem;
  font-weight: 500;
}

/* =========================
   Actions
========================= */

.form-actions {
  display: flex;
  gap: 12px;

  margin-top: 10px;
}

.form-actions button {
  flex: 1;

  padding: 12px 20px;

  border-radius: var(--border-radius);

  font-family: inherit;
  font-size: 0.95rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

.update-btn {
  background-color: var(--primary-color);
  color: var(--white-color);

  border: 1px solid var(--primary-color);
}

.update-btn:hover:not(:disabled) {
  background-color: var(--secondary-color);
  border-color: var(--secondary-color);

  transform: translateY(-2px);
}

.update-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.back-btn {
  background-color: var(--white-color);
  color: var(--secondary-color);

  border: 1px solid var(--border-color);
}

.back-btn:hover {
  background-color: #f1f3f5;

  transform: translateY(-2px);
}

/* =========================
   General Error
========================= */

.page-form form > p {
  margin-top: 18px;
  padding: 12px 15px;

  background-color: #f8d7da;
  color: #842029;

  border: 1px solid #f5c2c7;
  border-radius: var(--border-radius);

  font-size: 0.9rem;
}

/* =========================
   Loading / Not Found
========================= */

.page-form > p,
.page-form > div {
  padding: 25px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  text-align: center;

  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
}

.page-form > div button {
  margin-top: 15px;
  padding: 10px 20px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border: none;
  border-radius: var(--border-radius);

  font-weight: 600;

  cursor: pointer;
}

/* =========================
   Responsive
========================= */

@media (max-width: 768px) {
  .page-form {
    padding: 50px 20px;
  }

  .page-form > h1 {
    font-size: 1.8rem;
  }

  .page-form form {
    padding: 28px;
  }
}

@media (max-width: 480px) {
  .page-form {
    padding: 40px 15px;
  }

  .page-form > h1 {
    font-size: 1.6rem;
  }

  .page-form form {
    padding: 22px 18px;
  }

  .form-actions {
    flex-direction: column;
  }
}
</style>
