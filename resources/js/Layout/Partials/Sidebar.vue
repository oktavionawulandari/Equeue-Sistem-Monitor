<template>
    <AppMeta>
        <link
            rel="icon"
            :href="`/storage/logo/${setting?.logo}`"
            type="image/x-icon"
        />
    </AppMeta>

    <aside class="main-sidebar sidebar-dark-success elevation-4">
        <a class="brand-link d-flex align-items-center">
            <img
                :src="`/storage/logo/${setting?.logo}`"
                alt="logo"
                width="50"
                class="me-2"
            />
            <span class="brand-text font-weight-light text-bold">{{
                setting?.instansi
            }}</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul
                    class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false"
                >
                    =
                    <li class="nav-item">
                        <Link
                            href="/dashboard"
                            :class="[
                                $page.url === '/dashboard'
                                    ? 'nav-link active'
                                    : 'nav-link',
                            ]"
                        >
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            href="/setting"
                            :class="[
                                $page.url.startsWith('/setting')
                                    ? 'nav-link active'
                                    : 'nav-link',
                            ]"
                        >
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Setting</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            href="/pengguna"
                            :class="[
                                $page.url.startsWith('/pengguna')
                                    ? 'nav-link active'
                                    : 'nav-link',
                            ]"
                        >
                            <i class="nav-icon far fa-user"></i>
                            <p>Data User</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            href="/instansi"
                            :class="[
                                $page.url.startsWith('/instansi')
                                    ? 'nav-link active'
                                    : 'nav-link',
                            ]"
                        >
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>Instansi</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            href="/category"
                            :class="[
                                $page.url.startsWith('/category')
                                    ? 'nav-link active'
                                    : 'nav-link',
                            ]"
                        >
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Kategori Layanan</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            href="/loket"
                            :class="[
                                $page.url.startsWith('/loket')
                                    ? 'nav-link active'
                                    : 'nav-link',
                            ]"
                        >
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Loket Layanan</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            href="/data/antrian"
                            :class="[
                                $page.url.startsWith('/data/antrian')
                                    ? 'nav-link active'
                                    : 'nav-link',
                            ]"
                        >
                            <i class="nav-icon fas fa-ticket-alt"></i>
                            <p>No Antrian</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            href="/laporan/pengunjung"
                            :class="[
                                $page.url.startsWith('/laporan/pengunjung')
                                    ? 'nav-link active'
                                    : 'nav-link',
                            ]"
                        >
                            <i class="nav-icon fas fa-users"></i>
                            <p>Laporan Pengunjung</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            href="/laporan/layanan"
                            :class="[
                                $page.url.startsWith('/laporan/layanan')
                                    ? 'nav-link active'
                                    : 'nav-link',
                            ]"
                        >
                            <i class="nav-icon fas fa-headset"></i>
                            <p>Laporan Layanan</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            href="/laporan/kunjungan/per-instansi"
                            :class="[
                                $page.url.startsWith(
                                    '/laporan/kunjungan/per-instansi'
                                )
                                    ? 'nav-link active'
                                    : 'nav-link',
                            ]"
                        >
                            <i class="nav-icon fas fa-headset"></i>
                            <p>Laporan Kujungan Per-Instansi</p>
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>

<script setup>
import AppMeta from "@/Components/AppMeta.vue";
import { Link } from "@inertiajs/vue3";
const props = defineProps(["setting"]);
</script>
