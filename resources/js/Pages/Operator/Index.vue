<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Loket {{ counter_id }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><router-link to="/dashboard">Home</router-link></li>
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
                        class="btn btn-success rounded-circle"
                        @click="callQueue(queue)"
                        style="width: 30px; height: 30px; padding: 0;"
                        aria-label="Panggil antrian"
                      >
                        <i class="ion ion-mic-a" style="font-size: 17px;"></i>
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
  try {
    if (!window.responsiveVoice) {
      console.error("ResponsiveVoice tidak tersedia");
      return;
    }

    const message = `Nomor antrian ${queue.no}, silahkan menuju loket ${props.counter_id}.`;

    responsiveVoice.speak(message, "Indonesian Female");

    await new Promise((resolve) => setTimeout(resolve, 1000));

    const form = useForm();
    await form.post(`/queues/${queue.id}/call`, {
      status: 2
    });

    console.log(`Queue ${queue.no} updated to status 2`);
  } catch (error) {
    console.error("Error:", error);
  }
};

onMounted(() => {
  if (!window.responsiveVoice) {
    const script = document.createElement('script');
    script.src = "https://code.responsivevoice.org/responsivevoice.js?key=65BmgOll";
    script.onload = () => {
      console.log("Skrip ResponsiveVoice dimuat");
    };
    document.head.appendChild(script);
  } else {
    console.log("ResponsiveVoice sudah dimuat");
  }
});
</script>

<script>
import Home from '../../Layout/Home.vue';

export default {
  layout: Home,
};
</script>
