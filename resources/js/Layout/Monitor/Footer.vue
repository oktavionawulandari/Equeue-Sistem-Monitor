<template>
    <footer class="footer py-4 border-top mt-auto">
      <div class="container text-center">
        <p class="mb-0">
          <a href="https://balisolutionbiz.com/">© 2024 BaliSolutionBiz.</a> <a  :style="{ color: setting.text }">All rights reserved.</a>
        </p>
      </div>
    </footer>
  </template>
  
  <script setup>
  const props = defineProps(['setting']);

  // No specific logic required for footer
  </script>
  
  <style scoped>
  /* Add any specific styles for Footer here */
  </style>
  