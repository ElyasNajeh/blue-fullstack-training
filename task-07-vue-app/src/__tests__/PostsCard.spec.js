import { describe, it, expect, beforeEach } from 'vitest'
import { mount } from '@vue/test-utils'
import { createPinia, setActivePinia } from 'pinia'
import { createRouter, createMemoryHistory } from 'vue-router'

import PostsCard from '@/components/PostsCard.vue'
import { usePostStore } from '@/stores/posts'

describe('PostsCard', () => {
    let pinia
    let router

    beforeEach(() => {
        localStorage.clear()

        pinia = createPinia()
        setActivePinia(pinia)

        router = createRouter({
            history: createMemoryHistory(),
            routes: [
                {
                    path: '/',
                    component: { template: '<div>Home</div>' },
                },
                {
                    path: '/posts/:id',
                    component: { template: '<div>Post Details</div>' },
                },
                {
                    path: '/posts/create',
                    component: { template: '<div>Create Post</div>' },
                },
                {
                    path: '/favorites',
                    component: { template: '<div>Favorites</div>' },
                },
            ],
        })
    })

    it('renders post content and adds the post to favorites', async () => {
        const posts = [
            {
                id: 1,
                title: 'Test Post Title',
                body: 'This is the test post body.',
                userId: 1,
            },
        ]

        const wrapper = mount(PostsCard, {
            props: {
                posts,
                loading: false,
                error: false,
                modelValue: '',
            },

            global: {
                plugins: [pinia, router],
            },
        })

        const postStore = usePostStore()

        expect(wrapper.text()).toContain('Test Post Title')
        expect(wrapper.text()).toContain('This is the test post body.')

        expect(postStore.favoriteIDs).toEqual([])

        const favoriteButton = wrapper.find('.favorite-btn')

        expect(favoriteButton.text()).toContain('Add to Favorite')

        await favoriteButton.trigger('click')

        expect(postStore.favoriteIDs).toContain(1)
        expect(postStore.favoriteCnt).toBe(1)

        expect(favoriteButton.text()).toContain('Remove from Favorite')
    })
})