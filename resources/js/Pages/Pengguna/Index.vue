<template>
    <AppMeta title="Data User" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Data User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link :href="route('dashboard')">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item active">Data User</li>
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
                                href="/pengguna/create"
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
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="props.users.data.length === 0">
                                        <td colspan="5" class="text-center">
                                            Data Tidak Tersedia
                                        </td>
                                    </tr>
                                    <tr
                                        v-for="(user, index) in props.users.data"
                                        :key="user.id"
                                    >
                                        <td>{{ index + 1 + (props.users.current_page - 1) * props.users.per_page }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.username }}</td>
                                        <td>{{ user.role }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button
                                                    @click="editLoket(user.id)"
                                                    class="btn btn-warning btn-sm"
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    @click="confirmDelete(user.id)"
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
                                    <nav v-if="props.users.total > props.users.per_page">
                                        <ul class="pagination justify-content-start">
                                            <li class="page-item" :class="{ disabled: !props.users.prev_page_url }">
                                                <Link class="page-link" :href="'#'" @click.prevent="changePage(props.users.current_page - 1)">Previous</Link>
                                            </li>
                                            <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: props.users.current_page === page }">
                                                <Link class="page-link" :href="'#'" @click.prevent="changePage(page)">{{ page }}</Link>
                                            </li>
                                            <li class="page-item" :class="{ disabled: !props.users.next_page_url }">
                                                <Link class="page-link" :href="'#'" @click.prevent="changePage(props.users.current_page + 1)">Next</Link>
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

const props = defineProps(["users"]);

function editLoket(id) {
    router.get(`/pengguna/${id}/edit`);
}

function confirmDelete(id) {
    if (confirm("Apakah Anda yakin ingin menghapus loket ini?")) {
        deleteLoket(id);
    }
}

function deleteLoket(id) {
    router.delete(`/pengguna/${id}`, {
        onSuccess: () => {
            toast.success("Data Pengguna Berhasil Dihapus!");
            router.visit("/pengguna");
        },
        onError: (error) => {
            console.error("Delete failed:", error);
        },
    });
}

function changePage(page) {
    if (page !== props.users.current_page) {
        router.get(`/pengguna?page=${page}`);
    }
}

const totalPages = computed(() => {
    const totalPages = props.users.last_page;
    return Array.from({ length: totalPages }, (_, i) => i + 1);
});
</script>
