<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Tambah Antrian</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><Link href="/dashboard">Dashboard</Link></li>
                        <li class="breadcrumb-item active">Tambah Antrian</li>
                    </ol>
                </div>
            </div>

            <div v-if="Object.keys(errors).length > 0" class="alert alert-danger alert-dismissible show fade" role="alert">
                <strong>Error!</strong> 
                    <li v-if="errors.name">{{ errors.name }}</li>
                    <li v-if="errors.nama_loket">{{ errors.catatan }}</li>
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="submitForm">
                                <div class="form-group">
                                    <label>Nama Layanan</label>
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
                                    <label>Catatan</label>
                                    <textarea
                                        class="form-control"
                                        v-model="form.catatan"
                                        :class="{'is-invalid': errors.catatan}"
                                        id="catatan"
                                        name="catatan"
                                    ></textarea>
                                    <div v-if="errors.catatan" class="invalid-feedback">
                                        {{ errors.catatan }}
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-auto">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                    <div class="col-auto">
                                        <Link href="/category" class="btn btn-dark">Kembali</Link>
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
    catatan: '',
});

const errors = ref({});

function submitForm() {
    form.post('/category', {
        onSuccess: () => {
            router.visit('/category');
        },
        onError: (formErrors) => {
            errors.value = formErrors; 
        }
    });
}
</script>