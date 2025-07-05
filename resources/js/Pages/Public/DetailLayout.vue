<script setup>
defineProps({
  title: String,
  backUrl: {
    type: String,
    default: '/',
  }
})
</script>

<template>
  <div class="min-h-screen bg-gray-50 text-gray-800">
    <!-- Header / Top Navigation -->
    <div class="bg-white border-b">
      <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <a href="/" class="font-bold text-xl text-gray-800 hover:text-blue-600">MySite</a>
        <a :href="backUrl" class="text-sm text-blue-600 hover:underline">
          ← Kembali
        </a>
      </div>
    </div>

    <!-- Content -->
    <main class="py-8 px-4">
        <slot />
    </main>
  </div>
</template>
