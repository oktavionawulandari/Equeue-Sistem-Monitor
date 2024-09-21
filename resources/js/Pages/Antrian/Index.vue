<template>
  <div class="container-fluid d-flex flex-column min-vh-100">
    <header class="d-flex flex-wrap justify-content-between py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <div class="bi me-2 ms-5" width="40" height="32">
          <img src="https://png.pngtree.com/png-clipart/20230207/original/pngtree-beauty-logo-design-png-image_8947095.png" alt="Company Logo" width="40" height="40">
        </div>
        <span class="fs-4 fw-bold">NAMA COMPANY</span>
      </a>
      <Link href="/" class="btn btn-outline-secondary ms-2">
        <i class="fa fa-arrow-left"></i> Back
      </Link>
    </header>

    <main class="flex-grow-1">
      <form @submit.prevent="submitForm">
        <div class="row gx-3 me-5 ms-5 mb-5">
          <div class="col-lg-4 mb-4" v-for="cat in categories" :key="cat.id">
            <div class="px-4 py-3 mb-4 bg-white rounded-2 shadow-sm">
              <h1 class="h5 pt-2">ANTRIAN {{ cat.name }}</h1>
            </div>

            <div class="card border-0 shadow-sm mb-3">
              <div class="card-body text-center d-grid p-5">
                <div class="border border-success rounded-2 py-2 mb-5">
                  <h3 class="pt-4">ANTRIAN</h3>
                  <h1 id="antrian" class="display-1 fw-bold text-success text-center lh-1 pb-2">{{ cat?.queue[cat?.queue?.length - 1]?.no || 'Antrian' }}</h1>
                  <!-- <h3 class="pt-4 "></h3> -->
                </div>
                <button type="submit" class="btn btn-success btn-block rounded-pill fs-5 px-5 py-4 mb-2" @click="() => {
                  form.category_id = cat.id
                  form.status = 1
                }">
                  <i class="fa fa-user-plus fs-4 me-4"></i> Ambil Nomor
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </main>

    <!-- Footer -->
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
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import '../../../css/dashboard.css';

const { props } = usePage();
const categories = ref(props.categories || []);

console.log(categories)

const form = useForm({
  status: '',
  category_id: '',
  date: new Date().toISOString()
});

const submitForm = () => {
  form.post('/antrian', {
    onSuccess: () => {
        router.visit('/antrian');
    },
    onError: (error) => {
      console.error('nomor antrian error: ', error);
    }
  });
};
</script>

<style scoped>
/* Add any custom styling here */
</style>
