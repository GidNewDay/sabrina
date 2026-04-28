import { ref } from 'vue'
import api from '@/api/axios'

const user = ref(null)

export function useAuth() {

    const login = async (credentials) => {
        const res = await api.post('/login', credentials)

        // сохраняем токен
        localStorage.setItem('token', res.data.token)
    }

    const logout = () => {
        localStorage.removeItem('token')
    }

    return {
        user,
        login,
        logout
    }
}