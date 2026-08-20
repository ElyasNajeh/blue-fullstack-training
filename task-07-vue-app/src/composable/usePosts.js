import { useAuthStore } from '@/stores/auth'
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL
const POSTS_ENDPOINT = '/posts'

export function useFetch(data, loading, error, status) {
    const authStore = useAuthStore()
    async function load(url) {
        try {
            loading.value = true
            error.value = false
            status.value = null

            const response = await fetch(API_BASE_URL + POSTS_ENDPOINT + url)

            status.value = response.status

            if (!response.ok) {
                throw new Error('Failed to fetch data')
            }

            const result = await response.json()

            data.value = result.data
        } catch (err) {
            error.value = true
            console.log(err)
        } finally {
            loading.value = false
        }
    }

    async function create(postData) {
        try {
            loading.value = true
            error.value = false
            status.value = null

            const response = await fetch(API_BASE_URL + POSTS_ENDPOINT, {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    ...(authStore.token && {
                        Authorization: `Bearer ${authStore.token}`,
                    }),
                },

                body: JSON.stringify(postData),
            })

            status.value = response.status
            if (response.status === 401) {
                error.value = true
                return false
            }

            if (!response.ok) {
                throw new Error('Failed to create post')
            }

            data.value = await response.json()

            return true
        } catch (err) {
            error.value = true
            console.log(err)

            return false
        } finally {
            loading.value = false
        }
    }
    async function remove(id) {
        try {
            loading.value = true
            status.value = null

            const response = await fetch(`${API_BASE_URL}${POSTS_ENDPOINT}/${id}`, {
                method: 'DELETE',

                headers: {
                    Accept: 'application/json',
                    ...(authStore.token && {
                        Authorization: `Bearer ${authStore.token}`,
                    }),
                },
            })

            status.value = response.status

            if (!response.ok) {
                return {
                    success: false,
                    status: response.status,
                }
            }

            return {
                success: true,
                status: response.status,
            }
        } catch (err) {
            console.log(err)

            return {
                success: false,
                status: null,
            }
        } finally {
            loading.value = false
        }
    }
    async function update(id, postData) {
        try {
            loading.value = true
            error.value = false
            status.value = null

            const response = await fetch(`${API_BASE_URL}${POSTS_ENDPOINT}/${id}`, {
                method: 'PUT',

                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    ...(authStore.token && {
                        Authorization: `Bearer ${authStore.token}`,
                    }),
                },

                body: JSON.stringify(postData),
            })

            status.value = response.status

            if (response.status === 401 || response.status === 403) {
                error.value = true
                return false
            }

            if (!response.ok) {
                throw new Error('Failed to update post')
            }

            data.value = await response.json()

            return true
        } catch (err) {
            error.value = true
            console.log(err)

            return false
        } finally {
            loading.value = false
        }
    }
    return {
        load,
        create,
        update,
        remove,
    }
}