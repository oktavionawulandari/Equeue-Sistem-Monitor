<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Loket {{ counter_id }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <router-link to="/dashboard">Home</router-link>
            </li>
            <li class="breadcrumb-item active">Daftar Loket</li>
          </ol>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body table-responsive">
              <table class="table table-striped table-bordered table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nomor Antrian</th>
                    <th>Panggilan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(queue, index) in queues" :key="queue.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ queue.no }}</td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-success call-button"
                        @click="callQueue(queue)"
                        aria-label="Panggil antrian"
                        aria-describedby="call-queue-description"
                      >
                        <i class="ion ion-mic-a call-icon"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3'; 

const props = defineProps(['queues', 'category_id', 'counter_id']);

const callQueue = async (queue) => {
    // if (window.responsiveVoice) {
    //     const message = `Nomor antrian ${queue.no}, silahkan menuju loket ${props.counter_id}.`;
    //     responsiveVoice.speak(message, "Indonesian Female");

    //     await new Promise((resolve) => setTimeout(resolve, 1000));

        const form = useForm();
        await form.post(`/queues/${queue.id}/call`, {
          status: 2,
          category_id: props.category_id,
          counter_id: props.counter_id     
        });

        localStorage.setItem('currentQueueNumber', queue.no);
    // } else {
    //     console.error("ResponsiveVoice is not loaded.");
    // }
};

// onMounted(() => {
//     if (!window.responsiveVoice) {
//         const script = document.createElement('script');
//         script.src = "https://code.responsivevoice.org/responsivevoice.js?key=65BmgOll";
//         script.onload = () => {
//             console.log("ResponsiveVoice script loaded successfully.");
//         };
//         document.head.appendChild(script);
//     } else {
//         console.log("ResponsiveVoice already loaded.");
//     }
// });
</script>

<style scoped>
.call-button {
  width: 30px;
  height: 30px;
  padding: 0;
}

.call-icon {
  font-size: 17px;
}
</style>

<script>
import Home from '../../Layout/Home.vue';

export default {
  layout: Home,
};
</script>
