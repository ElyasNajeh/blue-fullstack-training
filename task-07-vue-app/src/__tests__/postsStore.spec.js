import { beforeEach, describe, expect, it } from 'vitest'
import { createPinia, setActivePinia } from 'pinia'

import { usePostStore } from '@/stores/posts'

describe('Post Store Favorites', () => {
    beforeEach(() => {
        localStorage.clear()
        setActivePinia(createPinia())
    })

    it('adds and removes a post from favorites', () => {
        const postStore = usePostStore()

        // Add to favorites
        postStore.toggleFavorite(1)

        expect(postStore.favoriteIDs).toContain(1)
        expect(postStore.favoriteCnt).toBe(1)

        // Remove from favorites
        postStore.toggleFavorite(1)

        expect(postStore.favoriteIDs).not.toContain(1)
        expect(postStore.favoriteCnt).toBe(0)
    })

    it('restores favorite IDs from localStorage', () => {
        localStorage.setItem('favoriteIDs', JSON.stringify([1, 3, 5]))

        const postStore = usePostStore()

        expect(postStore.favoriteIDs).toEqual([1, 3, 5])
        expect(postStore.favoriteCnt).toBe(3)
    })
})
