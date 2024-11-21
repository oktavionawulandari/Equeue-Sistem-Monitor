<template>
    <AppMeta title="Setting" />

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Setting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <Link :href="route('dashboard')">Dashboard</Link>
                        </li>
                        <li class="breadcrumb-item active">Setting</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="submit">
                                <!-- Input untuk Instansi -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="instansi"
                                                >Nama Instansi</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.instansi"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.instansi,
                                                }"
                                                id="instansi"
                                                name="instansi"
                                            />
                                            <div
                                                v-if="form.errors.instansi"
                                                class="invalid-feedback"
                                            >
                                                {{ form.errors.instansi }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Input untuk Alamat -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address"
                                                >Alamat Instansi</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.address"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.address,
                                                }"
                                                id="address"
                                                name="address"
                                            />
                                            <div
                                                v-if="form.errors.address"
                                                class="invalid-feedback"
                                            >
                                                {{ form.errors.address }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Input untuk Telepon dan Email -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone">Telepon</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.phone"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.phone,
                                                }"
                                                id="phone"
                                                name="phone"
                                            />
                                            <div
                                                v-if="form.errors.phone"
                                                class="invalid-feedback"
                                            >
                                                {{ form.errors.phone }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input
                                                type="email"
                                                class="form-control"
                                                v-model="form.email"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.email,
                                                }"
                                                id="email"
                                                name="email"
                                            />
                                            <div
                                                v-if="form.errors.email"
                                                class="invalid-feedback"
                                            >
                                                {{ form.errors.email }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="status"
                                                >Setting Audio</label
                                            >
                                            <select
                                                class="form-control"
                                                v-model="form.status"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.status,
                                                }"
                                                id="status"
                                                name="status"
                                            >
                                                <option value="" disabled>
                                                    Pilih Pengaturan
                                                </option>
                                                <option value="online">
                                                    Online
                                                </option>
                                                <option value="offline">
                                                    Offline
                                                </option>
                                            </select>
                                            <div
                                                v-if="form.errors.status"
                                                class="invalid-feedback"
                                            >
                                                {{ form.errors.status }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Input untuk Running Text -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="set_phone"
                                                >Setting No Hp</label
                                            >
                                            <select
                                                class="form-control"
                                                v-model="form.set_phone"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.set_phone,
                                                }"
                                                id="set_phone"
                                                name="set_phone"
                                            >
                                                <option value="" disabled>
                                                    Pilih Pengaturan
                                                </option>
                                                <option value="0">Aktif</option>
                                                <option value="1">
                                                    Tidak Aktif
                                                </option>
                                            </select>
                                            <div
                                                v-if="form.errors.set_phone"
                                                class="invalid-feedback"
                                            >
                                                {{ form.errors.set_phone }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="running_text"
                                                >Running Text</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.running_text"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors
                                                            .running_text,
                                                }"
                                                id="running_text"
                                                name="running_text"
                                            />
                                            <div
                                                v-if="form.errors.running_text"
                                                class="invalid-feedback"
                                            >
                                                {{ form.errors.running_text }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Input untuk Video Upload -->
                                <div class="row">
                                    <!-- <div class="form-group col-4">
                                        <label for="video">Video</label>
                                        <input
                                            type="file"
                                            class="form-control"
                                            accept="video/*"
                                            @change="previewVideo"
                                            :class="{
                                                'is-invalid': form.errors.video,
                                            }"
                                            id="video"
                                            name="video"
                                        />
                                        <div
                                            v-if="form.errors.video"
                                            class="invalid-feedback"
                                        >
                                            {{ form.errors.video }}
                                        </div>
                                        <video
                                            v-if="videoPreview"
                                            width="320"
                                            height="240"
                                            class="mt-3"
                                            controls
                                            :src="videoPreview"
                                            ref="videoElement"
                                            @loadedmetadata="setInitialVolume"
                                        ></video>
                                        <input
                                            type="range"
                                            class="form-range mt-2"
                                            min="0"
                                            max="1"
                                            step="0.1"
                                            v-model="form.volume"
                                            id="volume"
                                            name="volume"
                                            :class="{
                                                'is-invalid':
                                                    form.errors.volume,
                                            }"
                                            @input="updateVolume"
                                        />
                                        <span
                                            v-if="form.errors.volume"
                                            class="text-danger"
                                            >{{ form.errors.volume }}</span
                                        >
                                    </div> -->

                                    <div class="form-group col-6">
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

                                    <div class="form-group col-6">
                                        <label for="images"
                                            >List Gambar Monitor</label
                                        >
                                        <input
                                            type="file"
                                            class="form-control"
                                            accept="image/*"
                                            multiple
                                            @change="previewImages"
                                            :class="{
                                                'is-invalid':
                                                    form.errors.images,
                                            }"
                                            id="images"
                                            name="images[]"
                                        />
                                        <div
                                            v-if="form.errors.images"
                                            class="invalid-feedback"
                                        >
                                            {{ form.errors.images }}
                                        </div>
                                        <div
                                            v-if="imagesPreview.length > 0"
                                            class="mt-3"
                                        >
                                            <div
                                                v-for="(
                                                    image, index
                                                ) in imagesPreview"
                                                :key="index"
                                            >
                                                <img
                                                    :src="image"
                                                    alt="Preview Image"
                                                    class="img-fluid"
                                                    width="100"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 col-md-2">
                                        <div class="form-group">
                                            <label for="navigasi"
                                                >Navigasi</label
                                            >
                                            <input
                                                type="color"
                                                class="form-control"
                                                v-model="form.navigasi"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.navigasi,
                                                }"
                                                id="navigasi"
                                                name="navigasi"
                                            />
                                            <div
                                                v-if="form.errors.navigasi"
                                                class="invalid-feedback"
                                            >
                                                {{ form.errors.navigasi }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="form-group">
                                            <label for="footer">Footer</label>
                                            <input
                                                type="color"
                                                class="form-control"
                                                v-model="form.footer"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.footer,
                                                }"
                                                id="footer"
                                                name="footer"
                                            />
                                            <div
                                                v-if="form.errors.footer"
                                                class="invalid-feedback"
                                            >
                                                {{ form.errors.footer }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="form-group">
                                            <label for="background"
                                                >Background</label
                                            >
                                            <input
                                                type="color"
                                                class="form-control"
                                                v-model="form.background"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.background,
                                                }"
                                                id="background"
                                                name="background"
                                            />
                                            <div
                                                v-if="form.errors.background"
                                                class="invalid-feedback"
                                            >
                                                {{ form.errors.background }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <div class="form-group">
                                            <label for="text">Text</label>
                                            <input
                                                type="color"
                                                class="form-control"
                                                v-model="form.text"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.text,
                                                }"
                                                id="text"
                                                name="text"
                                            />
                                            <div
                                                v-if="form.errors.text"
                                                class="invalid-feedback"
                                            >
                                                {{ form.errors.text }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row mt-5">
                                    <div class="col-auto">
                                        <button
                                            class="btn btn-primary"
                                            type="submit"
                                        >
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Logo Upload -->
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm, router, usePage } from "@inertiajs/vue3";
import { toRefs, watch, ref } from "vue";
import AppMeta from "@/Components/AppMeta.vue";
import { toast } from "vue3-toastify";

const props = defineProps({
    setting: Object,
});

// const { props } = usePage();

const { setting } = toRefs(props);
// const setting = ref({
//     ...props.setting,
// });

const logoPreview = ref(
    setting.value?.logo ? `/storage/logo/${setting.value.logo}` : null
);
const videoPreview = ref(
    setting.value?.video ? `/storage/videos/${setting.value.video}` : null
);

const form = useForm({
    instansi: setting.value?.instansi || "",
    logo: null,
    address: setting.value?.address || "",
    phone: setting.value?.phone || "",
    email: setting.value?.email || "",
    running_text: setting.value?.running_text || "",
    // video: null,
    navigasi: setting.value?.navigasi || "",
    footer: setting.value?.footer || "",
    background: setting.value?.background || "",
    text: setting.value?.text || "",
    // volume: setting.value?.volume ?? 0.5,
    status: setting.value?.status || "",
    set_phone: setting.value?.set_phone || "",
    images: [],
});

const showErrorAlert = ref(false);

watch(form.errors, (val) => {
    if (Object.keys(val).length > 0) {
        showErrorAlert.value = true;
    }
});

const submit = () => {
    const formData = new FormData();

    for (const key in form) {
        formData.append(key, form[key] instanceof File ? form[key] : form[key]);
    }
    form.post("/setting", {
        data: formData,
        onSuccess: () => {
            toast.success("Data Setting Berhasil Diperbarui!");
            router.get("/setting");
        },
    });
};

const previewImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            logoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
        form.logo = file;
    }
};

const imagesPreview = ref([]);

const previewImages = (e) => {
    const files = e.target.files;
    const previewUrls = [];
    form.images = []; // Clear any previous images

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = () => {
            previewUrls.push(reader.result);
            imagesPreview.value = previewUrls;
        };
        reader.readAsDataURL(file);
        form.images.push(file); // Store the actual file for submission
    }
};

const previewVideo = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            videoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
        form.video = file;
    }
};

const videoElement = ref(null);

watch(
    () => form.volume,
    (newVolume) => {
        if (videoElement.value) {
            videoElement.value.volume = newVolume;
        }
    }
);

const setInitialVolume = () => {
    if (videoElement.value) {
        videoElement.value.volume = form.volume;
    }
};

const updateVolume = () => {
    if (videoElement.value) {
        videoElement.value.volume = volume.value;
    }
};
</script>

<script>
import Dashboard from "../../Layout/Dasboard.vue";

export default {
    layout: Dashboard,
};
</script>

<style></style>
