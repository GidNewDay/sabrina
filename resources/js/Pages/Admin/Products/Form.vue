<script setup>
import { ref, onMounted } from 'vue'
import { useProductApi } from '@/composables/useProductApi'
import { router, usePage } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const { createProduct, updateProduct, fetchProduct, product } = useProductApi()

const page = usePage()
const id = page.props.id || null

const name = ref('')
const price = ref('')
const category_id = ref('')

// загрузка
onMounted(async () => {
    if (id) {
        await fetchProduct(id)

        name.value = product.value.name
        price.value = product.value.price
        category_id.value = product.value.category.id
    }
})

// сохранение
const submit = async () => {
    const data = {
        name: name.value,
        price: price.value,
        category_id: category_id.value
    }

    if (id) {
        await updateProduct(id, data)
    } else {
        await createProduct(data)
    }

    router.visit('/admin/products')
}
</script>