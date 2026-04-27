<script setup>
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import api from '@/api/axios'

const product = ref(null)
const loading = ref(true)

const page = usePage()
const id = page.props.id ?? page.props.value?.id

const fetchProduct = async () => {
    try {
        // if (!id) {
        //     product.value = null
        //     return
        // }

        const res = await api.get(`/products/${id}`)
        product.value = res.data.data
    } catch (e) {
        console.error(e)
        product.value = null
    } finally {
        loading.value = false
    }
}

onMounted(fetchProduct)
</script>

<template>
    <div>
        <div v-if="loading">Loading...</div>

        <div v-else-if="product">
            <h1>{{ product.name }}</h1>
            <p>{{ product.category?.name }}</p>
            <p>{{ product.description }}</p>
            <p>{{ product.price }}</p>
        </div>

        <div v-else>
            Product not found
        </div>
    </div>
</template>