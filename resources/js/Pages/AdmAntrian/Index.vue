<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0 text-uppercase">Daftar Loket</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><Link href="/dashboard">Dashboard</Link></li>
                        <li class="breadcrumb-item active">Daftar Loket</li>
                    </ol>
                </div>
            </div>

            <!-- Filter Loket dan Tanggal -->
            <div class="row mb-3">
                <div class="col-6">
                    <input v-model="search" @input="filterLoket" type="text" class="form-control" placeholder="Cari Nama Loket...">
                </div>
                <div class="col-6">
                    <input v-model="date" @change="filterLoket" type="date" class="form-control" placeholder="Pilih Tanggal">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-striped table-bordered table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomer Loket</th>
                                        <th>Nama Loket</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(q, index) in filteredQueue" :key="q.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ q.no }}</td>
                                        <td>{{ q.category ? q.category.name : 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const props = defineProps(['queue']);
const search = ref('');
const date = ref('');

onMounted(() => {
    const today = new Date().toISOString().split('T')[0];
    date.value = today;
});

const filteredQueue = computed(() => {
    return props.queue.filter(q => {
        const nameMatch = q.category && q.category.name.toLowerCase().includes(search.value.toLowerCase());
        const dateMatch = !date.value || new Date(q.created_at).toDateString() === new Date(date.value).toDateString();
        return nameMatch && dateMatch;
    });
});

</script>

<script>
import Dasboard from '../../Layout/Dasboard.vue';

export default {
  layout: (h, page) => h(Dasboard, [page]),

  layout: Dasboard,
}
</script>
