<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Editor from "@tinymce/tinymce-vue"
import 'tinymce'
import 'tinymce/themes/silver/theme'
import 'tinymce/icons/default'
import 'tinymce/plugins/link'
import 'tinymce/plugins/code'
import 'tinymce/plugins/lists'
import 'tinymce/plugins/table'
import 'tinymce/skins/ui/oxide/skin.js'
import 'tinymce/models/dom';
import 'tinymce/skins/ui/oxide/content.js';
import 'tinymce/skins/content/default/content.js';

const props = defineProps({
  portfolio: Object,
  categories: Array,
  selectedCategories: Array
})

const isEdit = !!props.portfolio
const errorMessage = ref('')

const form = useForm({
  title: props.portfolio?.title || '',
  description: props.portfolio?.description || '',
  image: null,
  project_url: props.portfolio?.project_url || '',
  category_ids: props.selectedCategories || []
})

watch(() => form.title, (newTitle) => {
  if (!isEdit) {
    form.slug = newTitle.toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]+/g, '')
  }
})

const submit = () => {
  const url = isEdit
    ? route('admin.portofolio.update', props.portfolio.id)
    : route('admin.portofolio.store')

  form.post(url, {
    preserveScroll: true,
    forceFormData: true,
    ...(isEdit && { method: 'put' }),
    onError: (errors) => {
      if (Object.keys(errors).length === 0) {
        errorMessage.value = 'Gagal menyimpan data.'
      }
    }
  })
}
</script>

<template>
  <AdminLayout>
    <div v-if="errorMessage" class="alert alert-error mb-4">
      {{ errorMessage }}
    </div>

    <div class="max-w-3xl mx-auto">
      <h1 class="text-2xl font-bold mb-6">
        {{ isEdit ? 'Edit Portofolio' : 'Tambah Portofolio' }}
      </h1>

      <form @submit.prevent="submit" class="space-y-6">

        <!-- Judul -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
          <input
            v-model="form.title"
            type="text"
            class="input w-full"
            placeholder="Judul portofolio"
          />
          <div v-if="form.errors.title" class="text-sm text-red-600 mt-1">{{ form.errors.title }}</div>
        </div>

        <!-- Deskripsi -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
          <Editor
            license-key="gpl"
            :init="{
              height: 300,
              // menubar: false,
              plugins: 'link code lists table codesample',
              promotion: false,
              // toolbar: 'undo redo | bold italic underline | bullist numlist | code codesample',
            }"
            v-model="form.description"
          />
          <div v-if="form.errors.description" class="text-sm text-red-600 mt-1">{{ form.errors.description }}</div>
        </div>

        <!-- Gambar -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Gambar (opsional)</label>
          <input
            type="file"
            @change="e => form.image = e.target.files[0]"
            accept="image/*"
            class="input"
          />
          <div v-if="form.errors.image" class="text-sm text-red-600 mt-1">{{ form.errors.image }}</div>
          <div v-if="props.portfolio?.image" class="mt-2">
            <img :src="`/storage/${props.portfolio.image}`" alt="Preview" class="h-24 rounded" />
          </div>
        </div>

        <!-- Link Proyek -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Link Proyek</label>
          <input
            v-model="form.project_url"
            type="url"
            class="input w-full"
            placeholder="https://contoh-proyek.com"
          />
          <div v-if="form.errors.project_url" class="text-sm text-red-600 mt-1">{{ form.errors.project_url }}</div>
        </div>

        <!-- Kategori -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
          <div class="flex flex-wrap gap-3">
            <label
              v-for="cat in categories"
              :key="cat.id"
              class="flex items-center space-x-2"
            >
              <input
                type="checkbox"
                :value="cat.id"
                v-model="form.category_ids"
                class="rounded border-gray-300"
              />
              <span>{{ cat.name }}</span>
            </label>
          </div>
        </div>

        <!-- Tombol -->
        <div class="pt-4">
          <button type="submit" class="btn-primary">
            {{ isEdit ? 'Update' : 'Simpan' }}
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>
