import { describe, it, expect, beforeEach, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import { createPinia, setActivePinia } from 'pinia'

import CreatePostView from '@/views/CreatePostView.vue'
import { usePostStore } from '@/stores/posts'


const createMock = vi.fn()

let pinia


vi.mock('@/composable/usePosts', () => ({
    useFetch: () => ({
        create: createMock,
    }),
}))


describe('CreatePostView', () => {

    beforeEach(() => {
        localStorage.clear()

        createMock.mockReset()

        pinia = createPinia()
        setActivePinia(pinia)
    })


    it('blocks empty submission and displays field validation errors', async () => {

        const wrapper = mount(CreatePostView, {
            global: {
                plugins: [pinia],
            },
        })


        await wrapper.find('form').trigger('submit')


        expect(wrapper.text()).toContain('Title is required.')
        expect(wrapper.text()).toContain('Body is required.')
        expect(wrapper.text()).toContain('User ID is required.')

        expect(createMock).not.toHaveBeenCalled()
    })


    it('submits valid data and displays success message', async () => {

        createMock.mockImplementation(async (postData) => {

            const postStore = usePostStore()

            postStore.createdPost = {
                id: 101,
                ...postData,
            }

            return true
        })


        const wrapper = mount(CreatePostView, {
            global: {
                plugins: [pinia],
            },
        })


        await wrapper.find('#title').setValue('My Test Post')

        await wrapper
            .find('#body')
            .setValue('This is valid content for my test post.')

        await wrapper.find('#userId').setValue('5')


        await wrapper.find('form').trigger('submit')


        expect(createMock).toHaveBeenCalledTimes(1)

        expect(createMock).toHaveBeenCalledWith({
            title: 'My Test Post',
            body: 'This is valid content for my test post.',
            userId: 5,
        })


        expect(wrapper.text()).toContain('Post Created Successfully!')
        expect(wrapper.text()).toContain('101')


        expect(wrapper.find('#title').element.value).toBe('')
        expect(wrapper.find('#body').element.value).toBe('')
        expect(wrapper.find('#userId').element.value).toBe('')
    })

})