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
        <div v-for="cat in category" :key="cat.id" class="col-lg-3 col-6">
          <div :class="`small-box ${getBgClass(cat)}`">
            <div class="inner">
              <h3>{{ cat.name }}</h3>
              <p>Panggilan Antrian</p>
            </div>
            <div class="icon">
              <i class="ion ion-mic-a"></i>
            </div>
            <a href="#" @click.prevent="openModal(cat.id, cat.counters)" class="small-box-footer">Tampilkan <i class="fas fa-arrow-circle-right"></i></a>
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
            <select v-model="selectedCounter" class="form-control" id="counterSelect">
              <option v-for="counter in counters" :key="counter.id" :value="counter.id">{{ counter.name }}</option>
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

const props = defineProps(['category']);

const showModal = ref(false);
const counters = ref([]);
const selectedCounter = ref(null);
const selectedCategoryId = ref(null); 

const openModal = (categoryId, countersData) => {
  selectedCategoryId.value = categoryId;
  counters.value = countersData;
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedCounter.value = null; 
  selectedCategoryId.value = null; 
};

const tampilkan = () => {
  if (selectedCounter.value) {
    router.visit(`/queue/${selectedCategoryId.value}/${selectedCounter.value}`);
  }
};

const getBgClass = (cat) => {
  const colorClasses = ['bg-info', 'bg-warning', 'bg-success', 'bg-danger'];
  return colorClasses[cat.id % colorClasses.length];
};
</script>


<script>
import Home from '../Layout/Home.vue';

export default {
  layout: Home,
}
</script>