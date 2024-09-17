<script setup>
import Nav from './Partials/Nav.vue';
import Sidebar from './Partials/Sidebar.vue';
import Footer from './Partials/Footer.vue';
</script>

<template>
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <Nav />
        <Sidebar />

        <div class="content-wrapper">
            <slot />
        </div>

        <Footer />

        <aside class="control-sidebar control-sidebar-dark">

</aside>
    </div>
</template>