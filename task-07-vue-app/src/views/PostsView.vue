<script setup>
import { ref, onMounted, computed, watch } from 'vue'
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
} = storeToRefs(postStore)

// أضفنا remove
const { load, remove } = useFetch(posts, loading, error, status)

const searchQuery = ref(route.query.q || '')

watch(searchQuery, (newValue) => {
  router.replace({
    query: {
      q: newValue,
    },
  })
})

function loadPosts() {
  load('?per_page=8')
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
  <PostsCard
    v-model="searchQuery"
    :posts="filteredPosts"
    :loading="loading"
    :error="error"
    :delete-error="deleteError"
    @retry="loadPosts"
    @delete="deletePost"
    @clear-delete-error="deleteError = ''"
  />
</template>
