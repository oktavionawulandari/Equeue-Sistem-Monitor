<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Loket</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active">Edit Loket</li>
                    </ol>
                </div>
            </div>

            <div v-if="Object.keys(errors).length > 0" class="alert alert-danger alert-dismissible show fade" role="alert">
                <strong>Error!</strong> 
                    <li v-if="errors.no_loket">{{ errors.no_loket }}</li>
                    <li v-if="errors.nama_loket">{{ errors.nama_loket }}</li>
                <button class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="submitForm">
                                <div class="form-group">
                                    <label>No Loket</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.no_loket"
                                        :class="{'is-invalid': errors.no_loket}"
                                        id="no_loket"
                                        name="no_loket"
                                    >
                                    <div v-if="errors.no_loket" class="invalid-feedback">
                                        {{ errors.no_loket }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Loket</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.nama_loket"
                                        :class="{'is-invalid': errors.nama_loket}"
                                        id="nama_loket"
                                        name="nama_loket"
                                    >
                                    <div v-if="errors.nama_loket" class="invalid-feedback">
                                        {{ errors.nama_loket }}
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-auto">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                    <div class="col-auto">
                                        <Link href="/loket" class="btn btn-dark">Kembali</Link>
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

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps(['id', 'loket']); 

const form = ref({
    no_loket: '',
    nama_loket: '',
});

const errors = ref({});

onMounted(() => {
    form.value.no_loket = props.loket.no_loket;
    form.value.nama_loket = props.loket.nama_loket;
});

function submitForm() {
    router.put(`/loket/${props.id}`, form.value, {
        onSuccess: () => {
            router.visit('/loket');
        },
        onError: (formErrors) => {
            errors.value = formErrors;
        }
    });
}
</script>