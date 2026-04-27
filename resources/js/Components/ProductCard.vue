<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    product: Object
})
</script>

<template>
    <div class="card">
        <Link :href="`/product/${product.id}`">
            <h3>{{ product.name }}</h3>
        </Link>
        <p>{{ product.category?.name }}</p>
        <p>{{ product.price }}</p>
    </div>
</template>