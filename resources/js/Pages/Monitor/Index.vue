<template>
    <AppMeta title="Monitor Antrian" />

    <div
        class="d-flex flex-column min-vh-100"
        :style="{ backgroundColor: props.setting?.background }"
    >
        <Header :setting="props.setting" />

        <div>
            <!-- Jika jumlah kategori lebih dari 3 -->
            <div v-if="categories.length > 4" class="container-fluid m-auto">
                <div class="row">
                    <div class="col-12">
                        <div
                            class="card text-center text-white"
                            :style="{
                                backgroundColor: props?.setting?.navigasi,
                            }"
                        >
                            <div class="card-body">
                                <h4 class="font-weight-bold">
                                    Panggilan Saat Ini
                                </h4>
                                <p
                                    class="card-text text-bold"
                                    style="font-size: 90px"
                                >
                                    {{ currentQueueNumber }}
                                </p>
                                <p style="font-size: 50px">
                                    {{ currentCounterNumber }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div
                                class="col-4"
                                v-for="(category, i) in props.categories"
                            >
                                <div class="card card-body">
                                    <div class="d-flex justify-content-between">
                                        <span
                                            class="font-weight-bold"
                                            style="font-size: 1.4em"
                                            >{{
                                                getNilaiTerakhir.find(
                                                    (antrian) =>
                                                        antrian?.category_id ===
                                                        category?.id
                                                )?.no || "-"
                                            }}</span
                                        >
                                        <span
                                            class="font-weight-bold"
                                            style="font-size: 1.4em"
                                        >
                                            {{
                                                getNilaiTerakhir.find(
                                                    (antrian) =>
                                                        antrian?.category_id ===
                                                        category?.id
                                                )?.counter?.name ||
                                                category?.counters[0]?.name
                                            }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jika jumlah kategori kurang dari atau sama dengan 3 -->
            <div v-else class="container-fluid">
                <div class="row">
                    <!-- Video atau Carousel -->
                    <div class="col-8">
                        <carousel
                            :items-to-show="1"
                            autoplay="5000"
                            :wrapAround="true"
                        >
                            <slide
                                v-for="(image, index) in JSON.parse(
                                    props.setting?.images || '[]'
                                )"
                                :key="index"
                            >
                                <img
                                    :src="'https://antrian.koperasi-bali.my.id/storage/' + image"
                                    alt="Image"
                                    class="carousel-item-img"
                                />
                            </slide>
                            <template #addons>
                                <navigation />
                                <pagination />
                            </template>
                        </carousel>
                    </div>

                    <!-- Panggilan Section -->
                    <div class="col-4">
                        <div class="card text-center bg-secondary">
                            <div
                                class="card-header text-uppercase"
                                style="font-size: 30px"
                            >
                                Panggilan Saat ini
                            </div>
                            <div class="card-body">
                                <p
                                    class="card-text text-bold"
                                    style="font-size: 40px"
                                >
                                    {{ currentQueueNumber }}
                                </p>
                            </div>
                            <div class="card-footer" style="font-size: 30px">
                                {{ currentCounterNumber }}
                            </div>
                        </div>
                    </div>

                    <!-- Cards Section -->
                    <div class="col-12 mt-3">
                        <div class="row">
                            <div
                                class="col-3 mb-2"
                                v-for="category in display"
                                :key="category.id"
                            >
                                <div
                                    class="card text-center text-white"
                                    :class="getBgClass(category)"
                                >
                                    <h5
                                        class="card-header text-uppercase"
                                        style="font-size: 25px"
                                    >
                                    {{
                                                getNilaiTerakhir.find(
                                                    (antrian) =>
                                                        antrian?.category_id ===
                                                        category?.id
                                                )?.counter?.name ||
                                                category?.counters[0]?.name
                                            }}
                                    </h5>
                                    <div class="card-body">
                                        <h1
                                            class="text-center fw-bold"
                                            style="font-size: 30px"
                                        >
                                            {{
                                                getNilaiTerakhir.find(
                                                    (antrian) =>
                                                        antrian?.category_id ===
                                                        category?.id
                                                )?.no || "-"
                                            }}
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div
            v-if="showPopup"
            style="
                position: absolute;
                top: 0;
                right: 0;
                left: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.3);
                display: flex;
                justify-content: center;
                padding-top: 100px;
            "
        >
            <button
                class="btn font-weight-bold"
                @click="closePopup"
                :style="{
                    backgroundColor: props?.setting?.navigasi,
                    color: props?.setting?.text,
                    height: '100px',
                    width: '500px',
                }"
            >
                Monitor sudah siap!! tolong di click
            </button>
        </div> -->

        <!-- Footer Section -->
        <footer
            class="footer py-2 border-top mt-auto"
            :style="{ backgroundColor: props.setting?.footer }"
        >
            <div class="text-marquee" v-if="!showPopup">
                <h6 :style="{ color: props.setting?.text }">
                    {{ props.setting?.running_text }}
                </h6>
            </div>
        </footer>

        <iframe
            src=""
            frameborder="0"
            id="audio-tingtung"
            style="display: none"
            allow="autoplay"
        ></iframe>
        <!-- <audio style="display: none" id="audio-tingtung">
            <source src="/assets/audio/tingtung.mp3" type="audio/mpeg" />
        </audio> -->
    </div>
</template>

<script setup>
import {
    onMounted,
    ref,
    onBeforeUnmount,
    computed,
    defineComponent,
} from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import Header from "../../Layout/Monitor/Header.vue";
import AppMeta from "@/Components/AppMeta.vue";
import "../../../css/dashboard.css";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";

defineComponent({
    Carousel,
    Slide,
    Pagination,
    Navigation,
});

const props = defineProps([
    "categories",
    "counterId",
    "setting",
    "AntrianAkhir",
]);

const config = {
    itemsToShow: 1.5,
};

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
const showPopup = ref(true);
const isFirstMount = ref(true);

const closePopup = () => (showPopup.value = false);

const getNilaiTerakhir = computed(() => {
    return antrianAkhir?.value;
});

const getBgClass = (category) => {
    const colorClasses = ["bg-success", "bg-light", "bg-dark"];
    return colorClasses[category?.id % colorClasses?.length];
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
        queue.value?.find((data) => data.queue_id == id) ||
        stackPendingSuccessTrigger.value.includes(id)
    );
};

const display = computed(() => categories.value);

const getNotification = () => {
    fetch("/monitor/trigger-notification")
        .then((response) => response.json())
        .then((res) => {
            if (!isPlay.value) {
                res?.data?.forEach((data) => {
                    if (!checkQueueIfExists(data?.queue_id)) {
                        console.log("push");
                        queue?.value?.push(data);
                    }
                });
                if (queue?.value?.length > 0) {
                    callNotifications();
                }
            }
        });
};

const callNotifications = () => {
    if (queue?.value?.length > 0) {
        queue?.value?.forEach((data, index) => {
            if (!isPlay.value) {
                isPlay.value = true;
                getDisplay(data?.category?.id);
                currentQueueNumber.value = data?.queue?.no;
                currentCounterNumber.value = data?.counter?.name;

                const message = `Nomor antrian ${data?.queue?.no}, silahkan menuju ${data?.counter?.name}.`;

                // const audio = new Audio("/assets/audio/tingtung.mp3");
                const audio = document.getElementById("audio-tingtung");
                if (props.setting?.called == "1") {
                    audio.src = "/assets/audio/tingtung.mp3";

                    setTimeout(() => {
                        if (props?.setting?.status === "online") {
                            responsiveVoice.speak(
                                message,
                                "Indonesian Female",
                                {
                                    onend: () => {
                                        isPlay.value = false;
                                        queue.value.splice(index, 1);
                                        stackPendingSuccessTrigger.value.push(
                                            data?.queue_id
                                        );

                                        successTriggerNotification(
                                            data?.id,
                                            () => {
                                                stackPendingSuccessTrigger.value =
                                                    stackPendingSuccessTrigger.value?.filter(
                                                        (v) =>
                                                            v != data?.queue_id
                                                    );
                                                if (queue?.value?.length > 0) {
                                                    callNotifications();
                                                }
                                            }
                                        );
                                    },
                                }
                            );
                        } else if (props?.setting?.status === "offline") {
                            const synth = window.speechSynthesis;
                            const speak = new SpeechSynthesisUtterance(message);
                            speak.lang = "id-ID";

                            stackPendingSuccessTrigger?.value?.push(
                                data?.queue_id
                            );
                            speak.onend = () => {
                                queue?.value?.splice(index, 1);
                                isPlay.value = false;

                                successTriggerNotification(data?.id, () => {
                                    stackPendingSuccessTrigger.value =
                                        stackPendingSuccessTrigger?.value?.filter(
                                            (v) => v != data?.queue_id
                                        );
                                    if (queue?.value?.length > 0) {
                                        callNotifications();
                                    }
                                });
                            };
                            synth.speak(speak);
                        }
                    }, 3050);
                } else if (props.setting?.called == "0") {
                    if (props?.setting?.status === "online") {
                        responsiveVoice.speak(message, "Indonesian Female", {
                            onend: () => {
                                isPlay.value = false;
                                queue.value.splice(index, 1);
                                stackPendingSuccessTrigger.value.push(
                                    data?.queue_id
                                );

                                successTriggerNotification(data?.id, () => {
                                    stackPendingSuccessTrigger.value =
                                        stackPendingSuccessTrigger.value?.filter(
                                            (v) => v != data?.queue_id
                                        );
                                    if (queue?.value?.length > 0) {
                                        callNotifications();
                                    }
                                });
                            },
                        });
                    } else if (props?.setting?.status === "offline") {
                        const synth = window.speechSynthesis;
                        const speak = new SpeechSynthesisUtterance(message);
                        speak.lang = "id-ID";

                        stackPendingSuccessTrigger?.value?.push(data?.queue_id);
                        speak.onend = () => {
                            queue?.value?.splice(index, 1);
                            isPlay.value = false;

                            successTriggerNotification(data?.id, () => {
                                stackPendingSuccessTrigger.value =
                                    stackPendingSuccessTrigger?.value?.filter(
                                        (v) => v != data?.queue_id
                                    );
                                if (queue?.value?.length > 0) {
                                    callNotifications();
                                }
                            });
                        };
                        synth.speak(speak);
                    }
                }
            }
        });
    }
};

// const callNotifications = () => {
//     if (queue?.value?.length > 0) {
//         queue?.value?.forEach((data, index) => {
//             // console.log("queue :", queue.value);
//             // console.log("stack pending :", stackPendingSuccessTrigger.value);
//             // console.log(
//             //     "is in stack :",
//             //     stackPendingSuccessTrigger.value.includes(data.queue_id)
//             // );
//             // if (stackPendingSuccessTrigger.value.includes(data.queue_id))
//             //     return;

//             if (!isPlay.value) {
//                 isPlay.value = true;
//                 getDisplay(data?.category?.id);
//                 currentQueueNumber.value = data?.queue?.no;
//                 currentCounterNumber.value = data?.counter?.name;

//                 const message = `Nomor antrian ${data?.queue?.no}, silahkan menuju ${data?.counter?.name}.`;

//                 // const vid = document.getElementById("myVideo");
//                 // const volume = props.setting?.volume;

//                 // if (vid && typeof volume === "number" && !isNaN(volume)) {
//                 //     vid.volume = volume;
//                 // }

//                 if (props?.setting?.status === "online") {
//                     responsiveVoice.speak(message, "Indonesian Female", {
//                         onend: () => {
//                             isPlay.value = false;
//                             queue.value.splice(index, 1);
//                             // queue.value = queue.value.filter(
//                             //     (val) => val.queue_id != data.queue_id
//                             // );

//                             stackPendingSuccessTrigger.value.push(
//                                 data?.queue_id
//                             );

//                             successTriggerNotification(data?.id, () => {
//                                 stackPendingSuccessTrigger.value =
//                                     stackPendingSuccessTrigger.value?.filter(
//                                         (v) => v != data?.queue_id
//                                     );
//                                 if (queue?.value?.length > 0) {
//                                     callNotifications();
//                                 }
//                             });
//                         },
//                     });
//                 } else if (props?.setting?.status === "offline") {
//                     const synth = window.speechSynthesis;
//                     const speak = new SpeechSynthesisUtterance(message);
//                     speak.lang = "id-ID";

//                     stackPendingSuccessTrigger?.value?.push(data?.queue_id);
//                     speak.onend = () => {
//                         queue?.value?.splice(index, 1);
//                         isPlay.value = false;
//                         // queue.value = queue.value.filter(
//                         //     (val) => val.queue_id != data.queue_id
//                         // );

//                         successTriggerNotification(data?.id, () => {
//                             stackPendingSuccessTrigger.value =
//                                 stackPendingSuccessTrigger?.value?.filter(
//                                     (v) => v != data?.queue_id
//                                 );
//                             if (queue?.value?.length > 0) {
//                                 callNotifications();
//                             }
//                             console.log("on success")
//                         });
//                     };
//                     synth.speak(speak);
//                 }
//             }
//         });
//     }
// };

const getDisplay = (idCat = null) => {
    fetch("/monitor/display")
        .then((res) => res.json())
        .then((data) => {
            antrianAkhir.value = data?.antrianAkhir;
            if (!idCat) {
                categories.value = data?.data;
            } else {
                const updatedCategory = data?.data?.find(
                    (val) => val?.id == idCat
                );
                categories.value = categories?.value.map((cat) =>
                    cat?.id !== idCat ? cat : updatedCategory
                );
            }
        });
};

const successTriggerNotification = (id, onSuccess, onError) => {
    const form = useForm({});

    form.patch(`/monitor/trigger-notification/${id}`, {
        onSuccess: () => {
            console.log("success triger");
            onSuccess();
        },
        onError: onError,
    });
};

const fetchAntrianTerakhir = () => {
    fetch("/monitor/display")
        .then((res) => res.json())
        .then((data) => {
            antrianAkhir.value = data?.antrianAkhir;
        });
};

onMounted(() => {
    // let vid = document.getElementById("myVideo");

    // if (vid) {
    //     vid.volume = props.setting?.volume;
    // }

    getDisplay();
    updateCurrentDateTime();
    const timeInterval = setInterval(updateCurrentDateTime, 1000);

    onBeforeUnmount(() => clearInterval(timeInterval));
});

setInterval(() => {
    getNotification();
    fetchAntrianTerakhir();
}, 2000);
</script>

<style scoped>
.card-header {
    font-size: 25px;
    height: 80px;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
}

.carousel-item-img {
    width: 100%;
    height: 350px;
    object-fit: contain;
}

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
