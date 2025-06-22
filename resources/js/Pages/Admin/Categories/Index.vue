<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
defineProps({ kategori: Array })

const destroy = (id) => {
  if (confirm('Hapus kategori ini?')) {
    router.delete(route('admin.kategori.destroy', id))
  }
}
</script>

<template>
  <AdminLayout>
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Kategori</h1>
      <Link :href="route('admin.kategori.create')" class="btn-primary">+ Tambah Kategori</Link>
    </div>

    <div class="overflow-x-auto">
      <table class="table-auto w-full bg-white rounded shadow text-sm">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">Nama</th>
            <th class="px-4 py-2 text-left">Slug</th>
            <th class="px-4 py-2 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in kategori" :key="item.id" class="border-t hover:bg-gray-50">
            <td class="px-4 py-2">{{ item.name }}</td>
            <td class="px-4 py-2">{{ item.slug }}</td>
            <td class="px-4 py-2 text-right space-x-2">
              <Link :href="route('admin.kategori.edit', item.id)" class="text-blue-600 hover:underline">Edit</Link>
              <button @click="destroy(item.id)" class="text-red-600 hover:underline">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>
