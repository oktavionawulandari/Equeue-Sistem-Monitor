<template>
    <AppMeta title="Dashboard" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link :href="route('dashboard')">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ jmlPengunjung }}</h3>
                            <p>Pengunjung Hari ini</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer"
                            >More info <i class="fas fa-arrow-circle-right"></i
                        ></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ PengunjungSelesai }}</h3>
                            <p>Pengunjung Selesai</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer"
                            >More info <i class="fas fa-arrow-circle-right"></i
                        ></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ PengunjungBatal }}</h3>
                            <p>Pengunjung Batal</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer"
                            >More info <i class="fas fa-arrow-circle-right"></i
                        ></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Laporan Kujungan Bulanan</h3>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="KunjunganBulanan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Dasboard from "../Layout/Dasboard.vue";
import AppMeta from "@/Components/AppMeta.vue";

export default {
    layout: (h, page) => h(Dasboard, [page]),

    layout: Dasboard,
};
</script>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import { Chart } from "chart.js";

const props = defineProps([
    "queues",
    "jmlPengunjung",
    "PengunjungSelesai",
    "PengunjungBatal",
    "KunjunganBulanan",
]);
const jmlPengunjung = ref(props.jmlPengunjung ?? 0);
const PengunjungSelesai = ref(props.PengunjungSelesai ?? 0);
const PengunjungBatal = ref(props.PengunjungBatal ?? 0);

const monthNames = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
];

const monthlyVisitsData = props.KunjunganBulanan.map((data) => ({
    month: monthNames[data.month - 1],
    year: data.year,
    total_visitors: data.total_visitors,
}));

onMounted(() => {
    const ctx = document.getElementById("KunjunganBulanan").getContext("2d");

    new Chart(ctx, {
        type: "line",
        data: {
            labels: monthlyVisitsData.map((item) => `${item.month}`),
            datasets: [
                {
                    label: "Total Pengunjung",
                    data: monthlyVisitsData.map((item) => item.total_visitors),
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: "top",
                },
            },
        },
    });
});
</script>
