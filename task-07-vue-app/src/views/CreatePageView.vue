<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL

const title = ref('')
const slug = ref('')
const content = ref('')
const statusValue = ref('draft')

const loading = ref(false)
const error = ref('')
const validationErrors = ref({})

async function createPage() {
  try {
    loading.value = true
    error.value = ''
    validationErrors.value = {}

    const response = await fetch(`${API_BASE_URL}/pages`, {
      method: 'POST',

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

    if (response.status === 401) {
      error.value = 'You must be logged in.'
      return
    }

    if (!response.ok) {
      error.value = 'Failed to create page.'
      return
    }

    router.push('/manage/pages')
  } catch (err) {
    error.value = 'Server error. Please try again.'
    console.log(err)
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <section class="page-form">
    <h1>Create Page</h1>

    <form @submit.prevent="createPage">
      <div>
        <label for="title">Title</label>

        <input id="title" v-model="title" type="text" />

        <p v-if="validationErrors.title">
          {{ validationErrors.title[0] }}
        </p>
      </div>

      <div>
        <label for="slug">Slug</label>

        <input id="slug" v-model="slug" type="text" placeholder="about-us" />

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

      <button type="submit" :disabled="loading">
        {{ loading ? 'Creating...' : 'Create Page' }}
      </button>

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

.page-form form {
  padding: 35px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
}

/* Form Groups */
.page-form form > div {
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

/* Inputs */
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

/* Validation Errors */
.page-form form > div > p {
  margin-top: 7px;

  color: #dc3545;

  font-size: 0.85rem;
  font-weight: 500;
}

/* Create Button */
.page-form form > button {
  width: 100%;

  padding: 12px 20px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border: none;
  border-radius: var(--border-radius);

  font-family: inherit;
  font-size: 0.95rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

.page-form form > button:hover:not(:disabled) {
  background-color: var(--secondary-color);

  transform: translateY(-2px);
}

.page-form form > button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* General Error */
.page-form form > p {
  margin-top: 18px;
  padding: 12px 15px;

  background-color: #f8d7da;
  color: #842029;

  border: 1px solid #f5c2c7;
  border-radius: var(--border-radius);

  font-size: 0.9rem;
}

/* Tablet */
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

/* Mobile */
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
}
</style>
