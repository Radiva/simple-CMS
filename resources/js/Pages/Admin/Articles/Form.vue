<script setup>
import { useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

import 'tinymce'
import Editor from "@tinymce/tinymce-vue"

/* Required TinyMCE components */
import 'tinymce/icons/default/icons.min.js';
import 'tinymce/themes/silver/theme.min.js';
import 'tinymce/models/dom/model.min.js';

/* Import a skin (can be a custom skin instead of the default) */
import 'tinymce/skins/ui/oxide/skin.js';

/* Import plugins */
import 'tinymce/plugins/advlist';
import 'tinymce/plugins/code';
import 'tinymce/plugins/emoticons';
import 'tinymce/plugins/emoticons/js/emojis';
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/table';

/* content UI CSS is required */
// import 'tinymce/skins/ui/oxide/content.js';

/* The default content CSS can be changed or replaced with appropriate CSS for the editor content. */
import 'tinymce/skins/content/default/content.js';

const props = defineProps({
  article: Object,
  categories: Array,
  selectedCategories: Array,
})

const isEdit = !!props.article

const form = useForm({
  title: props.article?.title || '',
  content: props.article?.content || '',
  status: props.article?.status || 'draft',
  category_ids: props.selectedCategories || [],
})

const submit = () => {
  const url = isEdit
    ? route('admin.artikel.update', props.article.id)
    : route('admin.artikel.store')

  form.post(url, {
    preserveScroll: true,
    ...(isEdit && { method: 'put' }),
  })
}
</script>

<template>
  <AdminLayout>
    <div class="max-w-3xl mx-auto">
      <h1 class="text-2xl font-bold mb-6">
        {{ isEdit ? 'Edit Artikel' : 'Tambah Artikel' }}
      </h1>

      <form @submit.prevent="submit" class="space-y-6">

        <!-- Judul -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
          <input
            v-model="form.title"
            class="input w-full"
            type="text"
            placeholder="Judul artikel"
          />
          <div v-if="form.errors.title" class="text-sm text-red-600 mt-1">{{ form.errors.title }}</div>
        </div>

        <!-- Konten -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
          <Editor
            license-key="gpt"
            :init="{
              height: 400,
              menubar: false,
              plugins: 'link image code lists table',
              toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | code',
            }"
            v-model="form.content"
          />
          <div v-if="form.errors.content" class="text-sm text-red-600 mt-1">{{ form.errors.content }}</div>
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

        <!-- Status -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <select v-model="form.status" class="input w-full">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
          </select>
        </div>

        <!-- Tombol Submit -->
        <div>
          <button type="submit" class="btn-primary">
            {{ isEdit ? 'Update' : 'Simpan' }}
          </button>
        </div>

      </form>
    </div>
  </AdminLayout>
</template>
