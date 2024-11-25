<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 bg-light">
        <div class="mb-3 text-center">
            <Link href="/">
                <ApplicationLogo class="w-50 h-50 mx-auto" />
            </Link>
        </div>

        <div class="w-100 mt-3 p-4 bg-white shadow rounded" style="max-width: 500px">
            <slot />
        </div>
    </div>
</template>

