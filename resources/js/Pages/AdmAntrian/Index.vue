<template>
    <AppMeta title="No Antrian" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">No Antrian</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link :href="route('dashboard')">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item active">No Antrian</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="applyFilter">
                                <div class="form-row align-items-end">
                                    <div class="col-6">
                                        <label for="search">No Antrian</label>
                                        <input
                                            v-model="filters.search"
                                            @input="filterLoket"
                                            type="text"
                                            class="form-control"
                                            placeholder="Cari No Antrian..."
                                        />
                                    </div>
                                    <div class="col-6">
                                        <label for="date">Tanggal</label>
                                        <input
                                            v-model="filters.date"
                                            @change="filterLoket"
                                            type="date"
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="searchCategory"
                                            >Kategori</label
                                        >
                                        <div>
                                            <div
                                                v-for="category in categories"
                                                :key="category.id"
                                                class="form-check form-check-inline"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    :id="category.id"
                                                    :value="category.id"
                                                    v-model="
                                                        filters.selectedLokets
                                                    "
                                                    @change="filterLoket"
                                                />
                                                <label
                                                    class="form-check-label"
                                                    :for="category.id"
                                                    >{{ category.name }}</label
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="col-6 d-flex justify-content-end mt-3"
                                    >
                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                        >
                                            Filter
                                        </button>
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
                                        v-for="(t, index) in transaction.data"
                                        :key="t.id"
                                    >
                                        <td class="text-center">
                                            {{
                                                index +
                                                1 +
                                                (transaction.current_page - 1) *
                                                    transaction.per_page
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
                                    <nav>
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
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AppMeta from "@/Components/AppMeta.vue";

const props = defineProps(["transaction", "categories"]);

const filters = ref({
    search: "",
    date: new Date().toISOString().split("T")[0],
    selectedLokets: [],
});

const applyFilter = () => {
    changePage(1);
};

const changePage = (page) => {
    if (page < 1 || page > props.transaction.last_page) return;
    router.get(
        "/data/antrian",
        {
            ...filters.value,
            page: page,
            searchCategory: filters.value.selectedLokets,
            submit: "filter",
        },
        { preserveState: true }
    );
};
</script>

<script>
import Dasboard from "../../Layout/Dasboard.vue";

export default {
    layout: Dasboard,
};
</script>
