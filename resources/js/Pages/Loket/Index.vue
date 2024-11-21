<template>
    <AppMeta title="Loket Layanan" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-6 col-sm-12">
                    <h1 class="m-0 text-uppercase">Loket Layanan</h1>
                </div>
                <div class="col-md-6 col-sm-12">
                    <ol class="breadcrumb float-md-right float-sm-none">
                        <li class="breadcrumb-item">
                            <Link href="/dashboard">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item active">Loket Layanan</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div
                            class="card-header d-flex justify-content-between align-items-center"
                        >
                            <Link href="/loket/create" class="btn btn-primary">
                                <i class="fas fa-plus pr-2"></i>Tambah
                            </Link>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table table-striped table-bordered table-hover mb-0"
                                >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomer Loket</th>
                                            <th>Nama Loket</th>
                                            <th>Jenis Antrian</th>
                                            <th>Instansi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-if="props.lokets.data.length === 0">
                                        <td colspan="6" class="text-center">
                                            Data Tidak Tersedia
                                        </td>
                                    </tr>
                                        <tr
                                            v-for="(
                                                loket, index
                                            ) in props.lokets.data"
                                            :key="loket.id"
                                        >
                                            <td>{{ index + 1  + (props.lokets.current_page - 1) * props.lokets.per_page }}</td>
                                            <td>{{ loket.no }}</td>
                                            <td>{{ loket.name }}</td>
                                            <td>
                                                {{
                                                    loket.category
                                                        ? loket.category.name
                                                        : "N/A"
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    loket.instansi
                                                        ? loket.instansi.name
                                                        : "N/A"
                                                }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button
                                                        @click="
                                                            editLoket(loket.id)
                                                        "
                                                        class="btn btn-warning btn-sm"
                                                    >
                                                        Edit
                                                    </button>
                                                    <button
                                                        @click="
                                                            confirmDelete(
                                                                loket.id
                                                            )
                                                        "
                                                        class="btn btn-danger btn-sm"
                                                    >
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <nav v-if="props.lokets.total > props.lokets.per_page">
                                            <ul class="pagination justify-content-start">
                                                <li class="page-item" :class="{ disabled: !props.lokets.prev_page_url }">
                                                    <Link class="page-link" :href="'#'" @click.prevent="changePage(props.lokets.current_page - 1)">Previous</Link>
                                                </li>
                                                <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: props.lokets.current_page === page }">
                                                    <Link class="page-link" :href="'#'" @click.prevent="changePage(page)">{{ page }}</Link>
                                                </li>
                                                <li class="page-item" :class="{ disabled: !props.lokets.next_page_url }">
                                                    <Link class="page-link" :href="'#'" @click.prevent="changePage(props.lokets.current_page + 1)">Next</Link>
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
        </div>
    </div>
</template>

<script>
import Dasboard from "../../Layout/Dasboard.vue";
import AppMeta from "@/Components/AppMeta.vue";

export default {
    layout: (h, page) => h(Dasboard, [page]),
    layout: Dasboard,
};
</script>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import { computed } from "vue";

const props = defineProps(["lokets"]);
// const { flash } = usePage().props;

function editLoket(id) {
    router.get(`/loket/${id}/edit`);
}

function confirmDelete(id) {
    if (confirm("Apakah Anda yakin ingin menghapus loket ini?")) {
        deleteLoket(id);
    }
}

function deleteLoket(id) {
    router.delete(`/loket/${id}`, {
        onSuccess: () => {
            toast.success("Data Loket Berhasil Dihapus!");
            router.visit("/loket");
        },
        onError: (error) => {
            console.error("Delete failed:", error);
        },
    });
}

function changePage(page) {
    if (page !== props.lokets.current_page) {
        router.get(`/loket?page=${page}`);
    }
}

const totalPages = computed(() => {
    const totalPages = props.lokets.last_page;
    return Array.from({ length: totalPages }, (_, i) => i + 1);
});
</script>
