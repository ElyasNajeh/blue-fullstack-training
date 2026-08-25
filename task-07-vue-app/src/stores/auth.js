import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL

export const useAuthStore = defineStore('auth', () => {
    const user = ref(null)
    const token = ref(localStorage.getItem('token'))

    const isAuthenticated = computed(() => {
        return !!token.value
    })

    function clearAuth() {
        user.value = null
        token.value = null
        localStorage.removeItem('token')
    }

    async function login(email, password) {
        const response = await fetch(`${API_BASE_URL}/login`, {
            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
            },

            body: JSON.stringify({
                email,
                password,
            }),
        })

        if (!response.ok) {
            return false
        }

        const data = await response.json()

        token.value = data.token
        user.value = data.user

        localStorage.setItem('token', data.token)

        return true
    }

    async function fetchUser() {
        if (!token.value) {
            clearAuth()
            return false
        }

        try {
            const response = await fetch(`${API_BASE_URL}/me`, {
                headers: {
                    Authorization: `Bearer ${token.value}`,
                },
            })

            if (!response.ok) {
                clearAuth()
                return false
            }

            const data = await response.json()

            user.value = data.user

            return true
        } catch (err) {
            console.log(err)

            clearAuth()

            return false
        }
    }

    async function logout() {
        if (!token.value) {
            clearAuth()
            return true
        }

        try {
            await fetch(`${API_BASE_URL}/logout`, {
                method: 'POST',

                headers: {
                    Authorization: `Bearer ${token.value}`,
                },
            })
        } catch (err) {
            console.log(err)
        } finally {
            clearAuth()
        }

        return true
    }

    return {
        user,
        token,
        isAuthenticated,

        login,
        fetchUser,
        logout,
    }
})