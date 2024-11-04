<template>
    <AppMeta>
        <link
            rel="icon"
            :href="`/storage/logo/${setting?.logo}`"
            type="image/x-icon"
        />
    </AppMeta>

    <header
        :style="{ backgroundColor: setting?.navigasi }"
        class="d-flex flex-wrap justify-content-between py-2 mb-4 border-bottom"
    >
        <Link
            :href="route('index')"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none"
        >
            <div class="bi me-2 ms-5" width="40" height="32">
                <img
                    :src="`/storage/logo/${setting?.logo}`"
                    alt="logo"
                    width="40"
                    height="40"
                />
            </div>
            <span
                class="fs-4 text-bold ms-2"
                :style="{ color: setting?.text }"
                style="font-size: 22px"
                >{{ setting?.instansi ?? "" }}</span
            >
        </Link>
        <div class="d-flex align-items-center text-dark ms-auto me-5">
            <i
                class="fa fa-calendar me-2"
                :style="{ color: setting?.text }"
            ></i>
            <div class="fs-5 text-bold" :style="{ color: setting?.text }">
                {{ currentDate }}
            </div>
            <div class="fs-5 text-bold ms-3" :style="{ color: setting?.text }">
                {{ currentTime }}
            </div>
        </div>
    </header>
</template>

<script setup>
import AppMeta from "@/Components/AppMeta.vue";
import { ref, onMounted } from "vue";
const props = defineProps(["setting"]);
import { Link } from "@inertiajs/vue3";

const currentDate = ref("");
const currentTime = ref("");

const updateCurrentDateTime = () => {
    const now = new Date();
    const dateOptions = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    const timeOptions = {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false,
    };
    currentDate.value = now.toLocaleDateString("id-ID", dateOptions);
    currentTime.value = now.toLocaleTimeString("id-ID", timeOptions);
};

onMounted(() => {
    updateCurrentDateTime();
    setInterval(updateCurrentDateTime, 1000);
});
</script>

<style scoped>
/* Add any specific styles for Header here */
</style>
