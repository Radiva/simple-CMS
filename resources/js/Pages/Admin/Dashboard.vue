<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
  summary: Object,
  role: String,
})
</script>

<template>
  <AdminLayout>
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-sm text-gray-500">Artikel</h2>
        <p class="text-2xl font-semibold">{{ summary.artikel }}</p>
      </div>

      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-sm text-gray-500">Portofolio</h2>
        <p class="text-2xl font-semibold">{{ summary.portofolio }}</p>
      </div>

      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-sm text-gray-500">Komentar</h2>
        <p class="text-2xl font-semibold">{{ summary.komentar }}</p>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-sm text-gray-500">Tautan</h2>
        <p class="text-2xl font-semibold">{{ summary.tautan }}</p>
      </div>

      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-sm text-gray-500">Kategori</h2>
        <p class="text-2xl font-semibold">{{ summary.kategori }}</p>
      </div>
    </div>
  </AdminLayout>
</template>
