<script setup>
import { ref, onMounted, watch } from 'vue'
import { router } from '@inertiajs/vue3'

import AdminLayout from '@/Layouts/AdminLayout.vue'
import ConfirmModal from '@/components/ConfirmModal.vue'
import Spinner from '@/components/Spinner.vue'

import { useProductApi } from '@/composables/useProductApi'
import { useToast } from '@/composables/useToast'

import api from '@/api/axios'

//  API
const {
    products,
    loading,
    fetchProducts,
    deleteProduct
} = useProductApi()

//  Toast
const { success } = useToast()

//  Модалка удаления
const showModal = ref(false)
const selectedId = ref(null)

// открыть модалку
const askDelete = (id) => {
    selectedId.value = id
    showModal.value = true
}

// подтвердить удаление
const confirmDelete = async () => {
    if (!selectedId.value) return

    await deleteProduct(selectedId.value)

    success('Product deleted')

    showModal.value = false
    selectedId.value = null

    fetchProducts()
}

const search = ref('')
const category_id = ref('')
const categories = ref([])

const fetchCategories = async () => {
    const res = await api.get('/categories')
    categories.value = res.data.data
}

const loadProducts = () => {
    fetchProducts({
        search: search.value,
        category_id: category_id.value
    })
}

// загрузка при старте
onMounted(() => {
    fetchCategories()
    loadProducts()
})

let timeout = null

watch(search, () => {
    clearTimeout(timeout)

    timeout = setTimeout(() => {
        loadProducts()
    }, 500)
})

watch(category_id, () => {
    loadProducts()
})
</script>

<template>
    <AdminLayout>
        <h1>Products</h1>
        
        <div style="margin-bottom: 20px;">
            <!-- 🔍 поиск -->
            <input v-model="search" placeholder="Search..." />

            <!-- 📂 категории -->
            <select v-model="category_id">
                <option value="">All categories</option>

                <option v-for="c in categories" :key="c.id" :value="c.id">
                    {{ c.name }}
                </option>
            </select>
        </div>

        <!--  кнопка создания -->
        <button @click="router.visit('/admin/products/create')">
            Add Product
        </button>

        <!-- загрузка -->
        <Spinner v-if="loading" />

        <!--  список -->
        <div v-else>
            <div v-for="p in products.data" :key="p.id" style="border: 1px solid #ccc; margin: 10px; padding: 10px;">
                <h3>{{ p.name }}</h3>
                <p>{{ p.price }}</p>

                <!--  редактирование -->
                <button @click="router.visit(`/admin/products/${p.id}/edit`)">
                    Edit
                </button>

                <!--  удаление -->
                <button @click="askDelete(p.id)">
                    Delete
                </button>
            </div>
        </div>

        <!--  модалка -->
        <ConfirmModal :show="showModal" @confirm="confirmDelete" @cancel="showModal = false" />
    </AdminLayout>
</template>