<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import DetailLayout from '../DetailLayout.vue';

const props = defineProps({
  articles: Object,
  comments: Array,
  auth: Object,
})

const komentar = ref({
  nama: '',
  email: '',
  isi: '',
  website: '', // honeypot
  start_time: Date.now(), // time in ms
})

const submitKomentar = () => {
  router.post(route('komentar.store'), {
    content: komentar.isi,
    commentable_type: 'artikel', // atau 'portfolio'
    commentable_id: props.articles.id, // atau portfolio.id
  }, {
    preserveScroll: true,
    onSuccess: () => {
      komentar.isi = ''
    }
  })
}
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
    <!-- Komentar -->
    <div class="mt-10">
      <h3 class="text-lg font-semibold mb-4">Komentar</h3>

      <div v-if="comments.length === 0" class="text-gray-500">Belum ada komentar.</div>

      <ul class="space-y-4">
        <li v-for="komentar in comments" :key="komentar.id" class="border-b pb-2">
          <div class="text-sm font-bold">{{ komentar.user_name }}</div>
          <div class="text-sm text-gray-600 mb-1">
            {{ new Date(komentar.created_at).toLocaleString('id-ID') }}
          </div>
          <p class="text-gray-800">{{ komentar.content }}</p>
        </li>
      </ul>
    </div>

    <div v-if="auth?.user" class="mt-8">
      <form @submit.prevent="submitKomentar" class="space-y-4">
        <input v-model="komentar.nama" class="input w-full" placeholder="Nama lengkap" required />
        <input v-model="komentar.email" class="input w-full" type="email" placeholder="Email (opsional)" />
        <!-- Honeypot field -->
        <div style="display: none;">
            <input v-model="komentar.website" type="text" autocomplete="off" tabindex="-1" />
        </div>
        <!-- Komentar -->
        <textarea v-model="komentar.isi" class="input w-full" rows="3" placeholder="Tulis komentar..." required></textarea>
        <button class="btn-primary" type="submit">Kirim Komentar</button>
      </form>
    </div>
  </div>
  </DetailLayout>
</template>
