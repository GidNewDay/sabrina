import api from '@/api/axios'

export function useCategoryApi() {
    const getCategories = () => {
        return api.get('/categories')
    }

    return {
        getCategories
    }
}