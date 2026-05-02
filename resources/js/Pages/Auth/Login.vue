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
        console.log(e.response?.data)
        error.value = 'Login failed'
    }
}
</script>

<template>
    <div>
        <h1>Login</h1>

        <!-- ❗ ВАЖНО -->
        <form @submit.prevent="submit">

            <input v-model="email" placeholder="Email" />

            <input
                v-model="password"
                type="password"
                placeholder="Password"
            />

            <button type="submit">
                Login
            </button>

        </form>

        <p v-if="error">{{ error }}</p>
    </div>
</template>