<template>
  <div class="container-fluid d-flex flex-column min-vh-100">
    <header class="d-flex flex-wrap justify-content-between py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <div class="bi me-2 ms-5" width="40" height="32">
          <img src="https://png.pngtree.com/png-clipart/20230207/original/pngtree-beauty-logo-design-png-image_8947095.png" alt="Company Logo" width="40" height="40">
        </div>
        <span class="fs-4 fw-bold">MONITOR ANTRIAN PENDAFTARAN</span>
      </a>
      <Link href="/" class="btn btn-outline-secondary ms-2">
        <i class="fa fa-arrow-left"></i> Back
      </Link>
    </header>

    <div class="d-flex justify-content-between mt-3 vh-100">
      <div class="rounded d-flex justify-content-center" style="width:65%;">
        <iframe class="rounded" width="100%" height="450" allow="autoplay" src="https://www.youtube.com/embed/-?rel=0&modestbranding=1&autohide=1&mute=0&showinfo=0&controls=1&loop=1&autoplay=1&playlist=-"></iframe>
      </div>

      <div class="h-100 overflow-hidden" style="font-size:0.8em; width:35%;">
        <div class="d-flex flex-column h-100 scroll-container">
          <div class="d-flex flex-wrap">
            <div class="card text-center text-white" :class="getBgClass(category)" v-for="category in categories" :key="category.id" style="margin:0.5rem; width:calc(50% - 1rem);">
              <h5 class="card-header fw-bold">{{ category.name }}</h5>
              <div class="card-body">
                <h1 id="antrian-selanjutnya" class="text-center fw-bold my-3" style="font-size: 80px;">
                  {{ currentQueueNumber }}
                </h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer py-4 border-top mt-auto">
      <div class="container text-center">
        <p class="mb-0">
          <a href="https://balisolutionbiz.com/">© 2024 BaliSolutionBiz.</a> All rights reserved.
        </p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { onMounted, ref, onBeforeUnmount } from 'vue';
import { Link } from '@inertiajs/vue3';
import '../../../css/dashboard.css';

const props = defineProps(['categories', 'counterId']);

const currentQueueNumber = ref('-');

const getBgClass = (category) => {
  const colorClasses = ['bg-info', 'bg-warning', 'bg-success', 'bg-danger'];
  return colorClasses[category.id % colorClasses.length];
};

onMounted(() => {
  const updateQueueNumber = () => {
    const storedQueueNumber = localStorage.getItem('currentQueueNumber');
    if (storedQueueNumber && storedQueueNumber !== currentQueueNumber.value) {
      currentQueueNumber.value = storedQueueNumber;
    }
  };

  updateQueueNumber();
  const interval = setInterval(updateQueueNumber, 1000);

  onBeforeUnmount(() => {
    clearInterval(interval);
  });
});

setInterval(() => {
  fetch("")
}, 5000)
</script>

<style scoped>
.scroll-container {
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  height: 100%;
}
</style>
