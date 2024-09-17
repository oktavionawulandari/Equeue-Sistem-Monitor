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

            <div v-if="Object.keys(errors).length" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>
                <ul>
                    <li v-if="errors.no">{{ errors.no }}</li>
                    <li v-if="errors.name">{{ errors.name }}</li>
                    <li v-if="errors.category_id">{{ errors.category_id }}</li>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="submitForm">
                                <div class="form-group">
                                    <label for="no">No Loket</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.no"
                                        :class="{'is-invalid': errors.no}"
                                        id="no"
                                        name="no"
                                    >
                                    <div v-if="errors.no" class="invalid-feedback">
                                        {{ errors.no }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama Loket</label>
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
                                    <label for="category_id">Jenis Antrian</label>
                                    <select
                                        class="form-control"
                                        v-model="form.category_id"
                                        :class="{'is-invalid': errors.category_id}"
                                        id="category_id"
                                        name="category_id"
                                    >
                                        <option value="">Pilih Category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">
                                            {{ category.name }}
                                        </option>
                                    </select>
                                    <div v-if="errors.category_id" class="invalid-feedback">
                                        {{ errors.category_id }}
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-auto">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
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
import { ref, watch } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    id: Number,
    loket: Object,
    categories: Array
});

const form = useForm({
    no: props.loket.no || '',
    name: props.loket.name || '',
    category_id: props.loket.category_id || '',
});

const errors = ref({});

watch(() => props.loket, (newLoket) => {
    form.no = newLoket.no;
    form.name = newLoket.name;
    form.category_id = newLoket.category_id;
}, { immediate: true });

function submitForm() {
    form.put(`/loket/${props.id}`, {
        onSuccess: () => {
            router.replace('/loket');
        },
        onError: (formErrors) => {
            errors.value = formErrors;
        }
    });
}
</script>

<script>
import Dasboard from '../../Layout/Dasboard.vue';

export default {
  layout: Dasboard,
}
</script>