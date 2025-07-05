<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  comments: Array,
})

const updateStatus = (id, action) => {
  const routeName = action === 'approve' ? 'admin.komentar.approve' : 'admin.komentar.reject'
  router.put(route(routeName, id))
}

const deleteKomentar = (id) => {
  if (confirm('Yakin ingin menghapus komentar ini?')) {
    router.delete(route('admin.komentar.destroy', id))
  }
}
</script>

<template>
  <AdminLayout>
    <div v-if="$page.props.flash.success" class="alert alert-success mb-4">
      {{ $page.props.flash.success }}
    </div>
    <div class="max-w-5xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">Moderasi Komentar</h1>

      <div v-if="comments.length === 0" class="text-gray-500">Tidak ada komentar.</div>

      <table class="w-full text-sm table-auto border">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="p-2">User</th>
            <th class="p-2">Isi</th>
            <th class="p-2">Status</th>
            <th class="p-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="komentar in comments" :key="komentar.id" class="border-t">
            <td class="p-2 font-semibold">{{ komentar.user_name }}</td>
            <td class="p-2 whitespace-pre-line">{{ komentar.content }}</td>
            <td class="p-2 capitalize">{{ komentar.status }}</td>
            <td class="p-2 flex gap-2">
              <button
                class="btn-sm bg-green-500 text-white"
                v-if="komentar.status === 'pending'"
                @click="updateStatus(komentar.id, 'approve')"
              >
                Setujui
              </button>
              <button
                class="btn-sm bg-yellow-500 text-white"
                v-if="komentar.status === 'pending'"
                @click="updateStatus(komentar.id, 'reject')"
              >
                Tolak
              </button>
              <button
                class="btn-sm bg-red-500 text-white"
                @click="deleteKomentar(komentar.id)"
              >
                Hapus
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>
