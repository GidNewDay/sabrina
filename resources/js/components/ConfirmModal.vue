<script setup>
defineProps(['show'])
defineEmits(['confirm', 'cancel'])
</script>

<template>
    <div v-if="show" class="modal">
        <div class="box">
            <p>Are you sure?</p>

            <button @click="$emit('confirm')">Yes</button>
            <button @click="$emit('cancel')">No</button>
        </div>
    </div>
</template>

<style>
.modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
}

.box {
    background: white;
    padding: 20px;
    margin: 100px auto;
    width: 200px;
}
</style>