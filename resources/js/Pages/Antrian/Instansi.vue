<template>
    <div
        class="full-background"
        :style="{ backgroundColor: props.setting?.background }"
    >
        <div
            class="header"
            style="padding: 10px"
            :style="{ backgroundColor: props.setting?.navigasi }"
        >
            <div class="d-flex flex-column align-items-center mb-4">
                <div class="d-flex justify-content-between w-100">
                    <div class="logo-container">
                        <img
                            :src="`/storage/${props.setting?.logo}`"
                            class="logo"
                        />
                    </div>

                    <div class="text-center">
                        <h2
                            class="header-title"
                            :style="{ color: props.setting?.text }"
                        >
                            SELAMAT DATANG DI
                        </h2>
                        <h2
                            class="header-title text-uppercase"
                            :style="{ color: props.setting?.text }"
                        >
                            {{ props.setting?.instansi ?? "" }}
                        </h2>
                    </div>

                    <div class="logo-container">
                        <img
                            :src="`/storage/${props.setting?.logo}`"
                            class="logo"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-5">
            <div class="row">
                <div
                    class="col-md-6 mb-1"
                    v-for="ins in instansi"
                    :key="ins.id"
                >
                    <Link :href="route('antrian', { instansi_id: ins.id })">
                        <div class="card logo-card p-4">
                            <div class="d-flex align-items-center">
                                <div class="logo-image">
                                    <img
                                        :src="`/storage/${ins.logo}`"
                                        width="100%" style="object-fit: contain;"  height="100px"  :style="{marginRight: '20px' }"
                                    />
                                </div>
                                <h5
                                    class="ms-3 text-danger"
                                    style="font-size: 26px; font-weight: bold"
                                >
                                    {{ ins.name }}
                                </h5>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import "../../../css/dashboard.css";
import { Link, usePage } from "@inertiajs/vue3";

const { props } = usePage();
const instansi = props.instansi || [];
</script>

<style scoped>
.full-background {
    min-height: 100vh;
}

.header-title {
    font-weight: bold;
    color: #264f91;
    margin-bottom: 20px;
}

.badge-layanan {
    font-size: 12px;
    font-weight: bold;
    color: #fff;
    background: linear-gradient(135deg, #34a853, #66bb6a);
    padding: 5px 10px;
    border-radius: 5px;
    position: absolute;
    top: 10px;
    left: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

.card {
    border: none;
    background: linear-gradient(135deg, #eaf9d3, #c3e6b4);
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
}

.logo-container {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: #c7ffca;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    margin-right: 15px;
}

.logo {
    width: 100px;
    height: auto;
    object-fit: contain;
}

.help-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: linear-gradient(135deg, #00a1e0, #0083ca);
    color: white;
    padding: 10px 15px;
    border-radius: 50px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: background 0.3s;
}
.help-button:hover {
    background: linear-gradient(135deg, #0083ca, #005f8d);
}
</style>
