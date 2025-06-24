<script setup>
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
</script>

<template>
  <div>
    <!-- Sticky Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-white shadow z-50">
      <div class="max-w-6xl mx-auto px-4 flex items-center justify-between h-16">
        <div class="font-bold text-lg">MySite</div>
        <div class="space-x-4">
          <a href="#hero" class="hover:underline">Home</a>
          <a href="#about" class="hover:underline">About</a>
          <a href="#portfolio" class="hover:underline">Portfolio</a>
          <a href="#articles" class="hover:underline">Articles</a>
          <a href="#links" class="hover:underline">Tautan</a>
          <a href="#contact" class="hover:underline">Contact</a>
        </div>
      </div>
    </nav>

    <!-- Sections -->
    <main class="pt-20 space-y-24">
      <section id="hero"><Hero /></section>
      <section id="about"><About /></section>
      <section id="portfolio"><Portfolio :portfolios="portfolios" /></section>
      <section id="articles"><Articles :articles="articles" /></section>
      <section id="links"><Links :links="links" /></section>
      <section id="contact"><Footer /></section>
    </main>
  </div>
</template>
