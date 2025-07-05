<script setup>
import { ref } from 'vue'
import DetailLayout from '../DetailLayout.vue'

const props = defineProps({
  portfolios: Array
})

const selected = ref(null)

const openModal = (item) => {
  selected.value = item
}

const closeModal = () => {
  selected.value = null
}
</script>

<template>
    <DetailLayout>
  <div class="max-w-6xl mx-auto px-4">
    <h1 class="text-3xl font-bold text-center mb-10">Portofolio</h1>

    <!-- Grid -->
    <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-6">
      <div
        v-for="item in portfolios"
        :key="item.id"
        class="bg-white shadow rounded overflow-hidden border hover:shadow-md cursor-pointer transition"
        @click="openModal(item)"
      >
        <img
          v-if="item.image"
          :src="`/storage/${item.image}`"
          alt="Thumbnail"
          class="w-full h-40 object-cover"
        />
        <div class="p-4">
          <h3 class="text-lg font-semibold mb-2">{{ item.title }}</h3>
          <p class="text-sm text-gray-600 line-clamp-2">
            {{ item.description }}
          </p>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div
      v-if="selected"
      class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4"
    >
      <div class="bg-white rounded-lg w-full max-w-3xl shadow-lg relative overflow-y-auto max-h-[90vh]">
        <button
          class="absolute top-2 right-3 text-2xl text-gray-600 hover:text-black"
          @click="closeModal"
        >
          &times;
        </button>

        <div class="p-6 space-y-4">
          <img
            v-if="selected.image"
            :src="`/storage/${selected.image}`"
            alt="Gambar"
            class="w-full rounded-md object-cover max-h-72"
          />

          <h3 class="text-2xl font-bold">{{ selected.title }}</h3>
          <p class="text-gray-700 whitespace-pre-line leading-relaxed">
            {{ selected.description }}
          </p>

          <a
            v-if="selected.project_url"
            :href="selected.project_url"
            target="_blank"
            class="inline-block mt-4 text-blue-600 hover:underline text-sm"
          >
            Kunjungi Proyek →
          </a>
        </div>
      </div>
    </div>
  </div>
  </DetailLayout>
</template>
