<script setup>
import { ref, onMounted } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

import AdminLayout from '@/Layouts/AdminLayout.vue'
import Spinner from '@/components/Spinner.vue'

import { useProductApi } from '@/composables/useProductApi'
import { useToast } from '@/composables/useToast'

import api from '@/api/axios'

// 📄 получаем id (если edit)
const page = usePage()
const id = page.props.id || null

// 📦 composables
const {
    product,
    loading,
    fetchProduct,
    createProduct,
    updateProduct
} = useProductApi()

const { success } = useToast()

// 🧠 форма
const name = ref('')
const price = ref('')
const category_id = ref('')
const categories = ref([])

// ⏳ отдельный loading для формы
const formLoading = ref(false)

// 📚 загрузка категорий
const fetchCategories = async () => {
    const res = await api.get('/categories')
    categories.value = res.data.data
}

// 📦 загрузка товара (если edit)
const loadProduct = async () => {
    if (!id) return

    await fetchProduct(id)

    name.value = product.value.name
    price.value = product.value.price
    category_id.value = product.value.category.id
}

// 💾 submit
const submit = async () => {
    formLoading.value = true

    const data = {
        name: name.value,
        price: price.value,
        category_id: category_id.value
    }

    try {
        if (id) {
            await updateProduct(id, data)
            success('Product updated')
        } else {
            await createProduct(data)
            success('Product created')
        }

        router.visit('/admin/products')

    } catch (e) {
        console.error(e)
    } finally {
        formLoading.value = false
    }
}

// 🚀 init
onMounted(async () => {
    await fetchCategories()
    await loadProduct()
})
</script>

<template>
    <AdminLayout>
        <h1>{{ id ? 'Edit Product' : 'Create Product' }}</h1>

        <!-- ⏳ загрузка данных -->
        <Spinner v-if="loading" />

        <div v-else>
            <!-- 📄 поля -->
            <div>
                <input
                    v-model="name"
                    placeholder="Name"
                />
            </div>

            <div>
                <input
                    v-model="price"
                    type="number"
                    placeholder="Price"
                />
            </div>

            <div>
                <select v-model="category_id">
                    <option value="">Select category</option>

                    <option
                        v-for="c in categories"
                        :key="c.id"
                        :value="c.id"
                    >
                        {{ c.name }}
                    </option>
                </select>
            </div>

            <!-- 💾 кнопка -->
            <button
                @click="submit"
                :disabled="formLoading"
            >
                {{ formLoading ? 'Saving...' : 'Save' }}
            </button>
        </div>
    </AdminLayout>
</template>