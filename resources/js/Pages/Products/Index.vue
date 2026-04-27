<script setup>
import { ref, onMounted, watch } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import api from '@/api/axios'
import ProductCard from '@/Components/ProductCard.vue'

const products = ref([])
const categories = ref([])
const selectedCategory = ref('')
const loading = ref(true)

const page = usePage()

// Загрузка товаров с учётом выбранной категории и страницы
const fetchProducts = async () => {
    loading.value = true
    try {
        const params = {}

        if (selectedCategory.value) {
            params.category_id = selectedCategory.value
        }

        const res = await api.get('/products', { params })
        products.value = res.data
    } catch (e) {
        console.error(e)
    } finally {
        loading.value = false
    }
}

// Загрузка категорий
const fetchCategories = async () => {
    try {
        const res = await api.get('/categories')
        categories.value = res.data.data ?? []
    } catch (e) {
        console.error('Ошибка загрузки категорий:', e)
    }
}

// обновление URL без перезагрузки
const updateUrl = () => {
    router.get('/', {
        category_id: selectedCategory.value || undefined
    }, {
        preserveState: true, // не сбрасывает состояние страницы
        replace: true        // не создаёт новую запись в истории
    })
}

// следим за изменением фильтра
watch(selectedCategory, () => {
    updateUrl()
    fetchProducts()
})

onMounted(() => {
    // читаем фильтр из URL (если есть)
    selectedCategory.value = page.props.category_id || ''

    fetchCategories()
    fetchProducts()
})
</script>

<template>
    <div>
        <h1>Products</h1>

        <!-- Фильтр по категориям -->
        <div class="filter">
            <label>Категория: </label>
            <select v-model="selectedCategory">
                <option value="">Все категории</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                    {{ cat.name }}
                </option>
            </select>

            <button @click="selectedCategory = ''">
                Reset
            </button>
        </div>

        <div v-if="loading">Loading...</div>

        <!-- список товаров -->
        <div v-else>
            <ProductCard v-for="product in products.data" :key="product.id" :product="product" />
        </div>
    </div>
</template>

<style scoped>
.filter {
    margin-bottom: 20px;
}

.pagination {
    margin-top: 20px;
    display: flex;
    gap: 8px;
}

.pagination button {
    padding: 5px 10px;
    cursor: pointer;
}

.pagination button.active {
    background-color: #007bff;
    color: white;
    border: none;
}

.pagination button:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}
</style>