<script setup>
import { ref, onMounted } from 'vue'
import api from '@/api/axios'
import { router, usePage } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const page = usePage()
const id = page.props.id || null

const name = ref('')
const price = ref('')
const category_id = ref('')
const categories = ref([])

// загрузка категорий
const fetchCategories = async () => {
    const res = await api.get('/categories')
    categories.value = res.data.data
}

// загрузка товара (если edit)
const fetchProduct = async () => {
    if (!id) return

    const res = await api.get(`/products/${id}`)

    name.value = res.data.data.name
    price.value = res.data.data.price
    category_id.value = res.data.data.category.id
}

// сохранение
const submit = async () => {
    const data = {
        name: name.value,
        price: price.value,
        category_id: category_id.value
    }

    if (id) {
        await api.patch(`/products/${id}`, data)
    } else {
        await api.post('/products', data)
    }

    router.visit('/admin/products')
}

onMounted(() => {
    fetchCategories()
    fetchProduct()
})
</script>

<template>
    <AdminLayout>
        <h1>{{ id ? 'Edit' : 'Create' }} Product</h1>

        <input v-model="name" placeholder="Name" />
        <input v-model="price" type="number" />

        <select v-model="category_id">
            <option v-for="c in categories" :value="c.id">
                {{ c.name }}
            </option>
        </select>

        <button @click="submit">Save</button>
    </AdminLayout>
</template>