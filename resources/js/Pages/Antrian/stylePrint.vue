<template>
    <html>
        <head>
          <title>Print Queue Number</title>
        </head>
        <body>
          <div class="container">
              <div class="header d-flex align-items-center">
                  <img :src="`/storage/logo/${setting?.logo}`" alt="Logo">
                  <div class="header-text ms-3">
                      <h2>{{ setting?.instansi }}</h2>
                      <p>{{ setting?.address }}</p>
                  </div>
              </div>
              <div class="datetime">
                  <div class="date">{{ currentDate }}</div>
                  <div class="time">{{ currentTime }}</div>
              </div>
              <p>============================</p>
              <div class="antrian">NO ANTRIAN</div>
              <div class="queue-number">{{ latestQueue.no }} </div>
              <div class="counter">{{ category.name }}</div>
          </div>
        </body>
      </html>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const settings = defineProps(['setting']);

const { props } = usePage();
const category = ref(props.category);
const latestQueue = ref(props.latestQueue);

const companyName = ref('NAMA COMPANY');
const currentTime = ref('');
const currentDate = ref('');

const updateCurrentDateTime = () => {
  const now = new Date();
  const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
  currentDate.value = now.toLocaleDateString('id-ID', dateOptions);
  currentTime.value = now.toLocaleTimeString('id-ID', timeOptions);
};

onMounted(() => {
  updateCurrentDateTime();
  window.print();
});
</script>



<style scoped>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}
.container {
    width: 300px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    text-align: center;
}
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
}

.header img {
    width: 50px;
    height: auto;
    margin-right: 10px;
}

.header-text {
    flex-grow: 1;
    text-align: left;
}

.header h2 {
    font-size: 1.2em;
    font-weight: bold;
}

.header p {
    font-size: 0.6em;
}
.datetime {
      display: flex;
      justify-content: space-between;
      align-items: center;
  }
  .date {
      flex: 1;
      font-size: 0.6em;
      text-align: left;
  }
  .time {
      flex: 1;
      font-size: 0.6em;
      text-align: right;
  }

.queue-number {
    font-size: 4em;
    font-weight: bold;
    margin-bottom: 10px;
}

.counter {
    font-size: 1em;
    margin-bottom: 10px;
}

.antrian {
    font-size: 0.8em;
    font-weight: bold;
    margin-bottom: 5px;
}
</style>




<template>
    <div class="container">
        <div class="header">RSUD BATIN MANGUNANG</div>
        <div class="address">
            Jl. Soekarno Hatta, Komplek Islamic Centre<br>
            Kota Agung, Tanggamus
        </div>
        <div class="separator"></div>
        <div class="queue-number">A123</div>
        <div class="instructions">
            Silahkan menunggu nomor antrian dipanggil<br>
            Nomor ini hanya berlaku pada hari ini (Minggu 21 Oktober 2024)
        </div>
        <div class="thanks">TERIMA KASIH, ANDA TELAH TERTIB</div>
    </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const settings = defineProps(['setting']);

const { props } = usePage();
const category = ref(props.category);
const latestQueue = ref(props.latestQueue);

const companyName = ref('NAMA COMPANY');
const currentTime = ref('');
const currentDate = ref('');

const updateCurrentDateTime = () => {
  const now = new Date();
  const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
  currentDate.value = now.toLocaleDateString('id-ID', dateOptions);
  currentTime.value = now.toLocaleTimeString('id-ID', timeOptions);
};

onMounted(() => {
  updateCurrentDateTime();
  window.print();
});
</script>


<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
    }
    .container {
        width: 300px;
        margin: 20px auto;
        text-align: center;
    }
    .header {
        font-weight: bold;
        font-size: 20px;
    }
    .address {
        font-size: 14px;
    }
    .separator {
        border-top: 1px dashed #000;
        margin: 10px 0;
    }
    .queue-number {
        font-size: 50px;
        font-weight: bold;
        margin: 20px 0;
    }
    .instructions {
        font-size: 14px;
        margin-bottom: 10px;
    }
    .thanks {
        font-size: 16px;
        margin-top: 20px;
    }
</style>
