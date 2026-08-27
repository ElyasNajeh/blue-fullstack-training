import { createRouter, createWebHistory } from 'vue-router'

import HomeView from '@/views/HomeView.vue'
import PostsView from '@/views/PostsView.vue'
import PostDetailsView from '@/views/PostDetailsView.vue'
import ContactView from '@/views/ContactView.vue'
import FavoritesView from '@/views/FavoritesView.vue'
import { useAuthStore } from '@/stores/auth'

// Lazy-loaded views
const ServicesView = () => import('@/views/ServicesView.vue')
const NotFoundView = () => import('@/views/NotFoundView.vue')
const CreatePostView = () => import('@/views/CreatePostView.vue')
const LoginView = () => import('@/views/LoginView.vue')
const EditPostView = () => import('@/views/EditPostView.vue')
const DynamicPageView = () => import('@/views/DynamicPageView.vue')
const ManagePagesView = () => import('@/views/ManagePagesView.vue')
const CreatePageView = () => import('@/views/CreatePageView.vue')
const EditPageView = () => import('@/views/EditPageView.vue')

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
            path: '/posts/create',
            name: 'create-post',
            component: CreatePostView,
            meta: { requiresAuth: true }
        },
        {
            path: '/posts/:id/edit',
            name: 'edit-post',
            component: EditPostView,
            meta: { requiresAuth: true }
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
            path: '/favorites',
            name: 'favorites',
            component: FavoritesView
        },
        {
            path: '/login',
            name: 'login',
            component: LoginView
        },
        {
            path: '/page/:slug',
            name: 'dynamic-page',
            component: DynamicPageView
        },
        {
            path: '/manage/pages',
            name: 'manage-pages',
            component: ManagePagesView,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/manage/pages/create',
            name: 'create-page',
            component: CreatePageView,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/manage/pages/:id/edit',
            name: 'edit-page',
            component: EditPageView,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'not-found',
            component: NotFoundView
        }
    ],
})

router.beforeEach(async (to) => {
    const authStore = useAuthStore()

    if (!to.meta.requiresAuth) {
        return true
    }

    if (!authStore.token) {
        return {
            name: 'login',
            query: { redirect: to.fullPath }
        }
    }

    const validUser = await authStore.fetchUser()

    if (!validUser) {
        return {
            name: 'login',
            query: { redirect: to.fullPath }
        }
    }

    return true
})
export default router
