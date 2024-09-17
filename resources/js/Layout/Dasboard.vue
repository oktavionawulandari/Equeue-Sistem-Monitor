<script setup>
import '../../css/dashboard.css'


import Nav from './Partials/Nav.vue';
import Sidebar from './Partials/Sidebar.vue';
import Footer from './Partials/Footer.vue';
</script>

<template>
    <div class="wrapper">

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