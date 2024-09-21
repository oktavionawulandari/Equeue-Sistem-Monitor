<template>
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
              <h3>{{ loket.name }}</h3>
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
  <div v-if="showModal" class="modal fade show" tabindex="-1" role="dialog" style="display: block;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Select Counter</h5>
          <button type="button" class="close" @click="closeModal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <select id="counterSelect" v-model="selectedCounterId" class="form-control">
              <option v-for="counter in selectedCounter.counters" :key="counter.id" :value="counter.id">
                {{ counter.name }}
              </option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
          <button type="button" class="btn btn-primary" @click="tampilkan">Tampilkan</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal -->
</template>
<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps(['lokets']);
const showModal = ref(false);
const selectedCounterId = ref(null);
const selectedCounter = ref(null);
const selectedLoketId = ref(null); // Menyimpan ID loket yang dipilih

const getBgClass = (loket) => {
  const colorClasses = ['bg-info', 'bg-warning', 'bg-success', 'bg-danger'];
  return colorClasses[loket.id % colorClasses.length];
};

const openModal = (loket) => {
  selectedCounter.value = loket; 
  selectedCounterId.value = null; 
  selectedLoketId.value = loket.id;
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedCounterId.value = null;
};

const tampilkan = () => {
  if (selectedCounterId.value) {
    localStorage.setItem("_loket", selectedCounterId.value); 
    router.visit(`/antrian-loket?loketId=${selectedLoketId.value}`);
    closeModal(); 
  } else {
    alert('Silahkan pilih jenis loket antrian');
  }
};
</script>

<script>
import Home from '../Layout/Home.vue';

export default {
  layout: Home,
}
</script>