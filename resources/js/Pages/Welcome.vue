<template>
    <div class="container-fluid">
        <header class="d-flex flex-wrap justify-content-between py-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <div class="bi me-2 ms-5" width="40" height="32">
                    <img src="https://png.pngtree.com/png-clipart/20230207/original/pngtree-beauty-logo-design-png-image_8947095.png" alt="icon" width="40" height="40">
                </div>
                <span class="fs-4 fw-bold">NAMA COMPANY</span>
            </a>
            <div class="d-flex align-items-center text-dark ms-auto me-5">
                <i class="fa fa-calendar me-2"></i>
                <div class="fs-5 text-bold">{{ currentDate }}</div>
                <div class="fs-5 text-bold ms-3">{{ currentTime }}</div>
            </div>
        </header>

        <div class="row gx-3 me-5 ms-5 mb-5">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="feature-icon-1 bg-success bg-gradient mb-4">
                            <i class="fa fa-desktop" aria-hidden="true"></i>
                        </div>
                        <h3>Monitor Antrian</h3>
                        <p class="mb-5">Halaman Monitor Antrian digunakan menampilkan antrian pada monitor.</p>
                        <a href="/monitor" class="btn btn-success rounded-pill px-4 py-2">
                            Tampilkan <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="feature-icon-1 bg-success bg-gradient mb-4">
                            <i class="fa fa-users"></i>
                        </div>
                        <h3>Nomor Antrian</h3>
                        <p class="mb-5">Halaman Nomor Antrian digunakan pengunjung untuk mengambil nomor antrian.</p>
                        <a href="/antrian" class="btn btn-success rounded-pill px-4 py-2">
                            Tampilkan <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="feature-icon-1 bg-success bg-gradient mb-4">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <h3>Login Petugas</h3>
                        <p class="mb-5">Halaman Login Petugas digunakan petugas loket untuk mengakses sistem dan melayani antrian pelanggan.</p>
                        <a href="/login" class="btn btn-success rounded-pill px-4 py-2">
                            Tampilkan <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer py-4 border-top">
            <div class="container text-center">
                <p class="mb-0">
                    <a href="https://balisolutionbiz.com/">© 2024 BaliSolutionBiz.</a> All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import '../../css/dashboard.css'
import { onMounted, ref, onBeforeUnmount } from 'vue';

const currentDate = ref('');
const currentTime = ref('');

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

<style>
html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
}

.container-fluid {
    flex: 1; 
}

footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #f8f9fa;
    border-top: 1px solid #e9ecef;
}

.feature-icon-1 {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #28a745;
    color: white;
    font-size: 24px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: background 0.3s ease, transform 0.3s ease;
}

.feature-icon-1:hover {
    background: #218838;
    transform: scale(1.1);
}
</style>
