<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index3.html" class="brand-link">
            <span class="brand-text font-weight-light me-5">AdminLTE 3</span>
        </a>

        <div class="sidebar">
            <div class="form-inline mt-3 mb-3 d-flex">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <Link href="/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </Link>
                    </li>
                    <li class="nav-header">DATA</li>
                    <li class="nav-item">
                        <Link href="/loket" class="nav-link">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Daftar Loket</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link href="/no-antrian" class="nav-link">
                            <i class="nav-icon fas fa-ticket-alt"></i>
                            <p>No Antrian</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link href="/pengguna" class="nav-link">
                            <i class="nav-icon far fa-user"></i>
                            <p>Daftar Pengguna</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link href="/category" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Jenis Antrian</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link href="/setting" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Setting</p>
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>