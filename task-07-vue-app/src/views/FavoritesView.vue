<script setup>
import { onMounted, computed } from 'vue'
import { useFetch } from '@/composable/usePosts'
import { storeToRefs } from 'pinia'

import FavoritesPosts from '@/components/FavoritesPosts.vue'
import { usePostStore } from '@/stores/posts'

const postStore = usePostStore()

const {
  posts,
  postsLoading: loading,
  postsError: error,
  postsStatus: status,
  favoriteIDs,
} = storeToRefs(postStore)

const { load } = useFetch(posts, loading, error, status)

function loadPosts() {
  load('/?_limit=6')
}

const favoritePosts = computed(() => {
  return (posts.value || []).filter((post) => {
    return favoriteIDs.value.includes(post.id)
  })
})
onMounted(() => {
  if (posts.value.length === 0) {
    loadPosts()
  }
})
</script>

<template>
  <FavoritesPosts :posts="favoritePosts" :loading="loading" :error="error" />
</template>
