<script setup>
import { Link, usePage, router } from '@inertiajs/vue3'
const page = usePage()
const user = page.props.auth.user
const role = page.props.role

const menus = [
  { label: 'Dashboard', to: route('admin.dashboard'), roles: ['admin', 'editor'] },
  { label: 'Artikel', to: route('admin.artikel.index'), roles: ['admin', 'editor'] },
  { label: 'Portofolio', to: route('admin.portofolio.index'), roles: ['admin', 'editor'] },
  { label: 'Kategori', to: route('admin.kategori.index'), roles: ['admin'] },
  { label: 'Komentar', to: route('admin.komentar.index'), roles: ['admin'] },
]

const logout = () => {
  router.post(route('logout'))
}
</script>

<template>
  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white p-4">
      <h2 class="text-lg font-bold mb-6">CMS Admin</h2>
      <nav class="space-y-2">
        <Link
          v-for="menu in menus.filter(m => m.roles.includes(role))"
          :key="menu.to"
          :href="menu.to"
          class="block px-2 py-1 rounded hover:bg-gray-700"
        >
          {{ menu.label }}
        </Link>
      </nav>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col">
      <!-- Header Topbar -->
      <header class="flex items-center justify-between px-6 py-4 bg-white shadow border-b">
        <div class="text-sm text-gray-600">
          Masuk sebagai: <strong>{{ user.name }}</strong> ({{ role }})
        </div>
        <div class="flex items-center gap-4">
          <Link href="/profile" class="text-blue-600 hover:underline text-sm">Profil</Link>
          <button @click="logout" class="text-red-600 hover:underline text-sm">Logout</button>
        </div>
      </header>

      <!-- Page Content -->
      <main class="p-6 overflow-y-auto bg-gray-50 flex-1">
        <slot />
      </main>
    </div>
  </div>
</template>
