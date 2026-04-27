<script setup>
import { ref, onMounted } from 'vue'
import api from '@/api/axios'
import ProductCard from '@/Components/ProductCard.vue'

const products = ref({ data: [] })
const loading = ref(true)

const fetchProducts = async (page = 1) => {
    loading.value = true
    try {
        const { data } = await api.get('/products', { params: { page } })
        products.value = data
    } catch (e) {
        console.error(e)
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    fetchProducts()
})
</script>

<template>
    <div>
        <h1>Products</h1>

        <div v-if="loading">Loading...</div>

        <div v-else>
            <ProductCard
                v-for="product in products.data ?? []"
                :key="product.id"
                :product="product"
            />
        </div>
    </div>
</template>