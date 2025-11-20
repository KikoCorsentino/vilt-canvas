# Installation Guide

This guide will walk you through installing and setting up VILT Canvas on your local development environment.

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** >= 8.3
- **Composer** >= 2.0
- **Node.js** >= 18.0
- **npm** >= 9.0 (comes with Node.js)
- **Database** (MySQL, PostgreSQL, or SQLite)

### Checking Versions

Verify your installations:

```bash
php -v          # Should be >= 8.3
composer -v     # Should be >= 2.0
node -v         # Should be >= 18.0
npm -v          # Should be >= 9.0
```

## Step-by-Step Installation

### 1. Clone the Repository

```bash
git clone https://github.com/KikoCorsentino/vilt-canvas.git
cd vilt-canvas
```

### 2. Install Composer Dependencies

```bash
composer install
```

This will install all PHP dependencies including Laravel, Inertia, Fortify, and other packages.

### 3. Install npm Dependencies

```bash
npm install
```

This will install all JavaScript dependencies including Vue 3, Inertia.js, Tailwind CSS, and Vite.

### 4. Environment Configuration

Copy the example environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 5. Database Configuration

Open `.env` and configure your database connection:

**For SQLite (default, recommended for development):**
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

**For MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vilt_canvas
DB_USERNAME=root
DB_PASSWORD=
```

**For PostgreSQL:**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=vilt_canvas
DB_USERNAME=postgres
DB_PASSWORD=
```

### 6. Create Database (if not using SQLite)

For MySQL:
```bash
mysql -u root -p
CREATE DATABASE vilt_canvas;
exit
```

For PostgreSQL:
```bash
psql -U postgres
CREATE DATABASE vilt_canvas;
\q
```

### 7. Run Migrations

```bash
php artisan migrate
```

This will create all necessary database tables including users, cache, jobs, and two-factor authentication columns.

### 8. Build Frontend Assets

**For development:**
```bash
npm run dev
```

**For production:**
```bash
npm run build
```

### 9. Start Development Server

**Option 1: Using Composer Script (Recommended)**
```bash
composer run dev
```

This starts:
- Laravel development server
- Queue worker
- Laravel Pail (log viewer)
- Vite dev server

**Option 2: Manual Start**
```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server
npm run dev

# Terminal 3: Queue worker (optional)
php artisan queue:work
```

### 10. Access the Application

Open your browser and navigate to:
- **Local:** http://localhost:8000
- **With Herd:** https://vilt-canvas.test (if using Laravel Herd)

## Quick Setup Script

You can also use the setup script for a one-command installation:

```bash
composer run setup
```

This will:
1. Install Composer dependencies
2. Copy `.env.example` to `.env` (if it doesn't exist)
3. Generate application key
4. Run migrations
5. Install npm dependencies
6. Build frontend assets

## Troubleshooting

### Common Issues and Solutions

#### Issue: "Vite manifest not found"

**Solution:**
```bash
npm run build
# or for development
npm run dev
```

#### Issue: "SQLSTATE[HY000] [2002] No such file or directory"

**Solution:**
- Check your database connection settings in `.env`
- Ensure your database server is running
- Verify database credentials are correct

#### Issue: "Class 'Vite' not found"

**Solution:**
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

#### Issue: "npm ERR! peer dependency missing"

**Solution:**
```bash
rm -rf node_modules package-lock.json
npm install
```

#### Issue: "Route [login] not defined"

**Solution:**
```bash
php artisan wayfinder:generate
```

This regenerates the Wayfinder route files.

#### Issue: "Permission denied" errors

**Solution:**
```bash
# Set proper permissions
chmod -R 775 storage bootstrap/cache
chown -R $USER:www-data storage bootstrap/cache
```

#### Issue: "Memory limit exhausted"

**Solution:**
Increase PHP memory limit in `php.ini`:
```ini
memory_limit = 512M
```

Or temporarily:
```bash
php -d memory_limit=512M artisan migrate
```

### Database Issues

#### SQLite Database Not Found

If using SQLite, ensure the database file exists:
```bash
touch database/database.sqlite
php artisan migrate
```

#### Migration Errors

If migrations fail:
```bash
# Reset database (WARNING: deletes all data)
php artisan migrate:fresh

# Or rollback and re-run
php artisan migrate:rollback
php artisan migrate
```

### Frontend Build Issues

#### Vite Build Fails

```bash
# Clear Vite cache
rm -rf node_modules/.vite
npm run build
```

#### Tailwind Classes Not Working

Ensure your files are included in `resources/css/app.css`:
```css
@source '../**/*.vue';
@source '../**/*.blade.php';
```

### Authentication Issues

#### Fortify Routes Not Working

Check `config/fortify.php` to ensure features are enabled:
```php
'features' => [
    Features::registration(),
    Features::resetPasswords(),
    Features::emailVerification(),
    Features::updateProfileInformation(),
    Features::updatePasswords(),
    Features::twoFactorAuthentication(),
],
```

## Next Steps

After successful installation:

1. **Create a test user** by registering at `/register`
2. **Explore the demo page** at `/demo` (requires authentication)
3. **Check out the components** documentation in [COMPONENTS.md](./COMPONENTS.md)
4. **Customize colors** using [COLOR-SYSTEM.md](./COLOR-SYSTEM.md)
5. **Run tests** following [TESTING.md](./TESTING.md)

## Production Deployment

For production deployment:

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Run `php artisan config:cache`
4. Run `php artisan route:cache`
5. Run `php artisan view:cache`
6. Build assets: `npm run build`
7. Ensure proper file permissions
8. Set up queue workers and scheduled tasks

## Getting Help

If you encounter issues not covered here:

1. Check the [Laravel documentation](https://laravel.com/docs)
2. Review [Inertia.js documentation](https://inertiajs.com)
3. Check [Vue 3 documentation](https://vuejs.org)
4. Open an issue on GitHub

