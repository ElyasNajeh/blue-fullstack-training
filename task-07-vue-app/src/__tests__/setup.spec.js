import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import { createPinia } from 'pinia'
import { createRouter, createMemoryHistory } from 'vue-router'

const TestComponent = {
    template: '<div>Testing Setup</div>',
}

describe('Testing Setup', () => {
    it('supports Vue, Pinia, and Vue Router', async () => {
        const pinia = createPinia()

        const router = createRouter({
            history: createMemoryHistory(),
            routes: [],
        })

        const wrapper = mount(TestComponent, {
            global: {
                plugins: [pinia, router],
            },
        })

        expect(wrapper.text()).toContain('Testing Setup')
    })
})