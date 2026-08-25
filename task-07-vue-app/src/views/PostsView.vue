<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { storeToRefs } from 'pinia'

import PostsCard from '@/components/PostsCard.vue'

import { useFetch } from '@/composable/usePosts'
import { usePostStore } from '@/stores/posts'

const route = useRoute()
const router = useRouter()

const deleteError = ref('')
const postStore = usePostStore()

const {
  posts,
  postsLoading: loading,
  postsError: error,
  postsStatus: status,
  pagination,
} = storeToRefs(postStore)

const { load, remove } = useFetch(posts, loading, error, status, pagination)
const currentPage = ref(1)
const searchQuery = ref(route.query.q || '')

function loadPosts() {
  const params = new URLSearchParams()

  params.set('per_page', '8')
  params.set('page', currentPage.value)

  if (searchQuery.value.trim()) {
    params.set('search', searchQuery.value.trim())
  }

  load(`?${params.toString()}`)
}

watch(searchQuery, (newValue) => {
  currentPage.value = 1

  router.replace({
    query: newValue
      ? {
          q: newValue,
        }
      : {},
  })

  loadPosts()
})
function nextPage() {
  if (currentPage.value < pagination.value.last_page) {
    currentPage.value++
    loadPosts()
  }
}

function previousPage() {
  if (currentPage.value > 1) {
    currentPage.value--
    loadPosts()
  }
}

async function deletePost(id) {
  deleteError.value = ''

  const result = await remove(id)

  if (result.success) {
    posts.value = posts.value.filter((post) => post.id !== id)
    return
  }

  if (result.status === 403) {
    deleteError.value = 'You can only delete your own posts.'
  } else if (result.status === 401) {
    deleteError.value = 'You must be logged in to delete a post.'
  } else {
    deleteError.value = 'Failed to delete post. Please try again.'
  }
}

onMounted(() => {
  loadPosts()
})
</script>

<template>
  <PostsCard
    v-model="searchQuery"
    :posts="posts || []"
    :loading="loading"
    :error="error"
    :delete-error="deleteError"
    @retry="loadPosts"
    @delete="deletePost"
    @clear-delete-error="deleteError = ''"
  />
  <div v-if="pagination.last_page > 1" class="pagination">
    <button :disabled="currentPage === 1" @click="previousPage">Previous</button>

    <span> Page {{ currentPage }} of {{ pagination.last_page }} </span>

    <button :disabled="currentPage === pagination.last_page" @click="nextPage">Next</button>
  </div>
</template>
<style scoped>
/* =========================
   Pagination
========================= */

.pagination {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 18px;

  margin: 10px auto 50px;
  padding: 0 20px;
}

.pagination button {
  min-width: 105px;

  padding: 10px 18px;

  background-color: var(--primary-color);
  color: var(--white-color);

  border: 1px solid var(--primary-color);
  border-radius: var(--border-radius);

  font-family: inherit;
  font-size: 0.9rem;
  font-weight: 600;

  cursor: pointer;

  transition: var(--transition);
}

.pagination button:hover:not(:disabled) {
  background-color: var(--secondary-color);
  border-color: var(--secondary-color);

  transform: translateY(-2px);
}

.pagination button:disabled {
  background-color: #d6d6d6;
  color: #888;

  border-color: #d6d6d6;

  cursor: not-allowed;

  opacity: 0.7;
}

.pagination span {
  min-width: 100px;

  color: var(--secondary-color);

  font-size: 0.95rem;
  font-weight: 600;

  text-align: center;
}

/* =========================
   Mobile
========================= */

@media (max-width: 480px) {
  .pagination {
    gap: 10px;

    margin-bottom: 35px;
    padding: 0 15px;
  }

  .pagination button {
    min-width: auto;

    padding: 9px 13px;

    font-size: 0.8rem;
  }

  .pagination span {
    min-width: auto;

    font-size: 0.85rem;
  }
}
</style>
