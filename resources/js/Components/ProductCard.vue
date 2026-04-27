<script setup>
import { Link } from '@inertiajs/vue3'

// принимаем товар
defineProps({
    product: Object
})
</script>

<template>
    <div style="border:1px solid #ccc; margin:10px; padding:10px;">
        <!-- переход на страницу товара -->
        <Link :href="`/product/${product.id}`">
            <h3>{{ product.name }}</h3>
        </Link>

        <p>Category: {{ product.category?.name }}</p>
        <p>Price: {{ product.price }}</p>
    </div>
</template>