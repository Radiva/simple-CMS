<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({ links: Array })
const links = ref([...props.links])

const addRow = () => {
  links.value.push({
    id: null,
    title: '',
    url: '',
    icon: '',
    order: links.value.length + 1,
  })
}

const submit = () => {
  router.post(route('admin.tautan.bulk-save'), { links: links.value }, {
    preserveScroll: true
  })
}

const destroy = (id) => {
  if (!id) {
    links.value = links.value.filter(l => l.id !== null)
    return
  }

  if (confirm('Hapus tautan ini?')) {
    router.delete(route('admin.tautan.destroy', id), {
      onSuccess: () => {
        links.value = links.value.filter(l => l.id !== id)
      }
    })
  }
}
</script>

<template>
  <AdminLayout>
    <div class="max-w-4xl mx-auto py-8">
      <h1 class="text-2xl font-bold mb-6">Manajemen Tautan</h1>

      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-12 gap-4 font-semibold border-b pb-2">
          <div class="col-span-1">#</div>
          <div class="col-span-3">Judul</div>
          <div class="col-span-4">URL</div>
          <div class="col-span-2">Icon</div>
          <div class="col-span-1">Urutan</div>
          <div class="col-span-1">Aksi</div>
        </div>

        <div
          v-for="(link, i) in links"
          :key="link.id"
          class="grid grid-cols-12 gap-4 items-center border-b py-2"
        >
          <div class="col-span-1">{{ i + 1 }}</div>
          <div class="col-span-3">
            <input v-model="link.title" class="input w-full" />
          </div>
          <div class="col-span-4">
            <input v-model="link.url" class="input w-full" />
          </div>
          <div class="col-span-2">
            <input v-model="link.icon" class="input w-full" />
          </div>
          <div class="col-span-1">
            <input v-model="link.order" type="number" class="input w-full text-center" />
          </div>
          <div class="col-span-1">
            <button
              type="button"
              @click="destroy(link.id)"
              class="text-red-600 hover:underline text-sm"
            >
              Hapus
            </button>
          </div>
        </div>

        <div class="mt-6 flex justify-between items-center">
          <button type="submit" class="btn-primary">Simpan Semua</button>
          <button type="button" @click="addRow" class="btn-secondary">+ Tambah Tautan</button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>
