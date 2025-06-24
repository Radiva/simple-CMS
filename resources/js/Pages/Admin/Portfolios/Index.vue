<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { router } from '@inertiajs/vue3'
import dayjs from 'dayjs'

const props = defineProps({
  portfolios: Array
})

const handleDelete = (id) => {
  if (confirm('Yakin ingin menghapus portofolio ini?')) {
    router.delete(route('admin.portofolio.destroy', id))
  }
}
</script>

<template>
  <AdminLayout>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Daftar Portofolio</h1>
      <a :href="route('admin.portofolio.create')" class="btn-primary">+ Tambah</a>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
      <table class="min-w-full text-sm">
        <thead>
          <tr class="bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Judul</th>
            <th class="px-4 py-2">URL</th>
            <th class="px-4 py-2">Diterbitkan</th>
            <th class="px-4 py-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in portfolios" :key="item.id" class="border-t">
            <td class="px-4 py-2">{{ index + 1 }}</td>
            <td class="px-4 py-2 font-medium">{{ item.title }}</td>
            <td class="px-4 py-2">
              <a v-if="item.project_url" :href="item.project_url" target="_blank" class="text-blue-600 hover:underline">
                {{ item.project_url }}
              </a>
              <span v-else class="text-gray-400 italic">-</span>
            </td>
            <td class="px-4 py-2">{{ dayjs(item.published_at).format('D MMMM YYYY HH:mm') }}</td>
            <td class="px-4 py-2 space-x-2">
              <a :href="route('admin.portofolio.edit', item.id)" class="text-blue-600 hover:underline">Edit</a>
              <button @click="handleDelete(item.id)" class="text-red-600 hover:underline">Hapus</button>
            </td>
          </tr>
          <tr v-if="portfolios.length === 0">
            <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada data portofolio.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>
