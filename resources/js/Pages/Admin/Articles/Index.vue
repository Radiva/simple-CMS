<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { router, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import dayjs from 'dayjs'
import 'dayjs/locale/id'

dayjs.locale('id')

defineProps({
  articles: Object
})

const destroy = (id) => {
  if (confirm('Yakin ingin menghapus artikel ini?')) {
    router.delete(route('admin.artikel.destroy', id))
  }
}
</script>

<template>
  <AdminLayout>
    <div v-if="$page.props.flash.success" class="alert alert-success mb-4">
      {{ $page.props.flash.success }}
    </div>
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Artikel</h1>
      <Link :href="route('admin.artikel.create')" class="btn-primary">+ Tambah Artikel</Link>
    </div>

    <div class="overflow-x-auto">
      <table class="table-auto w-full bg-white rounded shadow text-sm">
        <thead class="bg-gray-100">
          <tr class="text-left">
            <th class="px-4 py-2">Judul</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Dipublikasikan</th>
            <th class="px-4 py-2 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="a in articles.data" :key="a.id" class="border-t hover:bg-gray-50">
            <td class="px-4 py-2">{{ a.title }}</td>
            <td class="px-4 py-2 capitalize">{{ a.status }}</td>
            <td class="px-4 py-2">
              {{ a.published_at ? dayjs(a.published_at).format('D MMMM YYYY HH:mm') : '-' }}
            </td>
            <td class="px-4 py-2 text-right space-x-2">
              <Link
                :href="route('admin.artikel.edit', a.id)"
                class="text-blue-600 hover:underline"
              >Edit</Link>
              <button
                @click="destroy(a.id)"
                class="text-red-600 hover:underline"
              >Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
      <div class="text-sm text-gray-600">
        Halaman {{ articles.current_page }} dari {{ articles.last_page }}
      </div>
      <div class="flex gap-2 mt-2">
        <button
          class="btn"
          :disabled="!articles.prev_page_url"
          @click="router.visit(articles.prev_page_url)"
        >Sebelumnya</button>

        <button
          class="btn"
          :disabled="!articles.next_page_url"
          @click="router.visit(articles.next_page_url)"
        >Berikutnya</button>
      </div>
    </div>
  </AdminLayout>
</template>