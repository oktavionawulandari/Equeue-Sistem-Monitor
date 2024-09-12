<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Loket</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Daftar Loket</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary" @click="addLoket" data-toggle="tooltip" title="Tambah Data">
                                <i class="fas fa-plus pr-2"></i>Tambah
                            </button>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-bordered table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Reason</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="loket in lokets" :key="loket.id">
                                        <td>{{ loket.id }}</td>
                                        <td>{{ loket.user }}</td>
                                        <td>{{ loket.date }}</td>
                                        <td>{{ loket.status }}</td>
                                        <td>{{ loket.reason }}</td>
                                        <td>
                                            <button @click="editLoket(loket.id)" class="btn btn-warning btn-sm">Edit</button>
                                            <button @click="deleteLoket(loket.id)" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
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
export default {
    data() {
        return {
            lokets: [] // Replace with actual data fetching logic
        };
    },
    methods: {
        async fetchLokets() {
            try {
                // Replace with your actual API endpoint
                const response = await fetch('/api/lokets');
                this.lokets = await response.json();
            } catch (error) {
                console.error('Error fetching lokets:', error);
            }
        },
        addLoket() {
            // Implement functionality to handle "Tambah Data" button click
            console.log('Add Loket clicked');
            // Example: this.$router.push('/loket/add');
        },
        async editLoket(id) {
            // Implement functionality to handle editing a loket
            console.log('Edit Loket clicked for ID:', id);
            // Example: this.$router.push(`/loket/edit/${id}`);
        },
        async deleteLoket(id) {
            try {
                // Replace with your actual API endpoint
                await fetch(`/api/lokets/${id}`, { method: 'DELETE' });
                // Refresh the list after deletion
                this.fetchLokets();
            } catch (error) {
                console.error('Error deleting loket:', error);
            }
        }
    },
    mounted() {
        this.fetchLokets();
    }
};
</script>

<style scoped>
/* Add component-specific styles here */
</style>