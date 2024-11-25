<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-if="message">
        <p class="text-danger small">
            {{ message }}
        </p>
    </div>
</template>
