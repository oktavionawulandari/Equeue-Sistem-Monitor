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
                        <Link href="/home" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Home</p>
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