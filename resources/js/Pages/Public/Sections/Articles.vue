<script setup>
defineProps({
  articles: Array
})
</script>

<template>
  <div class="max-w-6xl mx-auto px-4">
    <h2 class="text-2xl font-bold mb-6 text-center">Artikel Terbaru</h2>

    <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-6">
      <div
        v-for="item in articles"
        :key="item.id"
        class="bg-white shadow rounded overflow-hidden border hover:shadow-md transition"
      >
        <div class="p-4">
          <h3 class="text-lg font-semibold mb-2">
            <a
              :href="route('artikel.detail', item.slug)"
              class="hover:underline text-blue-600"
            >
              {{ item.title }}
            </a>
          </h3>
          <p class="text-sm text-gray-600 line-clamp-3">
            {{ item.content.replace(/(<([^>]+)>)/gi, '').slice(0, 100) }}...
          </p>
        </div>
      </div>
    </div>

    <!-- Tombol -->
    <div class="text-center mt-8">
      <a href="/artikel" class="btn-primary">Lihat Selengkapnya</a>
    </div>
  </div>
</template>
