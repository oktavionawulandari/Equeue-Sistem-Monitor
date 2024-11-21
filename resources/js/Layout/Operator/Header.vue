<template>
    <AppMeta>
        <link rel="icon" :href="`/storage/logo/${props.setting?.logo}`" type="image/x-icon"/>
    </AppMeta>


    <header
        class="d-flex flex-wrap justify-content-between py-2 mb-4 border-bottom"  :style="{ backgroundColor: setting?.navigasi }"
    >
        <Link
            :href="route('home')"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none"
        >
            <div class="bi me-2 ms-5" width="40" height="32">
                <img
                    :src="`/storage/logo/${props.setting?.logo}`"
                    alt="logo"
                    width="50"
                    height="50"
                />
            </div>
            <span
                class="fs-4 text-bold ms-2 "
                style="font-size: 22px" :style="{ color: setting?.text }"
                >{{ props.setting?.instansi ?? "" }}</span
            >
        </Link>
        <div class="d-flex align-items-center ms-auto me-5" :style="{ color: setting?.text }">
            <Link
                class="nav-link"
                :href="route('logout')"
                method="post"
                as="button"
                title="logout"
            >
                <i class="fas fa-sign-out-alt"></i>
            </Link>
        </div>
    </header>
</template>

<script setup>
import AppMeta from "@/Components/AppMeta.vue";
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const props = defineProps(["setting"])

</script>
