<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  contacts: Array,
})

const deleteContact = (id) => {
  if (confirm('Yakin ingin menghapus pesan ini?')) {
    router.delete(route('admin.kontak.destroy', id))
  }
}
</script>

<template>
  <AdminLayout>
    <div v-if="$page.props.flash.success" class="alert alert-success mb-4">
      {{ $page.props.flash.success }}
    </div>
    <div class="max-w-5xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">Pesan Masuk</h1>

      <div v-if="contacts.length === 0" class="text-gray-500">Tidak ada Pesan.</div>

      <table class="w-full text-sm table-auto border">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="p-2">Waktu</th>
            <th class="p-2">Nama</th>
            <th class="p-2">Email</th>
            <th class="p-2">Isi</th>
            <th class="p-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="pesan in contacts" :key="pesan.id" class="border-t">
            <td class="p-2 font-semibold">{{ pesan.created_at }}</td>
            <td class="p-2 font-semibold">{{ pesan.name }}</td>
            <td class="p-2 whitespace-pre-line">{{ pesan.email }}</td>
            <td class="p-2 capitalize">{{ pesan.message }}</td>
            <td class="p-2 flex gap-2">
              <button
                class="btn-sm bg-red-500 text-white"
                @click="deleteContact(pesan.id)"
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
