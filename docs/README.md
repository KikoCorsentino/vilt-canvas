# VILT Canvas

A modern Laravel application skeleton built with the VILT stack (Vue, Inertia, Laravel, Tailwind) featuring authentication, profile management, and a comprehensive component library.

## Project Overview

VILT Canvas is a production-ready starter template that combines the power of Laravel 12 with modern frontend technologies. It provides a solid foundation for building scalable single-page applications with a beautiful, accessible UI and robust authentication system.

## Tech Stack

### Backend
- **Laravel 12** - The latest version of the Laravel PHP framework with streamlined structure
- **Laravel Fortify** - Headless authentication backend providing all authentication features
- **Laravel Wayfinder** - Type-safe routing between Laravel and TypeScript
- **Pest** - Modern PHP testing framework with expressive syntax

### Frontend
- **Vue 3** - Progressive JavaScript framework with Composition API
- **Inertia.js 2** - Modern monolith approach, creating SPA-like experiences without API complexity
- **Tailwind CSS 4** - Utility-first CSS framework with oklch color system
- **TypeScript** - Type-safe JavaScript for better developer experience

### Development Tools
- **Vite** - Next-generation frontend build tool
- **Laravel Pint** - Opinionated PHP code style fixer
- **Laravel Boost** - Enhanced development experience with MCP integration

## Features

### Authentication
- User registration with email verification
- Login and logout
- Password reset via email
- Email verification
- Two-factor authentication (2FA) with QR codes and recovery codes
- Password confirmation for sensitive actions

### Profile Management
- Update profile information (name, email)
- Change password
- Enable/disable two-factor authentication
- Account deletion with password confirmation

### UI/UX Features
- **Centralized Color System** - HSL-based color system with oklch support for consistent theming
- **Dark Mode Support** - Full dark mode implementation with smooth transitions
- **Multiple Layout Options** - Header-based and sidebar-based navigation layouts
- **Reusable Components** - Comprehensive component library (buttons, inputs, modals, alerts, etc.)
- **Responsive Design** - Mobile-first approach with Tailwind CSS
- **Accessibility** - WCAG-compliant components with proper ARIA attributes

### Developer Experience
- Type-safe routing with Wayfinder
- Vue 3 Composition API with composables
- Comprehensive test suite with Pest
- Hot module replacement with Vite
- Code formatting with Pint

## Project Structure

```
vilt-canvas/
├── app/
│   ├── Actions/Fortify/      # Fortify authentication actions
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   └── Middleware/       # Custom middleware
│   ├── Models/               # Eloquent models
│   └── Providers/           # Service providers
├── bootstrap/
│   └── app.php              # Application bootstrap (Laravel 12 structure)
├── config/                  # Configuration files
├── database/
│   ├── factories/           # Model factories
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── docs/                    # Documentation (this directory)
├── resources/
│   ├── css/
│   │   └── app.css         # Tailwind CSS with color system
│   └── js/
│       ├── Components/     # Reusable Vue components
│       ├── Layouts/        # Page layouts
│       ├── Pages/          # Inertia page components
│       ├── composables/    # Vue composables
│       ├── routes/         # Auto-generated Wayfinder routes
│       └── actions/       # Auto-generated Wayfinder actions
├── routes/
│   ├── web.php            # Web routes
│   ├── api.php            # API routes
│   └── console.php        # Console routes
└── tests/
    ├── Feature/           # Feature tests
    └── Unit/             # Unit tests
```

## Quick Start

1. **Clone the repository**
   ```bash
   git clone https://github.com/KikoCorsentino/vilt-canvas.git
   cd vilt-canvas
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set up database**
   ```bash
   php artisan migrate
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start development server**
   ```bash
   composer run dev
   ```

For detailed installation instructions, see [INSTALLATION.md](./INSTALLATION.md).

## Documentation

- **[Installation Guide](./INSTALLATION.md)** - Detailed setup instructions and troubleshooting
- **[Testing Guide](./TESTING.md)** - How to run and write tests
- **[Components Documentation](./COMPONENTS.md)** - Complete component reference
- **[Color System](./COLOR-SYSTEM.md)** - Understanding and customizing the color system

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Author

**Kiko Corsentino**

- GitHub: [@KikoCorsentino](https://github.com/KikoCorsentino)
- Website: [corsentino.net](https://corsentino.net)

