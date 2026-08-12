<script setup>
import { ref } from 'vue'
import { storeToRefs } from 'pinia'

import { usePostStore } from '@/stores/posts'
import { useFetch } from '@/composable/usePosts'

const postStore = usePostStore()

const {
  createdPost,
  createPostLoading: loading,
  createPostError: error,
  createPostStatus: status,
} = storeToRefs(postStore)

const { create } = useFetch(createdPost, loading, error, status)
const title = ref('')
const body = ref('')
const userId = ref('')

const titleError = ref('')
const bodyError = ref('')
const userIdError = ref('')

function validateTitle() {
  if (!title.value.trim()) {
    titleError.value = 'Title is required.'
    return false
  }

  if (title.value.trim().length < 5) {
    titleError.value = 'Title must be at least 5 characters.'
    return false
  }

  titleError.value = ''
  return true
}

function validateBody() {
  if (!body.value.trim()) {
    bodyError.value = 'Body is required.'
    return false
  }

  if (body.value.trim().length < 10) {
    bodyError.value = 'Body must be at least 10 characters.'
    return false
  }

  bodyError.value = ''
  return true
}

function validateUserId() {
  if (!userId.value) {
    userIdError.value = 'User ID is required.'
    return false
  }

  if (Number(userId.value) <= 0) {
    userIdError.value = 'User ID must be a positive number.'
    return false
  }

  userIdError.value = ''
  return true
}
function validateForm() {
  const isTitleValid = validateTitle()
  const isBodyValid = validateBody()
  const isUserIdValid = validateUserId()

  return isTitleValid && isBodyValid && isUserIdValid
}
async function handleSubmit() {
  createdPost.value = null

  if (!validateForm()) {
    return
  }

  const success = await create({
    title: title.value.trim(),
    body: body.value.trim(),
    userId: Number(userId.value),
  })

  if (success) {
    title.value = ''
    body.value = ''
    userId.value = ''
  }
}
</script>

<template>
  <section class="create-post">
    <h1>Create Post</h1>

    <form class="create-post-form" @submit.prevent="handleSubmit">
      <div class="form-group">
        <label for="title">Title</label>

        <input
          id="title"
          v-model="title"
          type="text"
          placeholder="Enter post title"
          :class="{ 'input-error': titleError }"
          @input="validateTitle"
        />

        <p v-if="titleError" class="field-error">
          {{ titleError }}
        </p>
      </div>
      <div class="form-group">
        <label for="body">Body</label>

        <textarea
          id="body"
          v-model="body"
          placeholder="Enter post content"
          rows="6"
          maxlength="500"
          :class="{ 'input-error': bodyError }"
          @input="validateBody"
        ></textarea>

        <div class="field-info">
          <p v-if="bodyError" class="field-error">
            {{ bodyError }}
          </p>

          <span class="character-count"> {{ body.length }} / 500 </span>
        </div>
      </div>

      <div class="form-group">
        <label for="userId">User ID</label>

        <input
          id="userId"
          v-model="userId"
          type="number"
          placeholder="Enter user ID"
          :class="{ 'input-error': userIdError }"
          @input="validateUserId"
        />

        <p v-if="userIdError" class="field-error">
          {{ userIdError }}
        </p>
      </div>
      <button type="submit" class="submit-btn" :disabled="loading">
        {{ loading ? 'Creating...' : 'Create Post' }}
      </button>
      <div v-if="createdPost" class="form-message success-message">
        <h3>Post Created Successfully!</h3>

        <p>
          Your post was created with ID:
          <strong>{{ createdPost.id }}</strong>
        </p>
      </div>
      <div v-if="error" class="form-message error-message">
        <h3>Failed to Create Post</h3>

        <p>Something went wrong. Please try again.</p>

        <button type="button" class="retry-btn" :disabled="loading" @click="handleSubmit">
          {{ loading ? 'Retrying...' : 'Retry' }}
        </button>
      </div>
    </form>
  </section>
</template>

<style scoped>
/* =========================
   Create Post
========================= */

.create-post {
  width: 100%;
  max-width: 800px;
  min-height: 500px;

  margin: 0 auto;
  padding: 70px 30px;
}

.create-post > h1 {
  margin-bottom: 35px;

  color: var(--secondary-color);

  font-size: 2.2rem;
  font-weight: 700;

  text-align: center;
}

/* =========================
   Form Messages
========================= */

.form-message {
  margin-top: 20px;
  padding: 16px 18px;

  border-radius: var(--border-radius);

  font-size: 0.9rem;
  line-height: 1.5;
}

.form-message h3 {
  margin-bottom: 5px;

  font-size: 1rem;
}

/* =========================
   Success Message
========================= */

.success-message {
  background-color: #d1e7dd;
  color: #0f5132;

  border: 1px solid #badbcc;
}

/* =========================
   Error Message
========================= */

.error-message {
  background-color: #f8d7da;
  color: #842029;

  border: 1px solid #f5c2c7;
}

.retry-btn {
  margin-top: 12px;
  padding: 9px 18px;

  background-color: #dc3545;
  color: var(--white-color);

  border: none;
  border-radius: var(--border-radius);

  font-size: 0.9rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

.retry-btn:hover:not(:disabled) {
  background-color: #bb2d3b;

  transform: translateY(-2px);
}

.retry-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.submit-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
}

.submit-btn:disabled:hover {
  background-color: var(--primary-color);
  transform: none;
}
/* =========================
   Field Information
========================= */

.field-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 15px;

  margin-top: 7px;
}

.field-error {
  margin: 0;

  color: #dc3545;

  font-size: 0.85rem;
  font-weight: 500;
}

.character-count {
  margin-left: auto;

  color: #777;

  font-size: 0.8rem;
}

/* =========================
   Create Post Form
========================= */

.create-post-form {
  padding: 35px;

  background-color: var(--white-color);

  border: 1px solid var(--border-color);
  border-radius: var(--border-radius);

  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
}

/* =========================
   Form Group
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
/* =========================
   Field Validation
========================= */

.form-group input.input-error,
.form-group textarea.input-error {
  border-color: #dc3545;
}

.form-group input.input-error:focus,
.form-group textarea.input-error:focus {
  border-color: #dc3545;

  box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.12);
}

.form-group input,
.form-group textarea {
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
.form-group textarea:focus {
  border-color: var(--primary-color);

  box-shadow: 0 0 0 3px rgba(0, 174, 239, 0.12);
}

/* =========================
   Submit Button
========================= */

.submit-btn {
  width: 100%;

  padding: 12px 20px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border: none;
  border-radius: var(--border-radius);

  font-size: 0.95rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

.submit-btn:hover {
  background-color: var(--secondary-color);

  transform: translateY(-2px);
}

/* =========================
   Tablet
========================= */

@media (max-width: 768px) {
  .create-post {
    padding: 55px 20px;
  }

  .create-post > h1 {
    font-size: 1.9rem;
  }

  .create-post-form {
    padding: 28px;
  }
}

/* =========================
   Mobile
========================= */

@media (max-width: 480px) {
  .create-post {
    padding: 45px 15px;
  }

  .create-post > h1 {
    margin-bottom: 25px;

    font-size: 1.7rem;
  }

  .create-post-form {
    padding: 22px 18px;
  }

  .form-group input,
  .form-group textarea {
    font-size: 0.9rem;
  }
}
</style>
