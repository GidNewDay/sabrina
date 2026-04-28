<script setup>
import { ref, onMounted } from 'vue'
import api from '@/api/axios'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { router } from '@inertiajs/vue3'

const products = ref([])

const fetchProducts = async () => {
    const res = await api.get('/products')
    products.value = res.data.data
}

const deleteProduct = async (id) => {
    if (!confirm('Delete?')) return

    await api.delete(`/products/${id}`)
    fetchProducts()
}

onMounted(fetchProducts)
</script>

<template>
    <AdminLayout>
        <h1>Admin Products</h1>

        <button @click="router.visit('/admin/products/create')">
            Add Product
        </button>

        <div v-for="p in products" :key="p.id">
            <h3>{{ p.name }}</h3>

            <button @click="router.visit(`/admin/products/${p.id}/edit`)">
                Edit
            </button>

            <button @click="deleteProduct(p.id)">
                Delete
            </button>
        </div>
    </AdminLayout>
</template>