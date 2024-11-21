<template>
    <AppMeta title="Data Instansi" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6 col-sm-12">
                    <h1 class="m-0 text-uppercase">Data Instansi</h1>
                </div>
                <div class="col-sm-6 col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link :href="route('dashboard')">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item active">Data Instansi</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div
                            class="card-header d-flex justify-content-between align-items-center"
                        >
                            <Link
                                href="/instansi/create"
                                class="btn btn-primary"
                            >
                                <i class="fas fa-plus pr-2"></i>Tambah
                            </Link>
                        </div>

                        <div class="card-body table-responsive">
                            <table
                                class="table table-striped table-bordered table-hover text-nowrap"
                            >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Logo</th>
                                        <th>Nama Instansi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="props.instansi.data.length === 0">
                                        <td colspan="5" class="text-center">
                                            Data Tidak Tersedia
                                        </td>
                                    </tr>
                                    <tr
                                        v-for="(i, index) in props.instansi.data"
                                        :key="i.id"
                                    >
                                        <td>{{ index + 1  + (props.instansi.current_page - 1) * props.instansi.per_page }}</td>
                                        <td>
                                            <img
                                                :src="`/storage/instansi/${i.logo}`"
                                                alt="Logo"
                                                width="70"
                                                height="70"
                                            />
                                        </td>
                                        <td>{{ i.name }}</td>
                                        <td>
                                            <span
                                                class="badge badge-primary"
                                                v-if="i.active == 1"
                                                >Aktif</span
                                            >
                                            <span
                                                class="badge badge-danger"
                                                v-else="i.active == 0"
                                                >Tidak Aktif</span
                                            >
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button
                                                    @click="editInstansi(i.id)"
                                                    class="btn btn-warning btn-sm"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    @click="confirmDelete(i.id)"
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
                                    <nav v-if="props.instansi.total > props.instansi.per_page">
                                        <ul class="pagination justify-content-start">
                                            <li class="page-item" :class="{ disabled: !props.instansi.prev_page_url }">
                                                <Link class="page-link" :href="'#'" @click.prevent="changePage(props.instansi.current_page - 1)">Previous</Link>
                                            </li>
                                            <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: props.instansi.current_page === page }">
                                                <Link class="page-link" :href="'#'" @click.prevent="changePage(page)">{{ page }}</Link>
                                            </li>
                                            <li class="page-item" :class="{ disabled: !props.instansi.next_page_url }">
                                                <Link class="page-link" :href="'#'" @click.prevent="changePage(props.instansi.current_page + 1)">Next</Link>
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
</template>


<script>
import Dasboard from "../../Layout/Dasboard.vue";

export default {
    layout: (h, page) => h(Dasboard, [page]),

    layout: Dasboard,
};
</script>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import AppMeta from "@/Components/AppMeta.vue";
import { toast } from "vue3-toastify";
import { computed } from "vue";

const props = defineProps(["instansi"]);

function editInstansi(id) {
    router.get(`/instansi/${id}/edit`);
}

function confirmDelete(id) {
    if (confirm("Apakah Anda yakin ingin menghapus instansi ini?")) {
        deleteInstansi(id);
    }
}

function deleteInstansi(id) {
    router.delete(`/instansi/${id}`, {
        onSuccess: () => {
            toast.success("Data Instansi Berhasil Dihapus!");
            router.visit("/instansi");
        },
        onError: (error) => {
            console.error("Delete failed:", error);
        },
    });
}

function changePage(page) {
    if (page !== props.instansi.current_page) {
        router.get(`/loket?page=${page}`);
    }
}

const totalPages = computed(() => {
    const totalPages = props.instansi.last_page;
    return Array.from({ length: totalPages }, (_, i) => i + 1);
});
</script>
