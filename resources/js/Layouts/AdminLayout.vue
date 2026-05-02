<script setup>
import { useAuth } from '@/composables/useAuth'
import { router } from '@inertiajs/vue3'
import Toast from '@/components/Toast.vue'

const { logout } = useAuth()

const handleLogout = () => {
    logout()
    router.visit('/login')
}
</script>

<template>
    <div>
        <nav>
            <a href="/admin/products">Products</a>
            <button @click="handleLogout">Logout</button>
        </nav>

        <Toast />
        <slot />
    </div>
</template>