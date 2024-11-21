<template>
    <AppMeta title="Tambah Instansi" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Tambah Instansi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link :href="route('dashboard')">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item active">Tambah Instansi</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="submitForm">
                                <div class="form-group">
                                    <label>Nama Instansi</label>
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
                                    <label for="active">Status</label>
                                    <select
                                        class="form-control"
                                        v-model="form.active"
                                        :class="{
                                            'is-invalid': form.errors.active,
                                        }"
                                        id="active"
                                        name="active"
                                    >
                                        <option value="" disabled>
                                            Pilih Status
                                        </option>
                                        <option value="0">Tidak Aktif</option>
                                        <option value="1">Aktif</option>
                                    </select>
                                    <div
                                        v-if="form.errors.active"
                                        class="invalid-feedback"
                                    >
                                        {{ form.errors.active }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <!-- Logo Upload -->
                                    <input
                                        type="file"
                                        class="form-control"
                                        accept="image/*"
                                        @change="previewImage"
                                        :class="{
                                            'is-invalid': form.errors.logo,
                                        }"
                                        id="logo"
                                        name="logo"
                                    />
                                    <div
                                        v-if="form.errors.logo"
                                        class="invalid-feedback"
                                    >
                                        {{ form.errors.logo }}
                                    </div>
                                    <img
                                        v-if="logoPreview"
                                        :src="logoPreview"
                                        alt="Logo"
                                        class="img-fluid mt-3"
                                        width="200"
                                    />
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
                                            href="/instansi"
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
    layout: Dasboard,
};
</script>

<script setup>
import { Link, router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
const props = defineProps(["setting"]);

const form = useForm({
    name: "",
    logo: "",
    active: "",
});

const errors = ref({});
const logoPreview = ref(null);

function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            logoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
        form.logo = file;
    }
}
function submitForm() {
    form.post("/instansi", {
        onSuccess: () => {
            toast.success("Data Instansi Berhasil Ditambahkan!");
            router.visit("/instansi");
        },
        onError: (formErrors) => {
            errors.value = formErrors;
        },
    });
}
</script>
