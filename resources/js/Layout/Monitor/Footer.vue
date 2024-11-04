<template>
    <footer class="footer py-2 border-top mt-auto" :style="{ backgroundColor: setting?.footer }">
      <div class="container text-center" :style="{ color: setting?.text }">
        <p class="mb-0 text-bold"  style="font-size: 18px;">
                <a>© 2024</a> <a href="https://balisolutionbiz.com/">BaliSolutionBiz</a>
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
