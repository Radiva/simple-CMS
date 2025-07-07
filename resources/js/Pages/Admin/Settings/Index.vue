<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  settings: Object,
})

const tabs = ['Site Info', 'Kontak', 'Sosial Media', 'SEO']
const activeTab = ref(tabs[0])

const form = useForm({ ...props.settings })

const submit = () => form.post(route('admin.settings.update'))
</script>

<template>
  <AdminLayout>
    <div class="max-w-4xl mx-auto">
      <h1 class="text-2xl font-bold mb-6">Konfigurasi Situs</h1>

      <div class="flex space-x-4 border-b mb-4">
        <button
          v-for="tab in tabs"
          :key="tab"
          @click="activeTab = tab"
          :class="activeTab === tab ? 'font-bold border-b-2' : 'text-gray-500'"
          class="pb-2"
        >
          {{ tab }}
        </button>
      </div>

      <form @submit.prevent="submit" class="space-y-6">
        <div v-if="activeTab === 'Site Info'">
          <div>
            <label>Nama Situs</label>
            <input v-model="form['site.name']" class="input w-full" />
          </div>
          <div>
            <label>Deskripsi Situs</label>
            <textarea v-model="form['site.description']" class="input w-full" />
          </div>
        </div>

        <div v-if="activeTab === 'Kontak'">
          <div>
            <label>Email</label>
            <input v-model="form['contact.email']" class="input w-full" type="email" />
          </div>
        </div>

        <div v-if="activeTab === 'Sosial Media'">
          <div>
            <label>Instagram</label>
            <input v-model="form['social.instagram']" class="input w-full" />
          </div>
        </div>

        <div v-if="activeTab === 'SEO'">
          <div>
            <label>Meta Title</label>
            <input v-model="form['seo.meta_title']" class="input w-full" />
          </div>
        </div>

        <button class="btn-primary">Simpan Konfigurasi</button>
      </form>
    </div>
  </AdminLayout>
</template>
