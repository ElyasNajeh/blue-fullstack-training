<script setup>
import { useRoute } from 'vue-router'
import { ref, onMounted } from 'vue'
import { storeToRefs } from 'pinia'

import { usePostStore } from '@/stores/posts'
import { useFetch } from '@/composable/usePosts'
import PostDetails from '@/components/PostDetails.vue'

const postStore = usePostStore()
const {
  post,
  postLoading: loading,
  postError: error,
  postStatus: status,
  postInvalid: invalidId,
  postNotFound: notFound,
} = storeToRefs(postStore)

const route = useRoute()
const postId = ref(route.params.id)

const { load } = useFetch(post, loading, error, status)

async function loadPost() {
  invalidId.value = false
  notFound.value = false

  if (!/^\d+$/.test(postId.value)) {
    invalidId.value = true
    return
  }

  await load(`/${postId.value}`)

  notFound.value = status.value === 404
}

onMounted(() => {
  loadPost()
})
</script>

<template>
  <PostDetails @retry="loadPost" />
</template>
