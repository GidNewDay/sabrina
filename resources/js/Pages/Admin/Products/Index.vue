<script setup>
import { onMounted } from 'vue'
import { useProductApi } from '@/composables/useProductApi'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const {
    products,
    loading,
    fetchProducts,
    deleteProduct
} = useProductApi()

onMounted(fetchProducts)
</script>

<template>
    <AdminLayout>
        <h1>Products</h1>

        <div v-if="loading">Loading...</div>

        <div v-else>
            <div v-for="p in products.data" :key="p.id">
                {{ p.name }}

                <button @click="deleteProduct(p.id).then(fetchProducts)">
                    Delete
                </button>
            </div>
        </div>
    </AdminLayout>
</template>