# Layouts Documentation

VILT Canvas provides multiple layout components to structure your application pages. Each layout is designed for specific use cases and user states.

## Available Layouts

### 1. AuthenticatedLayout

**Location:** `resources/js/Layouts/AuthenticatedLayout.vue`

**Use Case:** Main layout for authenticated users with header-based navigation.

**Features:**
- Horizontal navigation bar at the top
- User dropdown menu in the header
- Flash message display
- Light/dark mode toggle
- Responsive mobile menu
- Profile and logout links

**When to Use:**
- Dashboard pages
- Profile pages
- Any authenticated user pages
- Pages requiring top navigation

**Example:**
```vue
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />
        
        <template #header>
            <h2 class="font-semibold text-xl text-text-primary">
                Dashboard
            </h2>
        </template>

        <div>
            <!-- Page content -->
        </div>
    </AuthenticatedLayout>
</template>
```

**Slots:**
- `default` - Main page content
- `header` - Optional header section (appears in header bar)

### 2. AuthenticatedSidebarLayout

**Location:** `resources/js/Layouts/AuthenticatedSidebarLayout.vue`

**Use Case:** Alternative layout for authenticated users with sidebar navigation.

**Features:**
- Collapsible sidebar navigation
- Mobile-responsive sidebar with backdrop
- User profile section in sidebar
- Flash message display
- Light/dark mode toggle
- Main content area

**When to Use:**
- Applications with many navigation items
- Dashboard-style applications
- When you prefer sidebar over header navigation
- Complex navigation hierarchies

**Example:**
```vue
<script setup>
import AuthenticatedSidebarLayout from '@/Layouts/AuthenticatedSidebarLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <AuthenticatedSidebarLayout>
        <Head title="Dashboard" />
        
        <template #header>
            <h2 class="font-semibold text-xl text-text-primary">
                Dashboard
            </h2>
        </template>

        <div>
            <!-- Page content -->
        </div>
    </AuthenticatedSidebarLayout>
</template>
```

**Slots:**
- `default` - Main page content
- `header` - Optional header section

### 3. GuestLayout

**Location:** `resources/js/Layouts/GuestLayout.vue`

**Use Case:** Layout for unauthenticated users (login, register, password reset).

**Features:**
- Centered content area
- Application logo
- Flash message display
- Minimal design focused on authentication

**When to Use:**
- Login page
- Registration page
- Password reset pages
- Email verification page
- Any public-facing authentication pages

**Example:**
```vue
<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <GuestLayout>
        <Head title="Login" />
        
        <form>
            <!-- Login form -->
        </form>
    </GuestLayout>
</template>
```

**Slots:**
- `default` - Page content (typically a form)

### 4. AppLayout

**Location:** `resources/js/Layouts/AppLayout.vue`

**Use Case:** General-purpose layout for public pages.

**Features:**
- Header with navigation
- Footer section
- Flash message display
- Light/dark mode toggle
- Responsive design

**When to Use:**
- Public landing pages
- About pages
- Blog pages
- Marketing pages
- Any public-facing content

**Example:**
```vue
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <AppLayout>
        <Head title="About" />
        
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Page content -->
        </div>
    </AppLayout>
</template>
```

**Slots:**
- `default` - Main page content

### 5. ErrorLayout

**Location:** `resources/js/Layouts/ErrorLayout.vue`

**Use Case:** Layout for error pages (404, 403, 500, etc.).

**Features:**
- Centered error message
- Application logo
- Minimal design
- Focus on error information

**When to Use:**
- 404 Not Found pages
- 403 Forbidden pages
- 500 Server Error pages
- 503 Service Unavailable pages

**Example:**
```vue
<script setup>
import ErrorLayout from '@/Layouts/ErrorLayout.vue';
</script>

<template>
    <ErrorLayout>
        <div>
            <h1 class="text-4xl font-bold mb-4">404</h1>
            <p class="text-text-muted">Page not found</p>
        </div>
    </ErrorLayout>
</template>
```

**Slots:**
- `default` - Error content

## Layout Comparison

| Layout | Navigation | Use Case | Auth Required |
|--------|-----------|----------|---------------|
| AuthenticatedLayout | Header | Authenticated pages | Yes |
| AuthenticatedSidebarLayout | Sidebar | Authenticated pages | Yes |
| GuestLayout | None | Auth pages | No |
| AppLayout | Header + Footer | Public pages | No |
| ErrorLayout | None | Error pages | No |

## Creating Custom Layouts

### Step 1: Create Layout Component

Create a new file in `resources/js/Layouts/`:

```vue
<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import LightDarkButton from '@/Components/LightDarkButton.vue';

const page = usePage();
const flash = computed(() => page.props.flash);
</script>

<template>
    <div class="min-h-screen bg-surface-50 dark:bg-surface-300">
        <!-- Your custom layout structure -->
        <header>
            <!-- Header content -->
        </header>
        
        <main>
            <slot />
        </main>
        
        <footer>
            <!-- Footer content -->
        </footer>
    </div>
</template>
```

### Step 2: Use Your Custom Layout

```vue
<script setup>
import CustomLayout from '@/Layouts/CustomLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <CustomLayout>
        <Head title="My Page" />
        
        <div>
            <!-- Page content -->
        </div>
    </CustomLayout>
</template>
```

### Best Practices

1. **Consistent Structure**
   - Use the same color system classes
   - Include dark mode support
   - Add flash message handling

2. **Accessibility**
   - Use semantic HTML
   - Include proper ARIA labels
   - Ensure keyboard navigation

3. **Responsive Design**
   - Mobile-first approach
   - Test on different screen sizes
   - Use Tailwind responsive classes

4. **Performance**
   - Lazy load heavy components
   - Optimize images
   - Minimize JavaScript

## Switching Between Layouts

### Programmatic Switching

You can switch layouts dynamically based on user preferences:

```vue
<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AuthenticatedSidebarLayout from '@/Layouts/AuthenticatedSidebarLayout.vue';

const layoutType = ref('header'); // or 'sidebar'

const Layout = computed(() => {
    return layoutType.value === 'sidebar' 
        ? AuthenticatedSidebarLayout 
        : AuthenticatedLayout;
});
</script>

<template>
    <component :is="Layout">
        <!-- Content -->
    </component>
</template>
```

### User Preference Storage

Store layout preference in localStorage:

```vue
<script setup>
import { ref, onMounted } from 'vue';

const layoutType = ref(localStorage.getItem('layout') || 'header');

const switchLayout = (type) => {
    layoutType.value = type;
    localStorage.setItem('layout', type);
};

onMounted(() => {
    const saved = localStorage.getItem('layout');
    if (saved) {
        layoutType.value = saved;
    }
});
</script>
```

## Layout Props

Most layouts accept props through Inertia's shared data. Common props include:

- `auth` - Authenticated user data
- `flash` - Flash messages
- `errors` - Validation errors

Access these in layouts:

```vue
<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const auth = computed(() => page.props.auth);
const flash = computed(() => page.props.flash);
</script>
```

## Screenshots

> **Note:** Screenshots would be added here showing each layout in action:
> - AuthenticatedLayout header navigation
> - AuthenticatedSidebarLayout sidebar navigation
> - GuestLayout centered form
> - AppLayout with header and footer
> - ErrorLayout error display

## Troubleshooting

### Layout Not Rendering

1. Check import path is correct
2. Ensure layout component exists
3. Verify slot content is provided

### Styles Not Applying

1. Check Tailwind classes are correct
2. Verify dark mode classes if needed
3. Ensure CSS is compiled (`npm run build`)

### Flash Messages Not Showing

1. Check flash data is passed from backend
2. Verify Alert component is imported
3. Ensure flash computed property is correct

## Examples

See the following pages for layout examples:
- `/dashboard` - Uses AuthenticatedLayout
- `/profile` - Uses AuthenticatedLayout
- `/login` - Uses GuestLayout
- `/` - Uses AppLayout (if public)

