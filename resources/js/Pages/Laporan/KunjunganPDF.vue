<template>
    <AppMeta :title="`${startDate} - ${endDate}_${categoryName}`">
        <link
            rel="icon"
            :href="`/storage/logo/${setting?.logo}`"
            type="image/x-icon"
        />
    </AppMeta>

    <div class="container">
        <div class="header d-flex align-items-center">
            <img
                :src="`/storage/logo/${setting?.logo}`"
                alt="logo"
                width="100"
                height="100"
                class="me-2"
            />
            <div class="ms-3">
                <h1 class="report-title">LAPORAN Kunjungan Per-Instansi</h1>
                <h1 class="institution-name">{{ setting?.instansi }}</h1>
                <p class="address">{{ setting?.address }}</p>
                <p class="address">
                    {{ setting?.phone }} / {{ setting?.email }}
                </p>
            </div>
        </div>
        <hr class="divider" />
        <div class="text-center mt-4">
            <h2 class="periode">PERIODE LAPORAN</h2>
            <p class="address">{{ startDate || "-" }} - {{ endDate || "-" }}</p>
        </div>
        <div class="pengelola">
            <p class="address">Instansi: {{ instansiName }}</p>
        </div>
        <div class="pengelola mb-5">
            <p class="address">Kategori: {{ categoryName }}</p>
        </div>


        <div class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Antrian</th>
                    <th>Nama Loket</th>
                    <th>Pengelola</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>HP</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(t, index) in transaction" :key="t.id">
                    <td class="text-center">{{ index + 1 }}</td>
                    <td class="text-center">{{ t.queue?.no ?? "-" }}</td>
                    <td>{{ t.counter?.name ?? "-" }}</td>
                    <td>{{ t.user?.name ?? "-" }}</td>
                    <td>
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
                    </td>
                    <td>{{ t.date }}</td>
                    <td>{{ t.queue?.phone ?? "-"}}</td>

                </tr>
                <tr v-if="transaction.length === 0">
                    <td colspan="7" class="text-center">
                        Data tidak tersedia.
                    </td>
                </tr>
            </tbody>
        </div>
    </div>
</template>

<script setup>
import { onMounted, nextTick, computed } from "vue";
import AppMeta from "@/Components/AppMeta.vue";

const props = defineProps({
    transaction: Object,
    categories: Array,
    setting: Object,
    startDate: String,
    endDate: String,
    searchCategory: String,
    searchInstansi: String,
    instansi: Array,
    users: Array,
});

const categoryName = computed(() => {
    const category = props.categories.find(
        (cat) => cat.id == props.searchCategory
    );
    return category ? category.name : "Semua Kategori";
});

const instansiName = computed(() => {
    const instansi = props.instansi.find(
        (ins) => ins.id == props.searchInstansi
    );
    return instansi ? instansi.name : "Semua Instansi";
});

onMounted(() => {
    nextTick(() => {
        window.print();
    });
});
</script>

<style scoped>
.container {
    margin: 0 auto;
}

.report-title {
    font-size: 1.3rem;
    font-weight: bold;
}

.institution-name {
    font-size: 1.3rem;
    font-weight: bold;
}

.address {
    font-size: 0.8rem;
}

.periode {
    font-size: 0.8rem;
    font-weight: bold;
}

.header {
    display: flex;
    align-items: center;
}

.divider {
    margin: 20px 0;
    border: none;
    border-top: 1px solid #000000;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 10px;
    text-align: left;
    border: 1px solid #000000;
}
</style>
