<template>
  <div class="d-flex flex-column min-vh-100"  :style="{ backgroundColor: setting.background }">
    <Header  :setting="setting"/>

    <div class="text-white py-2 text-bold text-center" :style="{ backgroundColor: setting.accent }">
      <h3 class="text-uppercase" :style="{ color: setting.secondary }">Monitor Antrian Pendaftaran</h3>
    </div>

    <div class="d-flex justify-content-between mt-3 h-100">
      <div class="rounded d-flex justify-content-center" style="width:65%;">
        <video class="rounded" width="100%" height="450" autoplay controls :src="`/storage/videos/${setting.video}`"></video>
        <!-- <iframe class="rounded" width="100%" height="450" allow="autoplay" :src="`/storage/${setting.video}`"></iframe> -->
      </div>

      <div class="h-100 overflow-hidden" style="font-size:0.8em; width:35%;">
        <div class="d-flex flex-column h-100 scroll-container">
          <div class="d-flex flex-wrap">
            <div class="card text-center text-white" :class="getBgClass(category)" v-for="category in display" :key="category.id" style="margin:0.5rem; width:calc(50% - 1rem);">
              <h5 class="card-header fw-bold">{{ category.name }}</h5>
              <div class="card-body">
                <h1 id="antrian-selanjutnya" class="text-center fw-bold my-3" style="font-size: 60px;">
                  {{ (category?.antrian?.length > 0 ? category?.antrian[0]?.queue?.no : 'Antrian') }}
                </h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="text-marquee  text-white py-2 mt-5" :style="{ backgroundColor: setting.accent }">
          <p :style="{ color: setting.secondary }">{{ setting?.running_text }}</p>
        </div>

    <Footer :setting="setting" />
  </div>
</template>

<script setup>
import { onMounted, ref, computed } from 'vue';
import Header from '../../Layout/Monitor/Header.vue';
import Footer from '../../Layout/Monitor/Footer.vue';
import '../../../css/dashboard.css';

const props = defineProps(['categories', 'counterId', 'setting']);

const queue = ref([]);
const categories = ref([]);

const display = computed(() => {
  return categories.value;
});

const getBgClass = (category) => {
  const colorClasses = ['bg-info', 'bg-warning', 'bg-success', 'bg-danger'];
  return colorClasses[category.id % colorClasses.length];
};

const getDisplay = (idCat = null) => {
  fetch('/monitor/display').then(res => res.json()).then(data => {
    categories.value = data.data;
  });
};

onMounted(() => {
  getDisplay();
  setInterval(getNotification, 1000);
});

const getNotification = () => {
  fetch("/monitor/trigger-notification").then(response => response.json()).then(res => {
  });
};
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
