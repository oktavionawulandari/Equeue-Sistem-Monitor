<template>
  <div class="container-fluid d-flex flex-column min-vh-100">
    <header class="d-flex flex-wrap justify-content-between py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <div class="bi me-2 ms-5" width="40" height="32">
          <img src="https://png.pngtree.com/png-clipart/20230207/original/pngtree-beauty-logo-design-png-image_8947095.png" alt="Company Logo" width="40" height="40">
        </div>
        <span class="fs-4 fw-bold">NAMA COMPANY</span>
      </a>
      <div class="d-flex align-items-center text-dark ms-auto me-5">
          <i class="fa fa-calendar me-2"></i>
          <div class="fs-5 text-bold">{{ currentDate }}</div>
          <div class="fs-5 text-bold ms-3">{{ currentTime }}</div>
      </div>
    </header>

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
                  <h1 id="antrian" class="display-1 fw-bold text-success text-center lh-1 pb-2">{{ cat?.queue[cat?.queue?.length - 1]?.no || 'Antrian' }}</h1>
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
import { onMounted, ref, onBeforeUnmount } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import '../../../css/dashboard.css';

const { props } = usePage();
const categories = ref(props.categories || []);
const currentTime = ref('');
const currentDate = ref('');
const queueNumber = ref('');
const categoryName = ref('');

const form = useForm({
  status: '',
  category_id: '',
  date: new Date().toISOString()
});

const submitForm = () => {
  form.post('/antrian', {
    onSuccess: (page) => {
        router.get('/antrian');
        const categoryId = form.category_id;
        window.open(`/antrian/${categoryId}`, '_blank');
        // const latestCat = props.categories[props.categories.length - 1];
        // queueNumber.value = latestCat?.queue[latestCat?.queue?.length - 1].no;
        // categoryName.value = latestCat?.name;
        // printQueueNumber();
    },
    onError: (error) => {
      console.error('nomor antrian error: ', error);
    }
  });
};

// query untuk cetak pdf
// const printQueueNumber = () => {
//   document.getElementById('antrian').innerHTML = ` ${queueNumber}`;

//   setTimeout(() => {
//     const printWindow = window.open('', '_blank');
//     printWindow.document.write(`
//       <html>
//         <head>
//           <title>Print Queue Number</title>
//           <style>
//             body {
//                 font-family: Arial, sans-serif;
//                 margin: 0;
//                 padding: 0;
//                 background-color: #f4f4f4;
//             }
//             .container {
//                 width: 300px;
//                 margin: 50px auto;
//                 background-color: #fff;
//                 border: 1px solid #ccc;
//                 padding: 20px;
//                 text-align: center;
//             }
//             .header {
//                 display: flex; 
//                 align-items: center;
//                 justify-content: space-between;
//                 padding: 10px;
//             }

//             .header img {
//                 width: 50px;
//                 height: auto;
//                 margin-right: 10px; 
//             }

//             .header-text {
//                 flex-grow: 1;
//                 text-align: left;
//             }
//             .header h2 {
//                 margin: 5px 0;
//                 font-size: 1.2em;
//             }

//             .header p {
//                 margin: 0;
//                 font-size: 0.6em;
//             }
//             .datetime {
//                   display: flex; 
//                   justify-content: space-between; 
//                   align-items: center;
//               }
//               .date {
//                   flex: 1;
//                   font-size: 0.6em;
//                   text-align: left; 
//               }
//               .time {
//                   flex: 1;
//                   font-size: 0.6em;
//                   text-align: right; 
//               }

//             .queue-number {
//                 font-size: 4em;
//                 font-weight: bold;
//                 margin-bottom: 10px;
//             }

//             .counter {
//                 font-size: 1em;
//                 margin-bottom: 10px;
//             }
                
//             .antrian {
//                 font-size: 0.8em;
//                 font-weight: bold;
//                 margin-bottom: 5px;
//             }
//           </style>
//         </head>
//         <body>
//           <div class="container">
//               <div class="header d-flex align-items-center">
//                   <img src="rsjs.png" alt="Logo">
//                   <div class="header-text ms-3"> 
//                       <h2>BaliSolutionBiz</h2>
//                       <p>Jl. hdbahs No 8</p>
//                   </div>
//               </div>
//               <div class="datetime">
//                   <div class="date">${currentDate.value}</div>
//                   <div class="time">${currentTime.value}</div>
//               </div>
//               <hr><hr>
//               <div class="antrian">NO ANTRIAN</div>
//               <div class="queue-number">${queueNumber.value || 'N/A'}</div>
//               <div class="counter">${categoryName.value}</div>
//           </div>
//         </body>
//       </html>
//     `);
//     printWindow.document.close();
//     printWindow.print();
//   }, 1000);
// };

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
