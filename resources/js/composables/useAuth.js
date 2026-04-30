import { ref } from 'vue'
import api from '@/api/axios'

const token = ref(localStorage.getItem('token'))

export function useAuth() {

    const login = async (credentials) => {
        const res = await api.post('/login', credentials)

        // сохраняем токен
        localStorage.setItem('token', res.data.token)
    }

    const logout = () => {
        token.value = null
        localStorage.removeItem('token')
    }

    const isAuthenticated = () => {
        return !!token.value
    }

    return {
        token,
        login,
        logout,
        isAuthenticated
    }
}