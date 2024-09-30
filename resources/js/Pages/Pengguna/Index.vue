<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Daftar Pengguna</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active">Daftar Pengguna</li>
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
                            <Link href="/pengguna/create" class="btn btn-primary">
                                <i class="fas fa-plus pr-2"></i>Tambah
                            </Link>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-striped table-bordered table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(user, index) in props.users" :key="user.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.username }}</td>
                                        <td>{{ user.role }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-0">
                                                    <button @click="editLoket(user.id)" class="btn btn-warning btn-sm">Edit</button>
                                                </div>
                                                <div class="col-1">
                                                    <button @click="confirmDelete(user.id)" class="btn btn-danger btn-sm">Delete</button>
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

const props = defineProps(['users']);

function editLoket(id) {
    router.get(`/pengguna/${id}/edit`);
}

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus loket ini?')) {
        deleteLoket(id);
    }
}

function deleteLoket(id) {
    router.delete(`/pengguna/${id}`, {
        onSuccess: () => {
            router.visit('/pengguna');
        },
        onError: (error) => {
            console.error('Delete failed:', error);
        }
    });
}
</script>