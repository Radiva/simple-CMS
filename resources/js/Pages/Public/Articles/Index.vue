<script setup>
import DetailLayout from '../DetailLayout.vue';

defineProps({
  articles: Array
})
</script>

<template>
    <DetailLayout>
  <div class="max-w-6xl mx-auto px-4">
    <h1 class="text-3xl font-bold text-center mb-10">Artikel</h1>

    <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-6">
      <div
        v-for="artikel in articles"
        :key="artikel.id"
        class="bg-white border shadow rounded overflow-hidden hover:shadow-md transition"
      >
        <div class="p-4">
          <h2 class="text-xl font-semibold text-blue-600 hover:underline mb-2">
            <a :href="route('artikel.detail', artikel.slug)">
              {{ artikel.title }}
            </a>
          </h2>

          <!-- Tanggal -->
          <div class="text-sm text-gray-400 mb-2">
            {{ new Date(artikel.published_at).toLocaleDateString('id-ID') }}
          </div>

          <!-- Ringkasan konten -->
          <p class="text-sm text-gray-700 line-clamp-3">
            {{ artikel.content.replace(/(<([^>]+)>)/gi, '').slice(0, 120) }}...
          </p>

          <!-- Baca Selengkapnya -->
          <div class="mt-4">
            <a
              :href="route('artikel.detail', artikel.slug)"
              class="text-sm text-blue-600 hover:underline"
            >
              Baca Selengkapnya →
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  </DetailLayout>
</template>
