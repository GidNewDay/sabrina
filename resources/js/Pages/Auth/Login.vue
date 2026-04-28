<script setup>
import { ref } from 'vue'
import { useAuth } from '@/composables/useAuth'
import { router } from '@inertiajs/vue3'

const email = ref('')
const password = ref('')
const error = ref(null)

const { login } = useAuth()

const submit = async () => {
    try {
        await login({
            email: email.value,
            password: password.value
        })

        router.visit('/admin/products')
    } catch (e) {
        error.value = 'Login failed'
    }
}
</script>

<template>
    <div>
        <h1>Login</h1>

        <input v-model="email" placeholder="Email" />
        <input v-model="password" type="password" placeholder="Password" />

        <button @click="submit">Login</button>

        <p v-if="error">{{ error }}</p>
    </div>
</template>