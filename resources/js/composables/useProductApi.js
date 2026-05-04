import { ref } from 'vue'
import api from '@/api/axios'

// это "хук" (композабл)
export function useProductApi() {

    const products = ref([])
    const product = ref(null)

    const loading = ref(false)
    const error = ref(null)
    
    // список товаров
    const fetchProducts = async (params = {}) => {
        loading.value = true
        error.value = null

        try {
            const res = await api.get('/products', { 
                params: params
            })

            products.value = res.data
        } catch (e) {
            error.value = e
            console.error('Fetch products error:', e)
        } finally {
            loading.value = false
        }
    }

    // один товар
    const fetchProduct = async (id) => {
        loading.value = true
        error.value = null

        try {
            const res = await api.get(`/products/${id}`)
            product.value = res.data.data
        } catch (e) {
            error.value = e
            console.error('Fetch products error:', e)
        } finally {
            loading.value = false
        }
    }

    // создание
    const createProduct = async (data) => {
        return api.post('/products', data)
    }

    // обновление
    const updateProduct = async (id, data) => {
        return api.patch(`/products/${id}`, data)
    }

    // удаление
    const deleteProduct = async (id) => {
        return api.delete(`/products/${id}`)
    }

    return {
        products,
        product,
        loading,
        error,
        fetchProducts,
        fetchProduct,
        createProduct,
        updateProduct,
        deleteProduct
    }
}