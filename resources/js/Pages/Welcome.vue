<template>
    <AppMeta title="Home" />

    <div class="d-flex flex-column min-vh-100">
        <Header :setting="props?.setting" />

        <div class="container-fluid">
            <div class="row gx-3 me-5 ms-5 mb-5">
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div
                                class="feature-icon-1 bg-success bg-gradient mb-4"
                            >
                                <i class="fa fa-desktop" aria-hidden="true"></i>
                            </div>
                            <h3>Monitor Antrian</h3>
                            <p class="mb-5">
                                Halaman Monitor Antrian digunakan menampilkan
                                antrian pada monitor.
                            </p>
                            <Link
                                :href="route('monitor')"
                                class="btn btn-success rounded-pill px-4 py-2"
                            >
                                Tampilkan <i class="fa fa-arrow-right ms-2"></i>
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div
                                class="feature-icon-1 bg-success bg-gradient mb-4"
                            >
                                <i class="fa fa-users"></i>
                            </div>
                            <h3>Nomor Antrian</h3>
                            <p class="mb-5">
                                Halaman Nomor Antrian digunakan pengunjung untuk
                                mengambil nomor antrian.
                            </p>
                            <Link
                                :href="route('list.instansi')"
                                class="btn btn-success rounded-pill px-4 py-2"
                            >
                                Tampilkan <i class="fa fa-arrow-right ms-2"></i>
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div
                                class="feature-icon-1 bg-success bg-gradient mb-4"
                            >
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <h3 class="text-bold">Login Petugas</h3>
                            <p class="mb-5">
                                Halaman Login Petugas digunakan petugas loket
                                untuk mengakses sistem dan melayani antrian
                                pelanggan.
                            </p>
                            <Link
                                :href="route('login')"
                                class="btn btn-success rounded-pill px-4 py-2"
                            >
                                Tampilkan <i class="fa fa-arrow-right ms-2"></i>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Foot :setting="props.setting" />
    </div>
</template>

<script setup>
import Foot from "../Layout/Monitor/Footer.vue";
import Header from "../Layout/Monitor/Header.vue";
import "../../css/dashboard.css";
import AppMeta from "@/Components/AppMeta.vue";
import { Link, usePage } from "@inertiajs/vue3";

const { props } = usePage()
</script>

<style setup>
.feature-icon-1 {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #28a745;
    color: white;
    font-size: 24px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: background 0.3s ease, transform 0.3s ease;
}

.feature-icon-1:hover {
    background: #218838;
    transform: scale(1.1);
}
</style>
