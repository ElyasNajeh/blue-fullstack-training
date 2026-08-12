import { computed, ref } from 'vue'
import { defineStore } from 'pinia'

export const usePostStore = defineStore('post', () => {

    // Posts List
    const posts = ref([])
    const postsLoading = ref(false)
    const postsError = ref(false)
    const postsStatus = ref(null)


    // Post Details
    const post = ref(null)
    const postLoading = ref(false)
    const postError = ref(false)
    const postStatus = ref(null)

    const postInvalid = ref(false)
    const postNotFound = ref(false)


    // Favorites
    const favoriteIDs = ref(
        JSON.parse(localStorage.getItem('favoriteIDs')) || []
    )

    const favoriteCnt = computed(() => favoriteIDs.value.length)

    function toggleFavorite(id) {
        if (favoriteIDs.value.includes(id)) {
            favoriteIDs.value = favoriteIDs.value.filter(
                favoriteId => favoriteId !== id
            )
        } else {
            favoriteIDs.value.push(id)
        }
        localStorage.setItem('favoriteIDs', JSON.stringify(favoriteIDs.value))
    }




    return {
        // Posts
        posts,
        postsLoading,
        postsError,
        postsStatus,

        // Post Details
        post,
        postLoading,
        postError,
        postStatus,
        postInvalid,
        postNotFound,

        // Favorites
        favoriteIDs,
        favoriteCnt,
        toggleFavorite
    }
})