<template>
    <AppMeta title="Edit Loket" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Edit Loket</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link href="/dashboard">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item">
                            <Link href="/loket">Loket</Link>
                        </li>
                        <li class="breadcrumb-item active">Edit Loket</li>
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
                                    <label for="instansi_id"
                                        >Jenis Instansi</label
                                    >
                                    <select
                                        class="form-control"
                                        v-model="form.instansi_id"
                                        :class="{
                                            'is-invalid': errors.instansi_id,
                                        }"
                                        id="instansi_id"
                                        name="instansi_id"
                                        @change="onInstansiChange"
                                    >
                                        <option value="">
                                            Pilih Jenis Instansi
                                        </option>
                                        <option
                                            v-for="instansi in instansi"
                                            :key="instansi.id"
                                            :value="instansi.id"
                                        >
                                            {{ instansi.name }}
                                        </option>
                                    </select>
                                    <div
                                        v-if="errors.instansi_id"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.instansi_id }}
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
                                            v-for="category in filteredCategories"
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
import { ref, onMounted } from "vue";
import { useForm, router, Link } from "@inertiajs/vue3";
import AppMeta from "@/Components/AppMeta.vue";
import { toast } from "vue3-toastify";

const props = defineProps(["loket", "categories", "instansi"]);

const form = useForm({
    no: "",
    name: "",
    category_id: "",
    instansi_id: "",
});

const errors = ref({});
const filteredCategories = ref(props.categories);

onMounted(() => {
    form.no = props.loket.no;
    form.name = props.loket.name;
    form.category_id = props.loket.category_id;
    form.instansi_id = props.loket.instansi_id;
    onInstansiChange();
});

const onInstansiChange = () => {
    filteredCategories.value = props.categories.filter(
        (category) => category.instansi_id === form.instansi_id
    );
};

function submitForm() {
    form.put(`/loket/${props.loket.id}`, {
        onSuccess: () => {
            toast.success("Data Loket Berhasil Diperbarui!");
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
