<template>
    <AppMeta title="Laporan Layanan" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Laporan Layanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link href="/dashboard">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item active">Laporan Layanan</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="applyFilter">
                                <div class="form-row">
                                    <div class="col-md-3 mb-3">
                                        <label for="startDate"
                                            >Tanggal Mulai</label
                                        >
                                        <input
                                            type="date"
                                            v-model="filters.startDate"
                                            class="form-control"
                                            id="startDate"
                                            placeholder="Pilih Tanggal"
                                        />
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="endDate"
                                            >Tanggal Selesai</label
                                        >
                                        <input
                                            type="date"
                                            v-model="filters.endDate"
                                            class="form-control"
                                            id="endDate"
                                            placeholder="Pilih Tanggal"
                                        />
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="searchCategory"
                                            >Kategori</label
                                        >
                                        <select
                                            class="form-control"
                                            v-model="filters.searchCategory"
                                            id="searchCategory"
                                        >
                                            <option value="" selected>
                                                Pilih Kategori...
                                            </option>
                                            <option
                                                v-for="category in categories"
                                                :key="category.id"
                                                :value="category.id"
                                            >
                                                {{ category.name }}
                                            </option>
                                        </select>
                                        <span
                                            v-if="errors.searchCategory"
                                            class="text-danger"
                                            >{{ errors.searchCategory }}</span
                                        >
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="searchCategory"
                                            >Operator</label
                                        >
                                        <select
                                            class="form-control"
                                            v-model="filters.searchUser"
                                            id="searchUser"
                                        >
                                            <option value="" selected>
                                                Pilih Operator...
                                            </option>
                                            <option
                                                v-for="user in users"
                                                :key="user.id"
                                                :value="user.id"
                                            >
                                                {{ user.name }}
                                            </option>
                                        </select>
                                        <span
                                            v-if="errors.searchUser"
                                            class="text-danger"
                                            >{{ errors.searchUser }}</span
                                        >
                                    </div>
                                </div>
                                <div class="form-row mt-3">
                                    <div class="col-2 col-md-1">
                                        <button
                                            type="submit"
                                            class="btn btn-success w-100"
                                        >
                                            Filter
                                        </button>
                                    </div>
                                    <div class="col-2 col-md-1">
                                        <button
                                            type="button"
                                            class="btn btn-danger w-100"
                                            @click="() => handleAction('pdf')"
                                        >
                                            PDF
                                        </button>
                                    </div>
                                    <div class="col-2 col-md-1">
                                        <a
                                            :href="linkAction"
                                            target="_blank"
                                            class="btn btn-info w-100"
                                            >Excel</a
                                        >
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table
                                class="table table-striped table-hover table-bordered text-nowrap"
                            >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Antrian</th>
                                        <th>Kategori</th>
                                        <th>Nama Loket</th>
                                        <th>Status</th>
                                        <th>Operator</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-if="isFilterApplied"
                                        v-for="(t, index) in transaction.data"
                                        :key="t.id"
                                    >
                                        <td class="text-center">
                                            {{
                                                (transaction.current_page - 1) *
                                                    transaction.per_page +
                                                index +
                                                1
                                            }}
                                        </td>
                                        <td class="text-center">
                                            {{ t.queue?.no ?? "-" }}
                                        </td>
                                        <td>{{ t.category?.name ?? "-" }}</td>
                                        <td>{{ t.counter?.name ?? "-" }}</td>
                                        <td>
                                            <span
                                                class="badge"
                                                :class="{
                                                    'badge-primary':
                                                        t.queue.status == 1,
                                                    'badge-warning':
                                                        t.queue.status == 2 ||
                                                        t.queue.status == 3,
                                                    'badge-success':
                                                        t.queue.status == 4,
                                                    'badge-danger':
                                                        t.queue.status == 5,
                                                }"
                                            >
                                                {{
                                                    t.queue.status == 1
                                                        ? "Menunggu"
                                                        : t.queue.status == 2 ||
                                                          t.queue.status == 3
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
                                    </tr>
                                    <tr
                                        v-if="
                                            isFilterApplied &&
                                            transaction.data.length === 0
                                        "
                                    >
                                        <td colspan="7" class="text-center">
                                            Data tidak tersedia.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <nav v-if="isFilterApplied">
                                        <ul
                                            class="pagination justify-content-start"
                                        >
                                            <li
                                                class="page-item"
                                                :class="{
                                                    disabled:
                                                        !transaction.prev_page_url,
                                                }"
                                            >
                                                <Link
                                                    class="page-link"
                                                    @click.prevent="
                                                        changePage(
                                                            transaction.current_page -
                                                                1
                                                        )
                                                    "
                                                    >Previous</Link
                                                >
                                            </li>
                                            <li
                                                class="page-item"
                                                v-for="page in transaction.last_page"
                                                :key="page"
                                                :class="{
                                                    active:
                                                        transaction.current_page ===
                                                        page,
                                                }"
                                            >
                                                <Link
                                                    class="page-link"
                                                    @click.prevent="
                                                        changePage(page)
                                                    "
                                                    >{{ page }}</Link
                                                >
                                            </li>
                                            <li
                                                class="page-item"
                                                :class="{
                                                    disabled:
                                                        !transaction.next_page_url,
                                                }"
                                            >
                                                <Link
                                                    class="page-link"
                                                    @click.prevent="
                                                        changePage(
                                                            transaction.current_page +
                                                                1
                                                        )
                                                    "
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
    </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import AppMeta from "@/Components/AppMeta.vue";

const props = defineProps(["transaction", "categories", "users"]);

const filters = ref({
    startDate: new Date().toISOString().split("T")[0],
    endDate: new Date().toISOString().split("T")[0],
    searchCategory: "",
    searchUser: "",
});

const isFilterApplied = ref(false);
const linkAction = ref("");
const errors = ref({});

watch(filters.value, (value) => {
    linkAction.value = `/laporan/layanan?startDate=${value.startDate}&endDate=${value.endDate}&searchCategory=${value.searchCategory}&searchUser=${value.searchUser}&submit=excel`;
});

const validateInputs = () => {
    errors.value = {};

    if (!filters.value.searchCategory) {
        errors.value.searchCategory = "Masukkan data kategori";
    }

    if (!filters.value.searchUser) {
        errors.value.searchUser = "Masukkan data operator";
    }

    return Object.keys(errors.value).length === 0;
};

const applyFilter = () => {
    if (validateInputs()) {
        router.get(
            "/laporan/layanan",
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
        "/laporan/layanan",
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
        window.open(`/laporan/layanan?${params}`, "_blank");
    } else if (type === "excel") {
    }
};
</script>

<script>
import Dasboard from "../../Layout/Dasboard.vue";

export default {
    layout: Dasboard,
};
</script>
