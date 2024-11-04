<template>
    <AppMeta title="Edit Kategori" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Edit Kategori</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link :href="route('dashboard')">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item active">Edit Kategori</li>
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
import { Link, router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

const props = defineProps(["id", "categories", "setting"]);

const form = ref({
    name: "",
    kode: "",
    catatan: "",
});

const errors = ref({});

onMounted(() => {
    form.value.name = props.categories.name;
    form.value.kode = props.categories.kode;
    form.value.catatan = props.categories.catatan;
});

function submitForm() {
    router.put(`/category/${props.id}`, form.value, {
        onSuccess: () => {
            toast.success("Data Kategori Berhasil Diperbarui!");
            router.visit("/category");
        },
        onError: (formErrors) => {
            errors.value = formErrors;
        },
    });
}
</script>
