<script setup>
import { useToast } from '@/composables/useToast'

const { message, show } = useToast()
</script>

<template>
    <div v-if="show" class="toast">
        {{ message }}
    </div>
</template>

<style>
.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: green;
    color: white;
    padding: 10px;
}
</style>