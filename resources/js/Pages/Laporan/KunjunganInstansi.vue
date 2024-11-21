<template>
    <AppMeta title="Laporan Kunjungan" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Laporan Kunjungan Per-Instansi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link href="/dashboard">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item active">
                            Laporan Kunjungan
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Filter Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="applyFilter">
                                <div class="form-row">
                                    <div class="col-md-3 mb-3">
                                        <label for="startDate">Tanggal Mulai</label>
                                        <input
                                            type="date"
                                            v-model="filters.startDate"
                                            class="form-control"
                                            id="startDate"
                                            placeholder="Pilih Tanggal"
                                        />
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="endDate">Tanggal Selesai</label>
                                        <input
                                            type="date"
                                            v-model="filters.endDate"
                                            class="form-control"
                                            id="endDate"
                                            placeholder="Pilih Tanggal"
                                        />
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="searchInstansi">Instansi</label>
                                        <select
                                            class="form-control"
                                            v-model="filters.searchInstansi"
                                            id="searchInstansi"
                                            @change="loadCategories(filters.searchInstansi)"
                                        >
                                            <option value="" disabled>Pilih Instansi...</option>
                                            <option v-for="ins in instansi" :key="ins.id" :value="ins.id">
                                                {{ ins.name }}
                                            </option>
                                        </select>
                                        <span v-if="errors.searchInstansi" class="text-danger">{{ errors.searchInstansi }}</span>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="searchCategory">Kategori</label>
                                        <select
                                            class="form-control"
                                            v-model="filters.searchCategory"
                                            id="searchCategory"
                                        >
                                            <option value="" disabled>Pilih Kategori...</option>
                                            <option v-for="category in filteredCategories" :key="category.id" :value="category.id">
                                                {{ category.name }}
                                            </option>
                                        </select>
                                        <span v-if="errors.searchCategory" class="text-danger">{{ errors.searchCategory }}</span>
                                    </div>
                                </div>

                                <div class="form-row mt-3">
                                    <div class="col-4 col-md-1">
                                        <button type="submit" class="btn btn-success w-100">Filter</button>
                                    </div>
                                    <div class="col-4 col-md-1">
                                        <button type="button" class="btn btn-danger w-100" @click="handleAction('pdf')">PDF</button>
                                    </div>
                                    <div class="col-4 col-md-1">
                                        <a :href="linkAction" target="_blank" class="btn btn-info w-100">Excel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-striped table-hover table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Antrian</th>
                                        <th>Kategori</th>
                                        <th>Nama Loket</th>
                                        <th>Status</th>
                                        <th>Operator</th>
                                        <th>Tanggal</th>
                                        <th>Instansi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="isFilterApplied" v-for="(t, index) in transaction.data" :key="t.id">
                                        <td class="text-center">{{ index + 1 + (transaction.current_page - 1) * transaction.per_page }}</td>
                                        <td class="text-center">{{ t.queue?.no ?? "-" }}</td>
                                        <td>{{ t.category?.name ?? "-" }}</td>
                                        <td>{{ t.counter?.name ?? "-" }}</td>
                                        <td>
                                            <span
                                                class="badge"
                                                :class="{
                                                    'badge-primary': t.queue.status == 1,
                                                    'badge-warning': t.queue.status == 2 || t.queue.status == 3,
                                                    'badge-success': t.queue.status == 4,
                                                    'badge-danger': t.queue.status == 5
                                                }"
                                            >
                                                {{
                                                    t.queue.status == 1
                                                        ? "Menunggu"
                                                        : t.queue.status == 2 || t.queue.status == 3
                                                        ? "Dipanggil"
                                                        : t.queue.status == 4
                                                        ? "Berhasil"
                                                        : t.queue.status == 5
                                                        ? "Dibatalkan"
                                                        : "N/A"
                                                }}
                                            </span>
                                        </td>
                                        <td>{{ t.user?.name ?? "-" }}</td>
                                        <td>{{ t.date }}</td>
                                        <td>{{ t.instansi?.name ?? "-" }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" @click="openDetailModal(t)">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>

                                    <tr v-if="isFilterApplied && transaction.data.length === 0">
                                        <td colspan="9" class="text-center">Data tidak tersedia.</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="row mt-2">
                                <div class="col-12">
                                    <nav v-if="isFilterApplied">
                                        <ul class="pagination justify-content-start">
                                            <li class="page-item" :class="{ disabled: !transaction.prev_page_url }">
                                                <Link class="page-link" :href="'#'" @click.prevent="changePage(transaction.current_page - 1)">Previous</Link>
                                            </li>
                                            <li class="page-item" v-for="page in transaction.last_page" :key="page" :class="{ active: transaction.current_page === page }">
                                                <Link class="page-link" :href="'#'" @click.prevent="changePage(page)">{{ page }}</Link>
                                            </li>
                                            <li class="page-item" :class="{ disabled: !transaction.next_page_url }">
                                                <Link class="page-link" :href="'#'" @click.prevent="changePage(transaction.current_page + 1)">Next</Link>
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

    <!-- Modal Detail -->
    <div v-if="isDetailModalOpen" class="modal fade show" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Kunjungan</h5>
                    <button type="button" class="close" @click="closeDetailModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>No Antrian</th>
                                <td>{{ selectedTransaction.queue?.no ?? "-" }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>{{ selectedTransaction.category?.name ?? "-" }}</td>
                            </tr>
                            <tr>
                                <th>Loket</th>
                                <td>{{ selectedTransaction.counter?.name ?? "-" }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge" :class="{
                                        'badge-primary': selectedTransaction.queue.status == 1,
                                        'badge-warning': selectedTransaction.queue.status == 2 || selectedTransaction.queue.status == 3,
                                        'badge-success': selectedTransaction.queue.status == 4,
                                        'badge-danger': selectedTransaction.queue.status == 5
                                    }">
                                        {{ selectedTransaction.queue.status == 1
                                            ? "Menunggu"
                                            : selectedTransaction.queue.status == 2 || selectedTransaction.queue.status == 3
                                            ? "Dipanggil"
                                            : selectedTransaction.queue.status == 4
                                            ? "Berhasil"
                                            : selectedTransaction.queue.status == 5
                                            ? "Dibatalkan"
                                            : "N/A"
                                        }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Operator</th>
                                <td>{{ selectedTransaction.user?.name ?? "-" }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ selectedTransaction.date }}</td>
                            </tr>
                            <tr>
                                <th>Instansi</th>
                                <td>{{ selectedTransaction.instansi?.name ?? "-" }}</td>
                            </tr>
                            <tr>
                                <th>Instansi</th>
                                <td>{{ selectedTransaction.queue?.phone ?? "-" }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeDetailModal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import AppMeta from "@/Components/AppMeta.vue";

const props = defineProps(["transaction", "categories", "users", "instansi"]);

const filters = ref({
    startDate: new Date().toISOString().split("T")[0],
    endDate: new Date().toISOString().split("T")[0],
    searchCategory: "",
    searchInstansi: ""
});

const isFilterApplied = ref(false);
const linkAction = ref("");
const errors = ref({});
const isDetailModalOpen = ref(false);
const selectedTransaction = ref(null);

// Reactive categories array based on selected instansi
const filteredCategories = ref([]);

// Watch for changes in instansi and load categories accordingly
watch(filters.value.searchInstansi, (newInstansiId) => {
    loadCategories(newInstansiId);
});

watch(filters.value, (value) => {
    linkAction.value = `/laporan/kunjungan/per-instansi?startDate=${value.startDate}&endDate=${value.endDate}&searchCategory=${value.searchCategory}&searchInstansi=${value.searchInstansi}&submit=excel`;
});

const validateInputs = () => {
    errors.value = {};

    if (!filters.value.searchCategory) {
        errors.value.searchCategory = "Masukkan data kategori";
    }
    if (!filters.value.searchInstansi) {
        errors.value.searchInstansi = "Masukkan data instansi";
    }

    return Object.keys(errors.value).length === 0;
};

const applyFilter = () => {
    if (validateInputs()) {
        router.get(
            "/laporan/kunjungan/per-instansi",
            {
                ...filters.value,
                submit: "filter",
            },
            { preserveState: true }
        );
        isFilterApplied.value = true;
    }
};

const changePage = (page) => {
    if (page < 1 || page > props.transaction.last_page) return;
    router.get(
        "/laporan/kunjungan/per-instansi",
        {
            ...filters.value,
            page: page,
            submit: "filter",
        },
        { preserveState: true }
    );
};

const handleAction = (type) => {
    if (type === "pdf" && !validateInputs()) {
        return;
    }

    const params = new URLSearchParams({
        ...filters.value,
        submit: type,
    }).toString();

    if (type === "pdf") {
        window.open(`/laporan/kunjungan/per-instansi?${params}`, "_blank");
    } else if (type === "excel") {
        // Handle Excel export logic here
    }
};

const openDetailModal = (transaction) => {
    selectedTransaction.value = transaction;
    isDetailModalOpen.value = true;
};

const closeDetailModal = () => {
    isDetailModalOpen.value = false;
};

// Load categories based on selected instansi
const loadCategories = async (instansiId) => {
    if (instansiId) {
        filteredCategories.value = props.categories.filter(category => category.instansi_id === instansiId);
    } else {
        filteredCategories.value = [];
    }
};

</script>
<script>
import Dasboard from "../../Layout/Dasboard.vue";

export default {
    layout: Dasboard,
};
</script>
