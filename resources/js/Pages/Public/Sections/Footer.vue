<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const form = useForm({
  name: '',
  email: '',
  message: ''
})

const successMessage = ref(null)

const submit = () => {
  form.post(route('contact.store'), {
    preserveScroll: true,
    onSuccess: () => {
      successMessage.value = 'Pesan berhasil dikirim!'
      form.reset()
    }
  })
}

const contact = {
  name: 'Radiva Hera',
  email: 'radiva@example.com',
  socials: [
    { name: 'GitHub', url: 'https://github.com/radiva' },
    { name: 'LinkedIn', url: 'https://linkedin.com/in/radiva' },
    { name: 'YouTube', url: 'https://youtube.com/@radiva' },
  ]
}
</script>

<template>
  <div class="max-w-xl mx-auto px-4">
    <h2 class="text-2xl font-bold text-center mb-6">Hubungi Saya</h2>

    <div v-if="successMessage" class="mb-4 text-green-600 text-center">
      {{ successMessage }}
    </div>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block text-sm font-medium">Nama Lengkap</label>
        <input
          v-model="form.name"
          type="text"
          class="input w-full"
          placeholder="Nama lengkap"
        />
        <div v-if="form.errors.name" class="text-red-600 text-sm">{{ form.errors.name }}</div>
      </div>

      <div>
        <label class="block text-sm font-medium">Email</label>
        <input
          v-model="form.email"
          type="email"
          class="input w-full"
          placeholder="Email aktif"
        />
        <div v-if="form.errors.email" class="text-red-600 text-sm">{{ form.errors.email }}</div>
      </div>

      <div>
        <label class="block text-sm font-medium">Pesan</label>
        <textarea
          v-model="form.message"
          class="input w-full"
          rows="4"
          placeholder="Tulis pesanmu..."
        ></textarea>
        <div v-if="form.errors.message" class="text-red-600 text-sm">{{ form.errors.message }}</div>
      </div>

      <div class="text-center">
        <button type="submit" class="btn-primary">Kirim Pesan</button>
      </div>
    </form>
  </div>

  <footer class="bg-gray-100 border-t py-6 mt-12">
    <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-gray-600">
      <!-- Kiri -->
      <div class="text-center md:text-left">
        &copy; {{ new Date().getFullYear() }} {{ contact.name }}. All rights reserved.
      </div>

      <!-- Kanan -->
      <div class="flex items-center gap-4">
        <a
          :href="`mailto:${contact.email}`"
          class="hover:underline text-blue-600"
        >
          {{ contact.email }}
        </a>
        <span class="hidden md:inline">|</span>
        <div class="flex gap-3">
          <a
            v-for="s in contact.socials"
            :key="s.name"
            :href="s.url"
            target="_blank"
            class="hover:underline text-blue-600"
          >
            {{ s.name }}
          </a>
        </div>
      </div>
    </div>
  </footer>
</template>
