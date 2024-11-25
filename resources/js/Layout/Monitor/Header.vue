<template>
    <AppMeta>
        <link rel="icon" :href="`/storage/logo/${props.setting?.logo}`" type="image/x-icon"/>
    </AppMeta>

    <header
        :style="{ backgroundColor: props.setting?.navigasi }"
        class="d-flex flex-wrap justify-content-between py-2 mb-4 border-bottom"
    >
        <!-- Logo Section -->
        <Link
            :href="route('index')"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none"
        >
            <div class="bi me-2 ms-5" width="40" height="32" :style="{ marginLeft: '20px' }">
                <img
                    :src="`/storage/logo/${props.setting?.logo}`"
                    alt="logo"
                    width="40"
                    height="40"
                />
            </div>
            <span
                class="fs-4 text-bold ms-2"
                :style="{ color: props.setting?.text }"
                style="font-size: 22px"
                >{{ props.setting?.instansi ?? "" }}</span
            >
        </Link>

        <!-- Date and Time Section -->
        <div class="d-flex align-items-center text-dark ms-auto ms-5" :style="{marginRight: '20px' }">
            <i
                class="fa fa-calendar me-2"
                :style="{ color: props.setting?.text }"
            ></i>
            <div class="fs-5 text-bold" :style="{ color: props.setting?.text, marginLeft: '5px' }">
                {{ currentDate }}
            </div>
            <div class="fs-5 text-bold ms-3" :style="{ color: props.setting?.text, marginLeft: '20px' }">
                {{ currentTime }}
            </div>
        </div>
    </header>
</template>

<script setup>
import AppMeta from "@/Components/AppMeta.vue";
import { ref, onMounted, defineProps } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

// Define props
const props = defineProps(["setting"])

// Define state for current date and time
const currentDate = ref("");
const currentTime = ref("");

// Function to update current date and time
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

// On mounted, update date and time
onMounted(() => {
    updateCurrentDateTime();
    setInterval(updateCurrentDateTime, 1000);
});
</script>

<style scoped>
/* Add any specific styles for Header here */
</style>
