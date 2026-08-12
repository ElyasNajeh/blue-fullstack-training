const POSTS_API_URL = 'https://jsonplaceholder.typicode.com/posts'

export function useFetch(data, loading, error, status) {
    async function load(url) {
        try {
            loading.value = true
            error.value = false
            status.value = null

            const response = await fetch(POSTS_API_URL + url)

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

            const response = await fetch(POSTS_API_URL, {
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