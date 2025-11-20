# VILT Canvas

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![Vue](https://img.shields.io/badge/Vue-3.x-4FC08D.svg)](https://vuejs.org)
[![Inertia](https://img.shields.io/badge/Inertia-2.x-9553E9.svg)](https://inertiajs.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.x-38B2AC.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

> A modern Laravel application skeleton built with the VILT stack (Vue, Inertia, Laravel, Tailwind) featuring authentication, profile management, and a comprehensive component library.

## 🚀 Quick Start

```bash
# Clone the repository
git clone https://github.com/KikoCorsentino/vilt-canvas.git
cd vilt-canvas

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Set up database (SQLite by default)
php artisan migrate

# Build assets
npm run build

# Start development server
composer run dev
```

Visit `http://localhost:8000` or `https://vilt-canvas.test` (with Laravel Herd).

For detailed installation instructions, see [docs/INSTALLATION.md](./docs/INSTALLATION.md).

## ✨ Features

### 🔐 Authentication
- User registration with email verification
- Login and logout
- Password reset via email
- Two-factor authentication (2FA) with QR codes
- Password confirmation for sensitive actions

### 👤 Profile Management
- Update profile information
- Change password
- Enable/disable two-factor authentication
- Account deletion

### 🎨 UI/UX
- **Centralized Color System** - HSL-based with oklch support
- **Dark Mode** - Full dark mode with smooth transitions
- **Multiple Layouts** - Header and sidebar navigation options
- **Reusable Components** - Comprehensive component library
- **Responsive Design** - Mobile-first approach

### 🛠 Developer Experience
- Type-safe routing with Wayfinder
- Vue 3 Composition API with composables
- Comprehensive test suite with Pest
- Hot module replacement with Vite
- Code formatting with Pint

## 📚 Documentation

Complete documentation is available in the [`/docs`](./docs) directory:

- **[README](./docs/README.md)** - Project overview and tech stack
- **[Installation Guide](./docs/INSTALLATION.md)** - Detailed setup instructions
- **[Testing Guide](./docs/TESTING.md)** - How to run and write tests
- **[Components](./docs/COMPONENTS.md)** - Complete component reference
- **[Composables](./docs/COMPOSABLES.md)** - Vue composables documentation
- **[Color System](./docs/COLOR-SYSTEM.md)** - Understanding and customizing colors
- **[Layouts](./docs/LAYOUTS.md)** - Layout components and usage
- **[Authentication](./docs/AUTHENTICATION.md)** - Fortify integration guide
- **[API Documentation](./docs/API.md)** - API routes and usage

## 🏗 Tech Stack

- **Laravel 12** - PHP framework
- **Vue 3** - JavaScript framework with Composition API
- **Inertia.js 2** - Modern monolith approach
- **Tailwind CSS 4** - Utility-first CSS framework
- **Laravel Fortify** - Headless authentication
- **Laravel Wayfinder** - Type-safe routing
- **Pest** - PHP testing framework
- **Vite** - Frontend build tool

## 📦 Project Structure

```
vilt-canvas/
├── app/                    # Laravel application code
├── bootstrap/              # Application bootstrap
├── config/                 # Configuration files
├── database/              # Migrations, factories, seeders
├── docs/                  # Documentation
├── resources/
│   ├── css/              # Tailwind CSS
│   └── js/
│       ├── Components/   # Reusable Vue components
│       ├── Layouts/      # Page layouts
│       ├── Pages/        # Inertia page components
│       └── composables/  # Vue composables
├── routes/               # Application routes
└── tests/                # Test suite
```

## 🧪 Testing

Run the test suite:

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/Auth/AuthenticationTest.php

# Run with coverage
php artisan test --coverage
```

See [docs/TESTING.md](./docs/TESTING.md) for more information.

## 🎯 Key Features in Detail

### Type-Safe Routing

Routes are automatically generated with Wayfinder:

```vue
<script setup>
import { dashboard, profile } from '@/routes';
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <Link :href="dashboard.url()">Dashboard</Link>
  <Link :href="profile.edit.url()">Profile</Link>
</template>
```

### Reusable Components

```vue
<script setup>
import Button from '@/Components/Button.vue';
import Alert from '@/Components/Alert.vue';
</script>

<template>
  <Button variant="primary" size="big">Click Me</Button>
  <Alert type="success" message="Operation completed!" />
</template>
```

### Composables

```vue
<script setup>
import { useAuth, useForm } from '@/composables';

const { user, isAuthenticated } = useAuth();
const form = useForm({ name: '', email: '' });
</script>
```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines

- Follow existing code conventions
- Write tests for new features
- Update documentation as needed
- Run `vendor/bin/pint` before committing
- Ensure all tests pass

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👤 Author

**Kiko Corsentino**

- GitHub: [@KikoCorsentino](https://github.com/KikoCorsentino)
- Website: [corsentino.net](https://corsentino.net)
- X: [@kikocorsentino](https://x.com/kikocorsentino)
- LinkedIn: [in/kikocorsentino](https://linkedin.com/in/kikocorsentino)

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP framework
- [Vue.js](https://vuejs.org) - The Progressive JavaScript Framework
- [Inertia.js](https://inertiajs.com) - The modern monolith
- [Tailwind CSS](https://tailwindcss.com) - A utility-first CSS framework
- [Laravel Fortify](https://laravel.com/docs/fortify) - Headless authentication
- [Laravel Wayfinder](https://github.com/laravel/wayfinder) - Type-safe routing
- [Pest](https://pestphp.com) - A delightful PHP Testing Framework

---

**Built with ❤️ using the VILT stack**
