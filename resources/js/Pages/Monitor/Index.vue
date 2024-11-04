<template>
    <AppMeta title="Monitor Antrian" />

    <div class="d-flex flex-column min-vh-100" :style="{ backgroundColor: props.setting?.background }">
        <Header :setting="props.setting" />

        <div class="container-fluid">
            <div class="row">
                <!-- Video Section -->
                <div class="col-8">
                    <video
                        id="myVideo"
                        class="rounded"
                        width="100%"
                        height="100%"
                        autoplay
                        loop
                        controls
                        style="object-fit: scale-down; height: 54vh"
                    >
                        <source :src="'/storage/videos/' + props.setting?.video" type="video/mp4" />
                    </video>
                </div>

                <!-- Panggilan Section -->
                <div class="col-4">
                    <div class="card text-center bg-secondary">
                        <div class="card-header text-uppercase" style="font-size: 30px">
                            Panggilan Saat ini
                        </div>
                        <div class="card-body">
                            <p class="card-text text-bold" style="font-size: 40px">{{ currentQueueNumber }}</p>
                        </div>
                        <div class="card-footer" style="font-size: 30px">{{ currentCounterNumber }}</div>
                    </div>
                </div>
                                        <!-- {{ category?.antrian?.length > 0 ? category?.antrian[0]?.queue?.no : "-" }} -->

                <!-- Cards Section -->
                <div class="col-12 mt-3">
                    <div class="row">
                        <div class="col-3 mb-2" v-for="category in display" :key="category.id">
                            <div class="card text-center text-white" :class="getBgClass(category)">
                                <h5 class="card-header text-uppercase" style="font-size: 25px">{{ category.name }}</h5>
                                <div class="card-body">
                                    <h1 class="text-center fw-bold" style="font-size: 30px">
                                          {{         getNilaiTerakhir.find(antrian => antrian.category_id === category.id)?.no || '-'
                                        }}
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <footer class="footer py-2 border-top mt-auto" :style="{ backgroundColor: props.setting?.footer }">
            <div class="text-marquee">
                <h6 :style="{ color: props.setting?.text }">{{ props.setting?.running_text }}</h6>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { onMounted, ref, onBeforeUnmount, computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import Header from "../../Layout/Monitor/Header.vue";
import AppMeta from "@/Components/AppMeta.vue";
import "../../../css/dashboard.css";

const props = defineProps(["categories", "counterId", "setting", "AntrianAkhir"]);
const currentDate = ref("");
const currentTime = ref("");
const isPlay = ref(false);
const queue = ref([]);
const categories = ref([]);
const currentQueueNumber = ref("-");
const currentCounterNumber = ref("-");
const page = usePage();
const stackPendingSuccessTrigger = ref([]);
const antrianAkhir = ref(null);

const getNilaiTerakhir = computed(() => {
    return antrianAkhir.value;
})

const getBgClass = (category) => {
    const colorClasses = ["bg-success", "bg-light", "bg-dark"];
    return colorClasses[category.id % colorClasses.length];
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
        hour12: false,
    };
    currentDate.value = now.toLocaleDateString("id-ID", dateOptions);
    currentTime.value = now.toLocaleTimeString("id-ID", timeOptions);
};

const checkQueueIfExists = (id) => {
    return (
        queue.value?.find((data) => data.id == id) &&
        stackPendingSuccessTrigger.value.includes(id)
    );
};

const display = computed(() => categories.value);

const getNotification = () => {
    fetch("/monitor/trigger-notification")
        .then((response) => response.json())
        .then((res) => {
            if (!isPlay.value) {
                res.data.forEach((data) => {
                    if (!checkQueueIfExists(data.id)) {
                        queue.value.push(data);
                    }
                });
                if (queue.value.length > 0) {
                    callNotifications();
                }
            }
        });
};

const callNotifications = () => {
    if (queue.value.length > 0) {
        queue.value.forEach((data, index) => {
            if (stackPendingSuccessTrigger.value.includes(data.id)) return;

            if (!isPlay.value) {
                isPlay.value = true;
                getDisplay(data.category.id);
                currentQueueNumber.value = data.queue.no;
                currentCounterNumber.value = data.counter.name;

                const message = `Nomor antrian ${data.queue.no}, silahkan menuju ${data.counter.name}.`;

                const vid = document.getElementById("myVideo");
                const volume = props.setting?.volume;

                if (vid && typeof volume === "number" && !isNaN(volume)) {
                    vid.volume = volume;
                }

                if (props.setting.status === 'online') {
                    responsiveVoice.speak(message, "Indonesian Female", {
                        onend: () => {
                            queue.value.splice(index, 1);
                            isPlay.value = false;

                            stackPendingSuccessTrigger.value.push(data.id);

                            successTriggerNotification(data.id, () => {
                                stackPendingSuccessTrigger.value =
                                    stackPendingSuccessTrigger.value.filter(v => v !== data.id);
                                if (queue.value.length > 0) {
                                    callNotifications();
                                }
                            });
                        },
                    });
                } else if (props.setting.status === 'offline') {
                    const synth = window.speechSynthesis;
                    const speak = new SpeechSynthesisUtterance(message);
                    speak.lang = "id-ID";

                    stackPendingSuccessTrigger.value.push(data.id);
                    speak.onend = () => {

                        queue.value.splice(index, 1);
                        isPlay.value = false;

                        successTriggerNotification(data.id, () => {
                                stackPendingSuccessTrigger.value.filter(v => v !== data.id);
                            if (queue.value.length > 0) {
                                callNotifications();
                            }
                        });
                    };
                    synth.speak(speak);
                }
            }
        });
    }
};

const getDisplay = (idCat = null) => {
    fetch("/monitor/display")
        .then((res) => res.json())
        .then((data) => {
            antrianAkhir.value = data.antrianAkhir
            if (!idCat) {
                categories.value = data.data;
            } else {
                const updatedCategory = data.data.find(
                    (val) => val.id == idCat
                );
                categories.value = categories.value.map((cat) =>
                    cat.id !== idCat ? cat : updatedCategory
                );
            }
        });
};

const successTriggerNotification = (id, onSuccess) => {
    fetch(`/monitor/trigger-notification/${id}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
        body: JSON.stringify({
            _method: "PATCH",
            _token: page.props.csrf_token,
        }),
    })
        // .then((res) => res.json())
        .then(() => onSuccess())
        .catch((err) => console.log("Error 404:", err));
};

const fetchAntrianTerakhir = () => {
    fetch("/monitor/display")
        .then((res) => res.json())
        .then((data) => {
            antrianAkhir.value = data.antrianAkhir
        });
}

onMounted(() => {
    let vid = document.getElementById("myVideo");

    if (vid) {
        vid.volume = props.setting?.volume;
    }

    getDisplay();
    updateCurrentDateTime();
    const timeInterval = setInterval(updateCurrentDateTime, 1000);

    onBeforeUnmount(() => clearInterval(timeInterval));
});

setInterval(() => {
    getNotification()
    fetchAntrianTerakhir()
}, 2000);
</script>

<style scoped>
.scroll-container {
    display: flex;
    flex-direction: column;
    overflow-y: auto;
}

.text-marquee {
    white-space: nowrap;
    overflow: hidden;
    position: relative;
}

.text-marquee h6 {
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
