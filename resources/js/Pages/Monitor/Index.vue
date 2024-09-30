<template>
  <div class="container-fluid d-flex flex-column min-vh-100">
    <header class="d-flex flex-wrap justify-content-between py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <div class="bi me-2 ms-5" width="40" height="32">
          <img src="https://png.pngtree.com/png-clipart/20230207/original/pngtree-beauty-logo-design-png-image_8947095.png" alt="Company Logo" width="40" height="40">
        </div>
        <span class="fs-4 text-bold">MONITOR ANTRIAN PENDAFTARAN</span>
      </a>
      <div class="d-flex align-items-center text-dark ms-auto me-5">
        <i class="fa fa-calendar me-2"></i>
        <div class="fs-5 text-bold">{{ currentTime }}</div>
      </div>
    </header>
    <div class="text-marquee bg-info text-white py-2">
      <p>Selamat datang di monitor antrian pendaftaran. Silakan tunggu hingga nomor antrian Anda dipanggil.</p>
    </div>

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
                <h1 id="antrian-selanjutnya" class="text-center fw-bold my-3" style="font-size: 60px;" :key="currentCategory">
                  <!-- {{ currentCategory == category.id ?  (category?.antrian[category?.antrian?.length - 1]?.queue?.no || 'Antrian') : currentQueueNumber  }} -->
                  {{ (category?.antrian[category?.antrian?.length - 1]?.queue?.no || 'Antrian') }}
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
import { onMounted, ref, onBeforeUnmount, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import '../../../css/dashboard.css';
import { useForm } from '@inertiajs/inertia-vue3';

const props = defineProps(['categories', 'counterId']);

const currentQueueNumber = ref('-');
const currentCategory = ref(null)
const currentTime = ref('');

const getBgClass = (category) => {
  const colorClasses = ['bg-info', 'bg-warning', 'bg-success', 'bg-danger'];
  return colorClasses[category.id % colorClasses.length];
};

const updateCurrentTime = () => {
  const now = new Date();
  const hours = now.getHours().toString().padStart(2, '0');
  const minutes = now.getMinutes().toString().padStart(2, '0');
  const seconds = now.getSeconds().toString().padStart(2, '0');
  currentTime.value = `${hours}:${minutes}:${seconds}`;
};
onMounted(() => {
  
  const updateQueueNumber = () => {
    const storedQueueNumber = localStorage.getItem('currentQueueNumber');
    const storedCategory = localStorage.getItem('currentCategory');
    if (storedQueueNumber && storedQueueNumber !== currentQueueNumber.value) {
      currentQueueNumber.value = storedQueueNumber;
      currentCategory.value = storedCategory;
    }
  };

  updateQueueNumber();
    const interval = setInterval(updateQueueNumber, 1000);

  onBeforeUnmount(() => {
    clearInterval(interval);
  });


  updateCurrentTime();
    const timeInterval = setInterval(updateCurrentTime, 1000);

  onBeforeUnmount(() => {
    clearInterval(timeInterval);
  });
});

const callQueue = async (queue) => {
    if (window.responsiveVoice) {
        const message = `Nomor antrian ${queue.no_antrian}, silahkan menuju loket ${queue.counter}.`;
        responsiveVoice.speak(message, "Indonesian Female");

        const form = useForm([]);
         form.patch(`/monitor/trigger-notification/${queue.id}`, {
          onSuccess: () => {
          }
         });

        localStorage.setItem('currentQueueNumber', queue.no_antrian);
        localStorage.setItem('currentCategory', queue.loket_id);

        router.get("/monitor")
    } else {
        console.error("Response tidak berhasil");
    }
};

setInterval(() => {
  fetch("/monitor/trigger-notification").then(response => response.json()).then(res => {
    console.log(res?.data?.status);
    if(res?.data?.status) {
      callQueue(res.data)
    }
  })
}, 5000);
</script>

<style scoped>
.scroll-container {
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  height: 100%;
}

.text-marquee {
  white-space: nowrap;
  overflow: hidden;
  position: relative;
}

.text-marquee p {
  display: inline-block;
  padding-left: 100%;
  animation: marquee 40s linear infinite;
}

@keyframes marquee {
  0% {
    transform: translateX(100%);
  }
  100% {
    transform: translateX(-100%);
  }
}
</style>