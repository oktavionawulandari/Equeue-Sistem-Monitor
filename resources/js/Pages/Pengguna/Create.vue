<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Tambah Pengguna</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active">Tambah Pengguna</li>
                    </ol>
                </div>
            </div>

            <div v-if="Object.keys(errors).length > 0" class="alert alert-danger alert-dismissible show fade" role="alert">
                <strong>Error!</strong> 
                    <li v-if="errors.name">{{ errors.name }}</li>
                    <li v-if="errors.username">{{ errors.username }}</li>
                    <li v-if="errors.role">{{ errors.role }}</li>
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="submitForm">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.name"
                                        :class="{'is-invalid': errors.name}"
                                        id="name"
                                        name="name"
                                    >
                                    <div v-if="errors.name" class="invalid-feedback">
                                        {{ errors.name }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.username"
                                        :class="{'is-invalid': errors.username}"
                                        id="username"
                                        name="username"
                                    >
                                    <div v-if="errors.username" class="invalid-feedback">
                                        {{ errors.username }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        v-model="form.password"
                                        :class="{'is-invalid': errors.name}"
                                        id="password"
                                        name="password"
                                    >
                                    <div v-if="errors.password" class="invalid-feedback">
                                        {{ errors.password }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.role"
                                        :class="{'is-invalid': errors.role}"
                                        id="role"
                                        name="role"
                                        readonly
                                    >
                                    <div v-if="errors.role" class="invalid-feedback">
                                        {{ errors.role }}
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-auto">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                    <div class="col-auto">
                                        <Link href="/pengguna" class="btn btn-dark">Kembali</Link>
                                    </div>
                                </div>
                            </form>
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
import { Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    username: '',
    role: 'operator',
    password: '',
});

const errors = ref({});

function submitForm() {
    form.post('/pengguna', {
        onSuccess: () => {
            router.visit('/pengguna');
        },
        onError: (formErrors) => {
            errors.value = formErrors; 
        }
    });
}
</script>