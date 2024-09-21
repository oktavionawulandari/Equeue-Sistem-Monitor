<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Loket</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
                        <li class="breadcrumb-item active">Daftar Loket</li>
                    </ol>
                </div>
            </div>

            <!-- Pesan Berhasil -->
            <!-- <div v-if="flash.success" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ flash.success }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> -->

            <!-- Pesan Error -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-striped table-bordered table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomer Antrian</th>
                                        <th>Panggilan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(queue, index) in props.queues" :key="queue.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ queue.no }}</td>
                                        <td> </td>
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

<script>
import Home from '../../Layout/Home.vue';

export default {
  layout: (h, page) => h(Home, [page]),

  layout: Home,
}
</script>

<script setup>

const props = defineProps(['queues']);

</script>