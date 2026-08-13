const API_BASE_URL = import.meta.env.VITE_API_BASE_URL
const POSTS_ENDPOINT = '/posts'

export function useFetch(data, loading, error, status) {
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

            data.value = await response.json()
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
                },

                body: JSON.stringify(postData),
            })

            status.value = response.status

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

    return {
        load,
        create,
    }
}