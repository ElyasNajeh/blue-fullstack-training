<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { storeToRefs } from 'pinia'

import PostsCard from '@/components/PostsCard.vue'

import { useFetch } from '@/composable/usePosts'
import { usePostStore } from '@/stores/posts'

const route = useRoute()
const router = useRouter()

const postStore = usePostStore()

const {
  posts,
  postsLoading: loading,
  postsError: error,
  postsStatus: status,
} = storeToRefs(postStore)

const { load } = useFetch(posts, loading, error, status)

const searchQuery = ref(route.query.q || '')

watch(searchQuery, (newValue) => {
  router.replace({
    query: {
      q: newValue,
    },
  })
})

function loadPosts() {
  load(`/?_limit=6`)
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
    @retry="loadPosts"
  />
</template>
