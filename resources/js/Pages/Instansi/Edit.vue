<template>
    <AppMeta title="Edit Instansi" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Edit Instansi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link :href="route('dashboard')">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item active">Edit Instansi</li>
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
                                        :class="{ 'is-invalid': errors.active }"
                                        id="active"
                                        name="active"
                                    >
                                        <option value="" disabled>
                                            Pilih Status
                                        </option>
                                        <option value="0">
                                            Tidak Aktif
                                        </option>
                                        <option value="1">
                                            Aktif
                                        </option>
                                    </select>
                                    <div
                                        v-if="errors.active"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.active }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input
                                        type="file"
                                        class="form-control"
                                        accept="image/*"
                                        @change="previewImage"
                                        :class="{ 'is-invalid': errors.logo }"
                                        id="logo"
                                        name="logo"
                                    />
                                    <div
                                        v-if="errors.logo"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.logo }}
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
import { Link, useForm, usePage, router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

const props = usePage().props
console.log(props)

const form = useForm({
    name: "",
    logo: "",
    active: "",
    _method: "PUT"
});

const errors = ref({});
const logoPreview = ref(null);

onMounted(() => {
    form.name = props.instansi.name;
    form.active = props.instansi.active;
    logoPreview.value = props.instansi.logo
        ? `/storage/instansi/${props.instansi.logo}`
        : null;
});


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
    form.post(`/instansi/${props.instansi.id}`, {
        onSuccess: () => {
            toast.success("Data Instansi Berhasil Diperbarui!");
            router.replace("/instansi");
        },
        onError: (formErrors) => {
            errors.value = formErrors;
        },
    });
}
</script>
