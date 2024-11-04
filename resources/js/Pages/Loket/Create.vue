<template>
    <AppMeta title="Tambah Loket" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Tambah Loket</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link href="/dashboard">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item active">Tambah Loket</li>
                    </ol>
                </div>
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
                                        :class="{ 'is-invalid': errors.no }"
                                        id="no"
                                        name="no"
                                    />
                                    <div
                                        v-if="errors.no"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.no }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama Loket</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.name"
                                        :class="{ 'is-invalid': errors.name }"
                                        id="name"
                                        name="name"
                                    />
                                    <div
                                        v-if="errors.name"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.name }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category_id"
                                        >Jenis Antrian</label
                                    >
                                    <select
                                        class="form-control"
                                        v-model="form.category_id"
                                        :class="{
                                            'is-invalid': errors.category_id,
                                        }"
                                        id="category_id"
                                        name="category_id"
                                    >
                                        <option value="">Pilih Category</option>
                                        <option
                                            v-for="category in categories"
                                            :key="category.id"
                                            :value="category.id"
                                        >
                                            {{ category.name }}
                                        </option>
                                    </select>
                                    <div
                                        v-if="errors.category_id"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.category_id }}
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-auto">
                                        <button
                                            class="btn btn-primary"
                                            type="submit"
                                        >
                                            Simpan
                                        </button>
                                    </div>
                                    <div class="col-auto">
                                        <Link href="/loket" class="btn btn-dark"
                                            >Kembali</Link
                                        >
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
import { ref, defineProps } from "vue";
import { useForm, Link, router } from "@inertiajs/vue3";
import AppMeta from "@/Components/AppMeta.vue";
import { toast } from "vue3-toastify";

const props = defineProps(["categories"]);

const form = useForm({
    no: "",
    name: "",
    category_id: "",
});

const errors = ref({});

function submitForm() {
    form.post("/loket", {
        onSuccess: () => {
            toast.success("Data Loket Berhasil Ditambahkan!");
            router.visit("/loket");
        },
        onError: (formErrors) => {
            errors.value = formErrors;
        },
    });
}
</script>

<script>
import Dasboard from "../../Layout/Dasboard.vue";

export default {
    layout: Dasboard,
};
</script>
