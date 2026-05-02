import { ref } from 'vue'
import api from '@/api/axios'

const token = ref(localStorage.getItem('token') || null)

export function useAuth() {

    const isAuthenticated = () => {
        return !!token.value
    }

    const login = async (credentials) => {
        const res = await api.post('/login', credentials)

        // сохраняем токен
        token.value = res.data.token 
        localStorage.setItem('token', res.data.token)
    }

    const logout = () => {
        token.value = null
        localStorage.removeItem('token')
        window.location.href = '/login'
    }

    return {
        token,
        login,
        logout,
        isAuthenticated
    }
}