<template>
    <img :src="`/storage/${page.props.setting?.logo}`" alt="logo" >

</template>

<script setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage()

</script>
