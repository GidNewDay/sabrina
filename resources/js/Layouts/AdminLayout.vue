<script setup>
import { onMounted } from 'vue'
import { useAuth } from '@/composables/useAuth'
import { router } from '@inertiajs/vue3'

import Toast from '@/components/Toast.vue'

const { isAuthenticated, logout } = useAuth()

onMounted(() => {
    if (!isAuthenticated()) {
        router.visit('/login')
    }
})
</script>

<template>
    <div>
        <!--  уведомления -->
        <Toast />

        <!--  навбар -->
        <nav style="margin-bottom: 20px;">
            <a href="/admin/products">Products</a>

            <button @click="logout">
                Logout
            </button>
        </nav>

        <!--  контент -->
        <slot />
    </div>
</template>