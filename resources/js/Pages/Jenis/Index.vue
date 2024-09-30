<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Jenis Antrian</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><Link href="/dashboard">Dashboard</Link></li>
                        <li class="breadcrumb-item active">Jenis Antrian</li>
                    </ol>
                </div>
            </div>

            <!-- Pesan Berhasil -->
            <!-- <div v-if="flash.success" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ flash.success }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> -->

            <!-- Pesan Error -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <Link href="/category/create" class="btn btn-primary">
                                <i class="fas fa-plus pr-2"></i>Tambah
                            </Link>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-striped table-bordered table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Antrian</th>
                                        <th>Catatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(category, index) in props.categories" :key="category.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ category.name }}</td>
                                        <td>{{ category.catatan }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-0">
                                                    <button @click="editLoket(category.id)" class="btn btn-warning btn-sm">Edit</button>
                                                </div>
                                                <div class="col-1">
                                                    <button @click="confirmDelete(category.id)" class="btn btn-danger btn-sm">Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</template>


<script>
import Dasboard from '../../Layout/Dasboard.vue';

export default {
  layout: (h, page) => h(Dasboard, [page]),

  layout: Dasboard,
}
</script>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const props = defineProps(['categories']);

function editLoket(id) {
    router.get(`/category/${id}/edit`);
}

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus loket ini?')) {
        deleteLoket(id);
    }
}

function deleteLoket(id) {
    router.delete(`/category/${id}`, {
        onSuccess: () => {
            router.visit('/category');
        },
        onError: (error) => {
            console.error('Delete failed:', error);
        }
    });
}
</script>