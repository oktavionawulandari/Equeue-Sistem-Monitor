html
Copy code
<template>
  <div>
    <!-- Content Header -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Home</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div v-for="loket in lokets" :key="loket.id" class="col-lg-3 col-6">
            <div :class="`small-box ${getBgClass(loket)}`">
              <div class="inner">
                <h3>{{ loket.category ? loket.category.name : 'N/A' }}</h3>
                <p>Panggilan Antrian</p> 
              </div>
              <div class="icon">
                <i class="ion ion-mic-a"></i>
              </div>
              <a href="#" @click.prevent="openModal(loket)" class="small-box-footer">Tampilkan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Modal -->
    <div v-if="isModalOpen" class="modal fade show d-block" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pilih Loket Antrian</h5>
            <button type="button" class="close" @click="closeModal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p></p>
            <!-- Add more details as needed -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Home from '../Layout/Home.vue';
import 'admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css';

const props = defineProps(['lokets']);

const selectedCategory = ref(null);
const isModalOpen = ref(false);

const getBgClass = (lokets) => {
  const colorClasses = ['bg-info', 'bg-warning', 'bg-success', 'bg-danger'];
  return colorClasses[lokets.id % colorClasses.length];
};

const openModal = (lokets) => {
  selectedCategory.value = lokets;
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};
</script>

<script>
export default {
  layout: Home,
}
</script>