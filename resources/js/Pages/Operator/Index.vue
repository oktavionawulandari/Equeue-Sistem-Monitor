<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-sm-6">
          <h1 class="m-0 text-uppercase">Daftar Loket {{ counter_name }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><Link href="/home">Home</Link></li>
            <li class="breadcrumb-item active">Daftar Loket</li>
          </ol>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-success">
              <i class="ion ion-person-stalker"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text text-bold">TOTAL ANTRIAN</span>
              <span>{{ totalAntrian }}</span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-warning">
              <i class="ion ion-clock"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text text-bold">ANTRIAN SEKARANG</span>
              <span>{{ QueuenNo }}</span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary">
              <i class="ion ion-arrow-right-b"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text text-bold">ANTRIAN BERIKUTNYA</span>
              <span>{{ AntrianBerikutnya?.no }}</span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-danger">
              <i class="ion ion-alert-circled"></i>
            </span>
            <div class="info-box-content">
              <span class="info-box-text text-bold">SISA ANTRIAN</span>
              <span>{{ SisaAntrian }}</span>
            </div>
          </div>
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
                  <tr v-for="(queue, index) in filteredQueues" :key="queue.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ queue.no }}</td>
                    <td>
                      <button
                        v-if="Number(queue.status) !== 4"
                        type="button"
                        :class="{
                          'btn-primary': Number(queue.status) === 1,
                          'btn-warning': Number(queue.status) === 3 ||  Number(queue.status) === 2,
                          'call-button': true,
                          'me-2': true
                        }"
                        @click="callQueue(queue)"
                        aria-label="Panggil antrian"
                        aria-describedby="call-queue-description"
                      >
                        <i class="ion ion-mic-a call-icon"></i>
                      </button>
                      <!-- <button
                        v-if="Number(queue.status) !== 4"
                        type="button"
                        class="btn btn-success call-button"
                        @click="successQueue(queue)"
                        aria-label="Panggil antrian"
                        aria-describedby="call-queue-description"
                      >
                        <i class="ion ion-checkmark call-icon"></i>
                      </button> -->
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
import { onMounted, onUpdated, ref } from 'vue';
import { useForm, router, usePage, Link } from '@inertiajs/vue3'; 

const props = defineProps(['queues', 'category_id', 'counter_id', 'sisaAntrian', 'counter_name', 'QueuenNo']);


const filteredQueues = ref(props.queues.filter(queue => Number(queue.status) !== 4));

const totalAntrian = ref(props.queues.length);

const SisaAntrian = ref(props.queues.filter(queue => Number(queue.status) === 1).length);

const AntrianBerikutnya = ref(props.queues.find(queue => Number(queue.status) === 1 ));
const QueuenNo = ref(null);

const callQueue = async (queue) => {
  const form = useForm({
    status: 2,
    counter_id: props.counter_id 
  });
  
//   form.post(`/queues/${queue.id}/call`, {
//     onSuccess: () => {
//       router.get(usePage().url)

//       localStorage.setItem('currentQueueNumber', queue.no);
    
//       QueuenNo.value = queue.no
//     }
//   });
// };

form.post(`/queues/${queue.id}/call`, {
    onSuccess: () => {
      router.get(usePage().url)
      // QueuenNo.value = usePage().props.QueuenNo;
    }
  });
};

const successQueue = async (queue) => {
  const form = useForm({
    status: 4,
    counter_id: props.counter_id 
  });

  form.post(`/queues/${queue.id}/call`);
  // router.get(usePage().url)
};

onUpdated(() => {
  AntrianBerikutnya.value = usePage().props.queues.find(queue => Number(queue.status) === 1 )
  QueuenNo.value = usePage().props.QueuenNo;
})

onMounted(() => {
  AntrianBerikutnya.value = usePage().props.queues.find(queue => Number(queue.status) === 1 )
  QueuenNo.value = usePage().props.QueuenNo;
})
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
