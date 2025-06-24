<script setup>
const about = {
  name: 'Radiva Hera',
  role: 'Web Developer & Content Creator',
  bio: `Saya adalah pengembang web yang fokus pada teknologi modern seperti Laravel, Vue, dan pengembangan aplikasi SPA. Selain membangun sistem, saya juga berbagi ilmu melalui berbagai media.`,
  email: 'radiva@example.com',
  socials: [
    { name: 'GitHub', url: 'https://github.com/Radiva' },
    { name: 'LinkedIn', url: 'https://linkedin.com/in/radiva' },
    { name: 'YouTube', url: 'https://youtube.com/@radiva' },
  ]
}
</script>

<template>
  <div class="max-w-4xl mx-auto px-4 text-center">
    <!-- Foto -->
    <img
      src="/profile.png"
      alt="Foto Radiva"
      class="w-32 h-32 mx-auto rounded-full object-cover mb-4 shadow"
    />

    <!-- Nama dan Role -->
    <h2 class="text-2xl font-bold mb-1">{{ about.name }}</h2>
    <p class="text-gray-500 mb-4">{{ about.role }}</p>

    <!-- Bio -->
    <p class="text-gray-700 max-w-xl mx-auto leading-relaxed">{{ about.bio }}</p>

    <!-- Sosial Media -->
    <div class="flex justify-center gap-4 mt-6">
      <a
        v-for="s in about.socials"
        :key="s.name"
        :href="s.url"
        target="_blank"
        class="text-blue-600 hover:underline"
      >
        {{ s.name }}
      </a>
    </div>
  </div>
</template>
