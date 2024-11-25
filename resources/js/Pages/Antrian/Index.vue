<template>
    <AppMeta title="Antrian" />
    <div
      class="d-flex flex-column min-vh-100"
      :style="{ backgroundColor: props.setting?.background }"
    >
      <header
        :style="{ backgroundColor: props.setting?.navigasi }"
        class="d-flex flex-wrap align-items-center justify-content-between py-2 mb-4 border-bottom"
      >
        <div class="d-flex align-items-center text-dark ms-3">
          <Link
            class="nav-link me-3"
            :href="route('list.instansi')"
            title="Kembali"
            :style="{ color: props.setting?.text, marginLeft: '20px' }" 
          >
            <i class="fas fa-sign-out-alt"></i>
          </Link>

          <div class="d-flex align-items-center">
            <img
              :src="`/storage/logo/${props.setting?.logo}`" 
              alt="logo"
              width="40"
              height="40"
            />
            <span
              class="fs-4 text-bold ms-2"
              :style="{
                color: props.setting?.text,
                fontSize: '22px',
              }"
              >{{ props.setting?.instansi ?? "" }}</span
            >
          </div>
        </div>

        <div class="d-flex align-items-center text-dark ms-auto ms-5" :style="{marginRight: '20px' }">
          <i
            class="fa fa-calendar me-2"
            :style="{ color: props.setting?.text }"
          ></i>
          <div
            class="fs-5 text-bold"
            :style="{ color: props.setting?.text, marginLeft: '5px' }"
          >
            {{ currentDate }}
          </div>
          <div
            class="fs-5 text-bold ms-3"
            :style="{ color: props.setting?.text, marginLeft: '5px' }"
          >
            {{ currentTime }}
          </div>
        </div>
      </header>

      

      <div class="container-fluid">
        <form @submit.prevent="submitForm">
          <div class="row">
            <div
              class="col-lg-4"
              v-for="cat in categories"
              :key="cat.id"
            >
              <div class="card">
                <div
                  class="card-body d-flex justify-content-center align-items-center"
                >
                  <h1
                    class="card-title text-bold text-uppercase text-danger" style="font-size: 40px;"
                  >
                    {{ cat.name }}
                  </h1>
                </div>
              </div>

              <div
                class="card"
                :style="{
                  background:
                    'linear-gradient(135deg, #eaf9d3, #c3e6b4)',
                }"
              >
                <div class="card-body">
                  <div
                    class="border border-success rounded-5 py-2 mb-4"
                  >
                    <h1
                      id="antrian"
                      class="display-1 text-danger text-bold text-center lh-1 pb-2"
                    >
                      {{ getLatestQueueNumber(cat) }}
                    </h1>
                  </div>
                  <button
                    v-if="
                      parseInt(props.setting?.set_phone) === 1
                    "
                    type="submit"
                    class="btn btn-success btn-block rounded-pill fs-5 px-5 py-4 mb-2"
                    :disabled="isSubmitting"
                    @click="
                      () => {
                        form.category_id = cat.id;
                        form.status = 1;
                        directPrint();
                      }
                    "
                  >
                    <i class="fa fa-user-plus fs-4 me-4"></i>
                    Ambil Nomor
                  </button>

                  <button
                    v-if="
                      parseInt(props.setting?.set_phone) === 0
                    "
                    type="button"
                    class="btn btn-success btn-block rounded-pill fs-5 px-5 py-4 mb-2"
                    :disabled="isSubmitting"
                    @click="
                      () => {
                        form.category_id = cat.id;
                        form.status = 1;
                        confirmPrint();
                        showModal(cat.id);
                      }
                    "
                  >
                    <i class="fa fa-user-plus fs-4 me-4"></i>
                    Ambil Nomor
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div
        v-if="isModalVisible"
        class="modal fade show"
        tabindex="-1"
        style="display: block; background: rgba(0, 0, 0, 0.5)"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">
                Konfirmasi Pengambilan Nomor
              </h5>
              <button
                type="button"
                class="btn-close"
                @click="hideModal"
              ></button>
            </div>
            <div class="modal-body">
              <p>Masukkan Nomor HP</p>
              <input
                type="text"
                v-model="form.phone"
                class="form-control"
                :class="{ 'is-invalid': errors.phone }"
                placeholder="Nomor HP"
                @focus="showNumericKeypad"
              />
              <div v-if="errors.phone" class="invalid-feedback">
                {{ errors.phone }}
              </div>
            </div>

            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                @click="hideModal"
              >
                Batal
              </button>
              <button
                type="button"
                class="btn btn-success"
                @click="confirmSubmit"
              >
                Ambil Nomor
              </button>
            </div>
          </div>
        </div>
        <div class="content">
            <div
          v-if="isNumericKeypadVisible"
          class="numeric-keypad"
        >
          <button
            v-for="i in keypadButtons"
            :key="i"
            class="keypad-button"
            @click="handleKeypadInput(i)"
          >
            {{ i }}
          </button>
          <button
            class="keypad-button"
            @click="clearPhoneInput"
          >
            C
          </button>
          <button
            class="keypad-button"
            @click="delPhoneInput"
          >
            Del
          </button>

        </div>
        </div>
      </div>

      <Foot :setting="props?.setting" />
    </div>
  </template>

  <script setup>
  import { onMounted, ref, onBeforeUnmount } from "vue";
  import { useForm, router, Link, usePage } from "@inertiajs/vue3";
  import Foot from "../../Layout/Monitor/Footer.vue";
  import "../../../css/dashboard.css";
  import AppMeta from "@/Components/AppMeta.vue";

  const { props } = usePage();
  const categories = ref(props.categories || []);
  const currentTime = ref("");
  const currentDate = ref("");
  const isSubmitting = ref(false);
  const printType = ref("");
  const isModalVisible = ref(false);
  const isNumericKeypadVisible = ref(false);
  const keypadButtons = ref([1, 2, 3, 4, 5, 6, 7, 8, 9, 0]);
  const form = useForm({
    status: "",
    category_id: "",
    date: new Date().toISOString(),
    phone: "",
    status_phone: props.setting?.set_phone,
    instansi_id: "",
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
    return category.kode.toUpperCase() + "-000";
  };

  const errors = ref({});

  const submitForm = () => {
    isSubmitting.value = true;
    form.post(`/antrian/${props.instansi_id}`, {
      onSuccess: (page) => {
        const categoryId = form.category_id;

        if (printType.value === "direct") {
          window.open(`/antrian/${categoryId}/print`, "_blank");
        } else if (printType.value === "confirm" && form.phone) {
          open(`/antrian/${categoryId}/print`);
        }

         router.get("/list/instansi");

        isSubmitting.value = false;
      },
      onError: (error) => {
        isSubmitting.value = false;
        errors.value = error;
      },
    });
  };

  const directPrint = () => {
    printType.value = "direct";
    submitForm();
  };

  const confirmPrint = () => {
    printType.value = "confirm";
    showModal();
  };

  const confirmSubmit = () => {
    if (!form.phone) {
      errors.value.phone = "Nomor HP harus diisi";
    } else {
      hideModal();
      submitForm();
    }
  };

  const updateCurrentDateTime = () => {
    const now = new Date();
    const dateOptions = {
      weekday: "long",
      year: "numeric",
      month: "long",
      day: "numeric",
    };
    const timeOptions = {
      hour: "2-digit",
      minute: "2-digit",
      second: "2-digit",
    };
    currentDate.value = now.toLocaleDateString("id-ID", dateOptions);
    currentTime.value = now.toLocaleTimeString("id-ID", timeOptions);
  };

  const showModal = () => {
    isModalVisible.value = true;
    updateCurrentDateTime();
  };

  const hideModal = () => {
    isModalVisible.value = false;
  };

  const showNumericKeypad = () => {
    isNumericKeypadVisible.value = true;
  };

  const hideNumericKeypad = () => {
    isNumericKeypadVisible.value = false;
  };

  const handleKeypadInput = (value) => {
    form.phone += value;
  };

  const clearPhoneInput = () => {
    form.phone = "";
  };

  const delPhoneInput = () => {
    form.phone = form.phone.slice(0, -1);
  };

  onMounted(() => {
    updateCurrentDateTime();
    setInterval(updateCurrentDateTime, 1000);
  });

  onBeforeUnmount(() => {
    clearInterval();
  });
  </script>

<style scoped>
.numeric-keypad {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  width: 50%;
  margin: 0 auto;
  background-color: #f1f1f1;
  padding: 20px;
  border-radius: 10px;
}

.keypad-button {
  width: 30%;
  height: 60px;
  font-size: 24px;
  margin: 5px;
  border: 1px solid #ccc;
  border-radius: 10px;
  background-color: #f7f7f7;
  text-align: center;
  cursor: pointer;
  display: inline-block;
}

.card {
    border: none;
    background: linear-gradient(135deg, #eaf9d3, #c3e6b4);
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
}


.keypad-button:hover {
  background-color: #e0e0e0;
}

@media (max-width: 768px) {
  .numeric-keypad {
    width: 90%;
    padding: 15px;
  }

  .keypad-button {
    width: 45%;
    font-size: 22px;
    height: 50px;
  }
}

@media (max-width: 480px) {
  .numeric-keypad {
    width: 95%;
    padding: 10px;
  }

  .keypad-button {
    width: 30%;
    font-size: 20px;
    height: 45px;
  }
}

</style>
