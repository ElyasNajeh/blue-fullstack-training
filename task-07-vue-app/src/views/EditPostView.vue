<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL
const postId = route.params.id

const title = ref('')
const body = ref('')
const statusValue = ref('')
const categoryId = ref('')

const categories = ref([])

const loading = ref(true)
const updating = ref(false)

const loadError = ref(false)
const updateError = ref(false)
const updateStatus = ref(null)

const forbidden = ref(false)
const success = ref(false)

async function loadPost() {
  try {
    loading.value = true
    loadError.value = false
    forbidden.value = false

    const response = await fetch(`${API_BASE_URL}/posts/${postId}`)

    if (!response.ok) {
      throw new Error('Failed to load post')
    }

    const result = await response.json()
    const post = result.data

    // Check if the logged-in user owns this post
    if (!authStore.user || post.author?.id !== authStore.user.id) {
      forbidden.value = true
      return
    }

    title.value = post.title
    body.value = post.body
    statusValue.value = post.status
    categoryId.value = post.category?.id ?? ''
  } catch (err) {
    loadError.value = true
    console.log(err)
  } finally {
    loading.value = false
  }
}

async function loadCategories() {
  try {
    const response = await fetch(`${API_BASE_URL}/categories`)

    if (!response.ok) {
      throw new Error('Failed to load categories')
    }

    const result = await response.json()

    categories.value = result.data
  } catch (err) {
    console.log(err)
  }
}

async function handleUpdate() {
  try {
    updating.value = true
    updateError.value = false
    updateStatus.value = null
    success.value = false

    const response = await fetch(`${API_BASE_URL}/posts/${postId}`, {
      method: 'PUT',

      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        Authorization: `Bearer ${authStore.token}`,
      },

      body: JSON.stringify({
        title: title.value.trim(),
        body: body.value.trim(),
        status: statusValue.value,
        category_id: categoryId.value,
      }),
    })

    updateStatus.value = response.status

    if (response.status === 403) {
      forbidden.value = true
      return
    }

    if (response.status === 401) {
      updateError.value = true
      return
    }

    if (!response.ok) {
      throw new Error('Failed to update post')
    }

    success.value = true
  } catch (err) {
    updateError.value = true
    console.log(err)
  } finally {
    updating.value = false
  }
}

function goBack() {
  router.push('/posts')
}

onMounted(async () => {
  await loadPost()

  // ما في داعي نحمل categories إذا أصلًا ممنوع يعدل
  if (!forbidden.value && !loadError.value) {
    await loadCategories()
  }
})
</script>

<template>
  <section class="edit-post">
    <h1>Edit Post</h1>

    <!-- Loading -->
    <div v-if="loading">
      <p>Loading post...</p>
    </div>

    <!-- Not Owner -->
    <div v-else-if="forbidden" class="message error-message">
      <h2>Access Denied</h2>

      <p>You can only edit your own posts.</p>

      <button type="button" @click="goBack">Back to Posts</button>
    </div>

    <!-- Failed to Load -->
    <div v-else-if="loadError" class="message error-message">
      <h2>Something went wrong</h2>

      <p>Failed to load post.</p>

      <button type="button" @click="goBack">Back to Posts</button>
    </div>

    <!-- Edit Form -->
    <form v-else @submit.prevent="handleUpdate">
      <div class="form-group">
        <label for="title">Title</label>

        <input id="title" v-model="title" type="text" required />
      </div>

      <div class="form-group">
        <label for="body">Body</label>

        <textarea id="body" v-model="body" rows="6" required></textarea>
      </div>

      <div class="form-group">
        <label for="status">Status</label>

        <select id="status" v-model="statusValue" required>
          <option value="draft">Draft</option>
          <option value="published">Published</option>
        </select>
      </div>

      <div class="form-group">
        <label for="category">Category</label>

        <select id="category" v-model="categoryId" required>
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>

      <button type="submit" :disabled="updating">
        {{ updating ? 'Updating...' : 'Update Post' }}
      </button>

      <!-- Success -->
      <div v-if="success" class="message success-message">
        <p>Post updated successfully.</p>

        <button type="button" class="back-btn" @click="goBack">Back to Posts</button>
      </div>

      <!-- Unauthorized -->
      <div v-if="updateError && updateStatus === 401" class="message error-message">
        You must be logged in to update a post.
      </div>

      <!-- Other Error -->
      <div v-if="updateError && updateStatus !== 401" class="message error-message">
        Failed to update post. Please try again.
      </div>
    </form>
  </section>
</template>
<style scoped>
/* =========================
   Edit Post
========================= */

.edit-post {
  width: 100%;
  max-width: 800px;
  min-height: 500px;

  margin: 0 auto;
  padding: 70px 30px;
}

.success-message p {
  margin-bottom: 12px;
}

.back-btn {
  padding: 10px 18px;

  background-color: #0f5132;
  color: var(--white-color);

  border: none;
  border-radius: var(--border-radius);

  font-family: inherit;
  font-size: 0.9rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

.back-btn:hover {
  opacity: 0.9;
  transform: translateY(-2px);
}

.edit-post > h1 {
  margin-bottom: 35px;

  color: var(--secondary-color);

  font-size: 2.2rem;
  font-weight: 700;

  text-align: center;
}

/* =========================
   Form
========================= */

.edit-post form {
  padding: 35px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
}

/* =========================
   Form Groups
========================= */

.form-group {
  display: flex;
  flex-direction: column;

  margin-bottom: 22px;
}

.form-group label {
  margin-bottom: 8px;

  color: var(--secondary-color);

  font-size: 0.95rem;
  font-weight: 600;
}

.form-group input,
.form-group textarea,
.form-group select {
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

.form-group textarea {
  resize: vertical;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
  border-color: var(--primary-color);

  box-shadow: 0 0 0 3px rgba(0, 174, 239, 0.12);
}

/* =========================
   Update Button
========================= */

.edit-post form > button {
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

.edit-post form > button:hover:not(:disabled) {
  background-color: var(--secondary-color);

  transform: translateY(-2px);
}

.edit-post form > button:disabled {
  opacity: 0.6;

  cursor: not-allowed;
}

/* =========================
   Messages
========================= */

.message {
  margin-top: 20px;
  padding: 16px 18px;

  border-radius: var(--border-radius);

  font-size: 0.95rem;
  line-height: 1.6;
}

/* =========================
   Success
========================= */

.success-message {
  background-color: #d1e7dd;
  color: #0f5132;

  border: 1px solid #badbcc;
}

/* =========================
   Error / Access Denied
========================= */

.error-message {
  background-color: #f8d7da;
  color: #842029;

  border: 1px solid #f5c2c7;
}

.error-message h2 {
  margin-bottom: 8px;

  font-size: 1.2rem;
}

.error-message p {
  margin-bottom: 15px;
}

.error-message button {
  padding: 10px 18px;

  background-color: #842029;
  color: var(--white-color);

  border: none;
  border-radius: var(--border-radius);

  font-family: inherit;
  font-size: 0.9rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

.error-message button:hover {
  opacity: 0.9;

  transform: translateY(-2px);
}

/* =========================
   Loading
========================= */

.edit-post > div:not(.message) {
  padding: 35px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  text-align: center;

  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
}

.edit-post > div:not(.message) p {
  color: #666;

  font-size: 0.95rem;
}

/* =========================
   Tablet
========================= */

@media (max-width: 768px) {
  .edit-post {
    padding: 55px 20px;
  }

  .edit-post > h1 {
    font-size: 1.9rem;
  }

  .edit-post form {
    padding: 28px;
  }
}

/* =========================
   Mobile
========================= */

@media (max-width: 480px) {
  .edit-post {
    padding: 45px 15px;
  }

  .edit-post > h1 {
    margin-bottom: 25px;

    font-size: 1.7rem;
  }

  .edit-post form {
    padding: 22px 18px;
  }

  .form-group input,
  .form-group textarea,
  .form-group select {
    font-size: 0.9rem;
  }
}
</style>
