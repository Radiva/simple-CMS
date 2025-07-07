<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import Hero from './Sections/Hero.vue'
import About from './Sections/About.vue'
import Portfolio from './Sections/Portfolios.vue'
import Articles from './Sections/Articles.vue'
import Links from './Sections/Links.vue'
import Footer from './Sections/Footer.vue'


const props = defineProps({
  portfolios: Array,
  articles: Array
})

const { globalSettings } = usePage().props

const menuOpen = ref(false)

const navItems = [
  { label: 'Home', href: '#hero' },
  { label: 'About', href: '#about' },
  { label: 'Portfolio', href: '#portfolio' },
  { label: 'Articles', href: '#articles' },
  { label: 'Tautan', href: '#links' },
  { label: 'Contact', href: '#contact' },
]

</script>

<template>
  <div>
    <!-- Sticky Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-white shadow z-50">
      <div class="max-w-6xl mx-auto px-4 flex items-center justify-between h-16">
        <!-- Logo / Site Name -->
        <div class="font-bold text-lg">{{ globalSettings.site_name }}</div>

        <!-- Burger Button (mobile) -->
        <button @click="menuOpen = !menuOpen" class="md:hidden focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              v-if="!menuOpen"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            />
            <path
              v-else
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>

        <!-- Menu (desktop) -->
        <div class="hidden md:flex space-x-4">
          <a v-for="item in navItems" :key="item.href" :href="item.href" class="hover:underline">
            {{ item.label }}
          </a>
        </div>
      </div>

      <!-- Menu (mobile dropdown) -->
      <div v-if="menuOpen" class="md:hidden bg-white shadow px-4 pb-4 space-y-2">
        <a
          v-for="item in navItems"
          :key="item.href"
          :href="item.href"
          @click="menuOpen = false"
          class="block py-2 border-b text-gray-700 hover:text-blue-600"
        >
          {{ item.label }}
        </a>
      </div>
    </nav>

    <!-- Sections -->
    <main class="pt-20 space-y-24">
      <section id="hero" class="scroll-mt-20"><Hero /></section>
      <section id="about" class="scroll-mt-20"><About /></section>
      <section id="portfolio" class="scroll-mt-20"><Portfolio :portfolios="portfolios" /></section>
      <section id="articles" class="scroll-mt-20"><Articles :articles="articles" /></section>
      <section id="links" class="scroll-mt-20"><Links :links="links" /></section>
      <section id="contact"><Footer /></section>
    </main>
  </div>
</template>
