<template>
    <AppMeta>
        <link rel="icon" :href="`/storage/${props.setting?.logo}`" type="image/x-icon"/>
    </AppMeta>


    <header
        class="d-flex flex-wrap justify-content-between py-2 mb-4 border-bottom"  :style="{ backgroundColor: setting?.navigasi }"
    >
        <Link
            :href="route('home')"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none"
        >
            <div class="bi me-2 ms-5" width="40" height="32"  :style="{ marginLeft: '20px' }">
                <img
                    :src="`/storage/${props.setting?.logo}`"
                    alt="logo"
                    width="50"
                    height="50"
                />
            </div>
            <span
                class="fs-4 text-bold ms-2"
                :style="{ color: props.setting?.text }"
                style="font-size: 22px"
                >{{ props.setting?.instansi ?? "" }}</span
            >
        </Link>
        <div class="d-flex align-items-center ms-auto me-5" >
            <Link
                class="nav-link"
                :href="route('logout')"
                method="post"
                title="logout"
                :style="{ color: setting?.text }"
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
