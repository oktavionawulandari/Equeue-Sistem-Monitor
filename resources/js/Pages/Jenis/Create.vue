<template>
    <AppMeta title="Tambah Kategori" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Tambah Kategori</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link :href="route('dashboard')">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item active">Tambah Kategori</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="submitForm">
                                <div class="form-group">
                                    <label>Nama Kategori</label>
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
                                    <label>Kode</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.kode"
                                        :class="{ 'is-invalid': errors.kode }"
                                        id="kode"
                                        name="kode"
                                    />
                                    <div
                                        v-if="errors.kode"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.kode }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea
                                        class="form-control"
                                        v-model="form.catatan"
                                        :class="{
                                            'is-invalid': errors.catatan,
                                        }"
                                        id="catatan"
                                        name="catatan"
                                    ></textarea>
                                    <div
                                        v-if="errors.catatan"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.catatan }}
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
                                        <Link
                                            href="/category"
                                            class="btn btn-dark"
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

<script>
import Dasboard from "../../Layout/Dasboard.vue";
import AppMeta from "@/Components/AppMeta.vue";
import { toast } from "vue3-toastify";

export default {
    layout: (h, page) => h(Dasboard, [page]),

    layout: Dasboard,
};
</script>

<script setup>
import { Link, router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
const props = defineProps(["setting"]);

const form = useForm({
    name: "",
    kode: "",
    catatan: "",
});

const errors = ref({});

function submitForm() {
    form.post("/category", {
        onSuccess: () => {
            toast.success("Data Kategori Berhasil Ditambahkan!");
            router.visit("/category");
        },
        onError: (formErrors) => {
            errors.value = formErrors;
        },
    });
}
</script>
