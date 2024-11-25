<template>
    <AppMeta title="Kategori Layanan" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Kategori Layanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link :href="route('dashboard')">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item active">Kategori Layanan</li>
                    </ol>
                </div>
            </div>

            <!-- Pesan Error -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div
                            class="card-header d-flex justify-content-between align-items-center"
                        >
                            <Link
                                href="/category/create"
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
                                        <th>Nama Kategori</th>
                                        <th>Kode</th>
                                        <th>Instansi</th>
                                        <th>Catatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="props.categories.data.length === 0">
                                        <td colspan="6" class="text-center">
                                            Data Tidak Tersedia
                                        </td>
                                    </tr>
                                    <tr
                                        v-for="(
                                            category, index
                                        ) in props.categories.data"
                                        :key="category.id"
                                    >
                                        <td>{{ index + 1 + (props.categories.current_page - 1) * props.categories.per_page }}</td>
                                        <td>{{ category.name }}</td>
                                        <td>{{ category.kode }}</td>
                                        <td>
                                            {{
                                                category.instansi
                                                    ? category.instansi.name
                                                    : "N/A"
                                            }}
                                        </td>
                                        <td>{{ category.catatan }}</td>
                                        <td>
                                            <div class="d-flex gap-2 ">
                                                <button
                                                    @click="
                                                        editLoket(category.id)
                                                    "
                                                    class="btn btn-warning btn-sm mr-2"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    @click="
                                                        confirmDelete(
                                                            category.id
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
                                    <nav v-if="props.categories.total > props.categories.per_page">
                                        <ul class="pagination justify-content-start">
                                            <li class="page-item" :class="{ disabled: !props.categories.prev_page_url }">
                                                <Link class="page-link" :href="'#'" @click.prevent="changePage(props.categories.current_page - 1)">Previous</Link>
                                            </li>
                                            <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: props.categories.current_page === page }">
                                                <Link class="page-link" :href="'#'" @click.prevent="changePage(page)">{{ page }}</Link>
                                            </li>
                                            <li class="page-item" :class="{ disabled: !props.categories.next_page_url }">
                                                <Link class="page-link" :href="'#'" @click.prevent="changePage(props.categories.current_page + 1)">Next</Link>
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
<script setup>
import { Link, router } from "@inertiajs/vue3";
import AppMeta from "@/Components/AppMeta.vue";
import { toast } from "vue3-toastify";
import { computed } from "vue";

const props = defineProps([
    "categories",
]);

function editLoket(id) {
    router.get(`/category/${id}/edit`);
}

function confirmDelete(id) {
    if (confirm("Apakah Anda yakin ingin menghapus loket ini?")) {
        deleteLoket(id);
    }
}

function deleteLoket(id) {
    router.delete(`/category/${id}`, {
        onSuccess: () => {
            toast.success("Data Kategori Berhasil Dihapus!");
            router.visit("/category");
        },
        onError: (error) => {
            console.error("Delete failed:", error);
        },
    });
}

function changePage(page) {
    if (page !== props.categories.current_page) {
        router.get(`/category?page=${page}`);
    }
}

const totalPages = computed(() => {
    const totalPages = props.categories.last_page;
    return Array.from({ length: totalPages }, (_, i) => i + 1);
});
</script>

<script>
import Dasboard from "../../Layout/Dasboard.vue";

export default {
    layout: Dasboard,
};
</script>
