<template>
    <AppMeta title="Cetak No Antrian">
        <link
            rel="icon"
            :href="`/storage/logo/${props.setting?.logo}`"
            type="image/x-icon"
        />
    </AppMeta>
    <html>
        <head>
            <title>Cetak No Antrian</title>
        </head>
        <body>
            <div class="receipt">
                <div class="instnsi">
                    <h2>{{ props.setting?.instansi }}</h2>
                </div>
                    <div class="header d-flex align-items-center">
                        <!-- <div class="header-text">
                            <h2>{{ props.setting?.instansi }}</h2>
                        </div> -->
                    </div>
                    <div class="datetime">
                        <div class="date">{{ currentDate }}</div>
                        <div class="time">{{ currentTime }}</div>
                    </div>
                    <p>=================================</p>
                    <div class="antrian">NO ANTRIAN</div>
                    <div class="queue-number">{{ props.latestQueue.no }}</div>
                    <div class="counters">
                        <div v-for="(counter, index) in props.category.counters" :key="counter.id" class="counter">
                            {{ counter.name }}<span v-if="index < props.category.counters.length - 1">/</span>
                        </div>
                    </div>
                    <div class="instructions">
                        Silahkan menunggu nomor antrian dipanggil. Nomor ini hanya
                        berlaku pada hari ini.
                    </div>
                </div>
        </body>
    </html>
</template>


<script setup>
import { ref, onMounted } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import AppMeta from "@/Components/AppMeta.vue";


const { props } = usePage();
const category = ref(props.category);
const latestQueue = ref(props.latestQueue);

const currentTime = ref("");
const currentDate = ref("");

const updateCurrentDateTime = () => {
    const now = new Date();
    const dateOptions = {
        weekday: "long",
        year: "numeric",
        month: "numeric",
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

onMounted(() => {
    updateCurrentDateTime();
    setTimeout(() => {
        window.print();
        window.close();
    }, 1000);
});
</script>

<style scoped>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}
.receipt {
    width: 350px;
    /* margin: 50px auto; */
    background-color: #fff;
    padding: 18px;
    text-align: center;
}

.instnsi h2{
    font-size: 1.4em;
    font-weight: bold;
    text-transform: uppercase;
}

.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header img {
    width: 50px;
    height: auto;
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
    font-size: 0.9em;
}

.datetime {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.date {
    flex: 1;
    font-size: 0.9em;
    text-align: left;
}

.time {
    flex: 1;
    font-size: 0.9em;
    text-align: right;
}

.queue-number {
    font-size: 4rem;
    font-weight: bold;
    margin-bottom: 10px;
}

.counters {
    display: flex;
    justify-content: center;
    gap: 5px;
    flex-wrap: wrap;
}

.counter {
    font-size: 1rem;
    font-weight: bold;
    text-transform: uppercase;
}

.antrian {
    font-size: 1rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.instructions {
    font-size: 0.9rem;
}
</style>
