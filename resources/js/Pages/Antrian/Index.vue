<template>
    <AppMeta title="Antrian" />

    <div
        class="d-flex flex-column min-vh-100"
        :style="{ backgroundColor: setting?.background }"
    >
        <Head :setting="setting" />

        <div class="container-fluid">
            <form @submit.prevent="submitForm">
                <div class="row">
                    <div
                        class="col-lg-4"
                        v-for="cat in categories"
                        :key="cat.id"
                    >
                        <div class="card">
                            <div
                                class="card-body d-flex justify-content-center align-items-center"
                            >
                                <h5 class="card-title text-bold text-uppercase">
                                    {{ cat.name }}
                                </h5>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div
                                    class="border border-success rounded-5 py-2 mb-4"
                                >
                                    <h6
                                        id="antrian"
                                        class="display-1 fw-bold text-success text-center lh-1 pb-2"
                                    >
                                        {{ getLatestQueueNumber(cat) }}
                                    </h6>
                                </div>
                                <button
                                    type="submit"
                                    class="btn btn-success btn-block rounded-pill fs-5 px-5 py-4 mb-2"
                                     :disabled="isSubmitting"
                                    @click="
                                        () => {
                                            form.category_id = cat.id;
                                            form.status = 1;
                                        }
                                    "
                                >
                                    <i class="fa fa-user-plus fs-4 me-4"></i>
                                    Ambil Nomor
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <Foot :setting="setting" />
    </div>
</template>

<script setup>
import { onMounted, ref, onBeforeUnmount } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import Foot from "../../Layout/Monitor/Footer.vue";
import Head from "../../Layout/Monitor/Header.vue";
import "../../../css/dashboard.css";
import AppMeta from "@/Components/AppMeta.vue";

const { props: pageProps } = usePage();
const categories = ref(pageProps.categories || []);
const currentTime = ref("");
const currentDate = ref("");
const isSubmitting = ref(false);
const props = defineProps(["setting"]);

const form = useForm({
    status: "",
    category_id: "",
    date: new Date().toISOString(),
});

const getLatestQueueNumber = (category) => {
    const latestQueue = category?.queue[category.queue.length - 1];
    if (latestQueue) {
        const queueDate = new Date(latestQueue.date);
        const today = new Date();

        if (queueDate.toDateString() === today.toDateString()) {
            return latestQueue.no;
        }
    }
    return category.kode.toUpperCase() + "-000";
};

const submitForm = () => {
    isSubmitting.value = true;
    form.post("/antrian", {
        onSuccess: (page) => {
            router.get("/antrian");
            const categoryId = form.category_id;
            window.open(`/antrian/${categoryId}`, "_blank");
            isSubmitting.value = false;
        },
        onError: (error) => {
            console.error("nomor antrian error: ", error);
            isSubmitting.value = false;
        },
    });
};

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
    };
    currentDate.value = now.toLocaleDateString("id-ID", dateOptions);
    currentTime.value = now.toLocaleTimeString("id-ID", timeOptions);
};

onMounted(() => {
    updateCurrentDateTime();
    const timeInterval = setInterval(updateCurrentDateTime, 1000);

    onBeforeUnmount(() => {
        clearInterval(timeInterval);
    });
});
</script>
