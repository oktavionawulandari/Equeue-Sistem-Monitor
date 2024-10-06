<template>
  <div class="d-flex flex-column min-vh-100"  :style="{ backgroundColor: setting.background }">
    <Header  :setting="setting"/>
    <div class="container-fluid">
      <main class="flex-grow-1">
        <form @submit.prevent="submitForm">
        <div class="row gx-3 me-5 ms-5 mb-5">
          <div class="col-lg-4 mb-4" v-for="cat in categories" :key="cat.id">
            <div class="px-4 py-3 mb-4 bg-white rounded-2 shadow-sm">
              <h1 class="h5 pt-2 text-uppercase">antrian {{ cat.name }}</h1>
            </div>

            <div class="card border-0 shadow-sm mb-3">
              <div class="card-body text-center d-grid p-5">
                <div class="border border-success rounded-2 py-2 mb-5">
                  <h3 class="pt-4">ANTRIAN</h3>
                  <h1 id="antrian" class="display-1 fw-bold text-success text-center lh-1 pb-2">
                    {{ getLatestQueueNumber(cat) }}
                  </h1>
                </div>
                <button type="submit" class="btn btn-success btn-block rounded-pill fs-5 px-5 py-4 mb-2" @click="() => {
                  form.category_id = cat.id;
                  form.status = 1;
                  // queueNumber = cat.queue[cat.queue.length - 1]?.no;
                  // categoryName = cat.name;
                }">
                  <i class="fa fa-user-plus fs-4 me-4"></i> Ambil Nomor
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>

      </main>
    </div>
    <Footer  :setting="setting"/>
  </div>
</template>

<script setup>
import { onMounted, ref, onBeforeUnmount } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import Header from '../../Layout/Monitor/Header.vue';
import Footer from '../../Layout/Monitor/Footer.vue';
import '../../../css/dashboard.css';
const { props: pageProps } = usePage();
const categories = ref(pageProps.categories || []);
const currentTime = ref('');
const currentDate = ref('');
const settings = defineProps(['setting']);

const form = useForm({
  status: '',
  category_id: '',
  date: new Date().toISOString()
});

const getLatestQueueNumber = (category) => {
  const latestQueue = category?.queue[category.queue.length - 1];
  if (latestQueue) {
    const queueDate = new Date(latestQueue.date);
    const today = new Date();

    if (queueDate.toDateString() === today.toDateString()) {
      return latestQueue.no;
    }
  }
  return 'Antrian';
};

const submitForm = () => {
  form.post('/antrian', {
    onSuccess: (page) => {
      router.get('/antrian');
      const categoryId = form.category_id;
      window.open(`/antrian/${categoryId}`, '_blank');
    },
    onError: (error) => {
      console.error('nomor antrian error: ', error);
    }
  });
};

const updateCurrentDateTime = () => {
  const now = new Date();
  const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
  currentDate.value = now.toLocaleDateString('id-ID', dateOptions);
  currentTime.value = now.toLocaleTimeString('id-ID', timeOptions);
};

onMounted(() => {
  updateCurrentDateTime();
  const timeInterval = setInterval(updateCurrentDateTime, 1000);

  onBeforeUnmount(() => {
    clearInterval(timeInterval);
  });
});
</script>



<style scoped>
/* Add any custom styling here */
</style>
