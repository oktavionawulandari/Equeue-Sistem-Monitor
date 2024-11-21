<template>
    <AppMeta title="Daftar Loket" />
    <Head :setting="props.setting" />

    <div class="d-flex flex-column min-vh-100">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-uppercase">
                            Daftar {{ counter_name }}
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <Link :href="route('home')">Dashboard</Link>
                            </li>
                            <li class="breadcrumb-item active">Daftar Loket</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success">
                                <i class="ion ion-person-stalker"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold"
                                    >TOTAL ANTRIAN</span
                                >
                                <span>{{ totalAntrian }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning">
                                <i class="ion ion-clock"></i>
                            </span>
                            <div class="info-box-content" href="#">
                                <span class="info-box-text text-bold"
                                    >ANTRIAN SEKARANG</span
                                >
                                <span>{{ propsPage.QueuenNo }}</span>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <button class="button-refresh" @click="refreshData">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary">
                                    <i class="ion ion-arrow-right-b"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text text-bold"
                                        >ANTRIAN BERIKUTNYA</span
                                    >
                                    <span>Klik untuk antrian berikutnya</span>
                                </div>
                            </div>
                        </button>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger">
                                <i class="ion ion-alert-circled"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold"
                                    >SISA ANTRIAN</span
                                >
                                <span>{{ SisaAntrian }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive">
                                <table
                                    class="table table-striped table-bordered table-hover text-nowrap"
                                >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor Antrian</th>
                                            <th>Panggilan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(
                                                queue, index
                                            ) in queues.data"
                                            :key="queue.id"
                                        >
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ queue.no }}</td>
                                            <td>
                                                <button
                                                    type="button"
                                                    :class="{
                                                        'btn-primary':
                                                            Number(
                                                                queue.status
                                                            ) === 1,
                                                        'btn-warning':
                                                            Number(
                                                                queue.status
                                                            ) === 3 ||
                                                            Number(
                                                                queue.status
                                                            ) === 2,
                                                        'call-button': true,
                                                        'me-2': true,
                                                    }"
                                                    @click="callQueue(queue)"
                                                    aria-label="Panggil antrian"
                                                    aria-describedby="call-queue-description"
                                                    title="Panggil Antrian"
                                                    :disabled="
                                                        isSubmitting == queue.id
                                                    "
                                                >
                                                    <i
                                                        class="ion ion-mic-a call-icon"
                                                    ></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-success call-button"
                                                    @click="successQueue(queue)"
                                                    aria-label="Panggil antrian"
                                                    aria-describedby="call-queue-description"
                                                    title="Berhasil"
                                                    :disabled="
                                                        isSubmitting == queue.id
                                                    "
                                                >
                                                    <i
                                                        class="ion ion-checkmark call-icon"
                                                    ></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-danger call-button ms-2"
                                                    @click="batalQueue(queue)"
                                                    arial-label="Batal"
                                                    aria-describedby="call-queue-description"
                                                    title="Batal"
                                                    :disabled="
                                                        isSubmitting == queue.id
                                                    "
                                                >
                                                    <i
                                                        class="ion ion-close call-icon"
                                                    ></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <nav>
                                            <ul
                                                class="pagination justify-content-start"
                                            >
                                                <li
                                                    class="page-item"
                                                    :class="{
                                                        disabled:
                                                            !queues.prev_page_url,
                                                    }"
                                                >
                                                    <Link
                                                        class="page-link"
                                                        :href="`${
                                                            queues.prev_page_url
                                                                ? queues.prev_page_url
                                                                : ''
                                                        }`"
                                                        method="get"
                                                        >Previous</Link
                                                    >
                                                </li>
                                                <li
                                                    class="page-item"
                                                    v-for="page in pages"
                                                    :key="page"
                                                    :class="{
                                                        active:
                                                            page ===
                                                            queues.current_page,
                                                    }"
                                                >
                                                    <Link
                                                        class="page-link"
                                                        :href="`?page=${page}`"
                                                        method="get"
                                                        >{{ page }}</Link
                                                    >
                                                </li>
                                                <li
                                                    class="page-item"
                                                    :class="{
                                                        disabled:
                                                            !queues.next_page_url,
                                                    }"
                                                >
                                                    <Link
                                                        class="page-link"
                                                        :href="`${
                                                            queues.next_page_url
                                                                ? queues.next_page_url
                                                                : ''
                                                        }`"
                                                        method="get"
                                                        >Next</Link
                                                    >
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <Foot :setting="props.setting" />
</template>

<script setup>
import "../../../css/dashboard.css";
import AppMeta from "@/Components/AppMeta.vue";
import { toast } from "vue3-toastify";
import Head from "../../Layout/Operator/Header.vue";
import Foot from "../../Layout/Monitor/Footer.vue";

import { computed } from "vue";
import { useForm, Link, usePage, router } from "@inertiajs/vue3";
import { ref } from "vue";

const isSubmitting = ref(null);

const setting = defineProps([
    "queues",
    "category_id",
    "counter_id",
    "SisaAntrian",
    "counter_name",
    // "QueuenNo",
    "totalAntrian",
]);
const { props } = usePage();

// const propsPage = usePage();

const callQueue = async (queue) => {
    const form = useForm({
        status: 2,
        counter_id: props.counter_id,
    });

    isSubmitting.value = queue.id;

    form.post(`/queues/${queue.id}/call`, {
        onSuccess: () => {
            toast.success("Antrian Berhasil Dipanggil!");
        },
        onFinish: () => {
            isSubmitting.value = null;
        },
    });
};

const successQueue = async (queue) => {
    const form = useForm({
        status: 4,
        counter_id: props.counter_id,
    });
    form.post(`/queues/${queue.id}/call`, {
        onSuccess: () => {
            toast.success("Antrian Berhasil Diterima!");
        },
    });
};

const batalQueue = async (queue) => {
    const form = useForm({
        status: 5,
        counter_id: props.counter_id,
    });
    form.post(`/queues/${queue.id}/call`, {
        onSuccess: () => {
            toast.success("Antrian Tidak Diterima!");
        },
    });
};

const refreshData = () => {
    const form = useForm({
        status: 2,
        counter_id: props.counter_id,
        category_id: props.category_id,
        operator_id: props.operator_id,
    });

    form.patch(`/queues/refresh`, {
        onSuccess: () => {
            toast.success("Antrian berhasil di-refresh!");
            router.reload();
        },
        onError: (error) => {
            const errorMessage =
                error.response?.data?.errors?.error ||
                "No Antrian tidak tesedia!";
            toast.error(errorMessage);
            router.reload();
        },
    });
};

const pages = computed(() => {
    const totalPages = props.queues.last_page;
    return Array.from({ length: totalPages }, (_, i) => i + 1);
});
</script>

<style>
.call-button {
    width: 30px;
    height: 30px;
    padding: 0;
}

.call-icon {
    font-size: 17px;
}

.button-refresh {
    display: block;
    padding: 0;
    margin: 0;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
}

.info-box-content {
    text-align: left; /* pastikan text berada di kiri */
}
</style>
