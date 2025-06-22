<script setup>
import { useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

const props = defineProps({
  kategori: Object
})

const isEdit = !!props.kategori

const form = useForm({
  name: props.kategori?.name || '',
})

const submit = () => {
  const url = isEdit
    ? route('admin.kategori.update', props.kategori.id)
    : route('admin.kategori.store')

  form.post(url, {
    preserveScroll: true,
    ...(isEdit && { method: 'put' }),
  })
}
</script>

<template>
  <AdminLayout>
    <div class="max-w-xl mx-auto">
      <h1 class="text-2xl font-bold mb-6">{{ isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}</h1>

      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1">Nama Kategori</label>
          <input v-model="form.name" type="text" class="input w-full" />
          <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
        </div>

        <div>
          <button class="btn-primary" type="submit">{{ isEdit ? 'Update' : 'Simpan' }}</button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>
