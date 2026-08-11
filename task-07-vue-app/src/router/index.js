import { createRouter, createWebHistory } from 'vue-router'

import HomeView from '@/views/HomeView.vue'
import PostsView from '@/views/PostsView.vue'
import PostDetailsView from '@/views/PostDetailsView.vue'
import ContactView from '@/views/ContactView.vue'

// Lazy-loaded views
const ServicesView = () => import('@/views/ServicesView.vue')
const NotFoundView = () => import('@/views/NotFoundView.vue')

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/services',
            name: 'services',
            component: ServicesView
        },
        {
            path: '/posts',
            name: 'posts',
            component: PostsView
        },
        {
            path: '/posts/:id',
            name: 'post-details',
            component: PostDetailsView
        },
        {
            path: '/contact',
            name: 'contact',
            component: ContactView
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'not-found',
            component: NotFoundView
        }
    ],
})

export default router
