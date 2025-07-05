<script setup>
import DetailLayout from '../DetailLayout.vue';

defineProps({
  articles: Object
})
</script>

<template>
    <DetailLayout
    back-url="/artikel">
  <div class="max-w-3xl mx-auto px-4 py-12">
    <!-- Judul -->
    <h1 class="text-3xl font-bold mb-2">{{ articles.title }}</h1>

    <!-- Tanggal -->
    <div class="text-sm text-gray-500 mb-6">
      Diterbitkan pada {{ new Date(articles.published_at).toLocaleDateString('id-ID') }}
    </div>

    <div class="mb-4 text-sm text-gray-600">
        Kategori:
        <span
            v-for="(cat, index) in articles.categories"
            :key="cat.id"
            class="inline-block bg-gray-200 rounded px-2 py-0.5 text-xs mx-1"
        >
            {{ cat.name }}
        </span>
    </div>


    <!-- Konten -->
    <div
      class="prose max-w-none prose-img:rounded-lg prose-a:text-blue-600 prose-a:underline hover:prose-a:no-underline"
      v-html="articles.content"
    ></div>
  </div>
  </DetailLayout>
</template>
