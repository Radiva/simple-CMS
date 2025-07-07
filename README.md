# ✨ Personal CMS — Laravel + Vue SPA

A simple and modular CMS built with Laravel 10, Vue 3, Inertia.js, and MySQL, designed for personal branding purposes. This CMS supports content management for articles, portfolio, and user interaction through comments.

![Screenshot: Beranda](./screenshots/homepage.png)
![Screenshot: Admin Dashboard](./screenshots/admin-dashboard.png)

---

## 📦 Features

- ✅ SPA with Inertia.js + Tailwind CSS
- ✅ Authentication (Breeze + optional social login)
- ✅ Role-based access: Admin, Editor, Pengikut
- ✅ Article & Portfolio with category support
- ✅ Modular and reusable component structure
- ✅ Comment system (pending/approved) with admin moderation
- ✅ Contact form & social media footer
- ✅ Responsive public landing page

---

## 🚀 Tech Stack

- **Backend:** Laravel 10, MySQL, Query Builder (no Eloquent)
- **Frontend:** Vue 3, Vite, Inertia.js, Tailwind CSS
- **Editor:** TinyMCE rich-text integration
- **Auth:** Laravel Breeze (with potential OAuth)
- **File Upload:** Standard Laravel storage

---

## ⚙️ Installation

```bash
# Clone project
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name

# Install backend dependencies
composer install

# Install frontend dependencies
npm install

# Copy and configure .env
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Start local dev
php artisan serve
npm run dev
````

---

## 🛂 User Roles

| Role     | Access                                 |
| -------- | -------------------------------------- |
| Admin    | Full control: content, users, comments |
| Editor   | Manage articles & portfolio            |
| Pengikut | Commenting only (after login)          |

---

## 📁 Folder Structure Highlights

```
resources/
  js/
    Layouts/
      AdminLayout.vue
      PublicLayout.vue
    Pages/
      Admin/
        Artikel/
        Portfolio/
        Komentar/
      Public/
        Home.vue
        Artikel/
        Portfolio/
  views/
    welcome.blade.php (optional fallback)
```

---

## 🖼️ Screenshots

### ✅ Landing Page

![Home](./screenshots/homepage.png)

### ✅ Artikel Detail

![Detail Artikel](./screenshots/article-detail.png)

### ✅ Admin Dashboard

![Admin](./screenshots/admin-dashboard.png)

### ✅ Komentar Moderasi

![Komentar](./screenshots/moderasi-komentar.png)

> 📂 Letakkan gambar di folder `public/screenshots` dan pastikan sesuai path saat diakses via browser/dev server.

---

## 🧪 To Do / Roadmap

* [x] Dashboard admin role-based
* [x] Modular component setup
* [x] Artikel dan Portofolio CRUD
* [x] Kategori multi-select
* [x] Comment system with moderation
* [ ] Notifikasi admin untuk komentar masuk
* [ ] OAuth login
* [ ] Dark mode

---

## 🤝 License

This project is open-sourced under the [MIT license](LICENSE).

---

## ✨ Author

Developed by [Your Name](https://yourdomain.com)

```

---

## 📎 Catatan:

- Ganti semua URL (`yourdomain.com`, GitHub repo, screenshot path) sesuai real path kamu.
- Screenshot bisa kamu simpan di `public/screenshots/`, lalu akses dari root saat Live/Dev.
- Bila kamu ingin versi markdown dengan badge CI/CD, deployment, dan GitHub Pages — bisa ditambahkan kemudian.

Ingin saya bantu buatkan file markdown lengkap beserta struktur folder screenshot dummy dan versi `.env.example` juga?
```
