# Composables Documentation

VILT Canvas provides a collection of Vue 3 composables that encapsulate common functionality and make it easy to build reactive, maintainable components.

## Table of Contents

- [useAuth](#useauth)
- [useFlash](#useflash)
- [useForm](#useform)
- [useModal](#usemodal)
- [useRoute](#useroute)

## useAuth

Provides authentication state and logout functionality.

### API Reference

```typescript
function useAuth(): {
  user: ComputedRef<User | null>;
  isAuthenticated: ComputedRef<boolean>;
  logout: () => void;
}
```

### Returns

| Property | Type | Description |
|----------|------|-------------|
| `user` | `ComputedRef<User \| null>` | Current authenticated user object or null |
| `isAuthenticated` | `ComputedRef<boolean>` | Whether a user is currently authenticated |
| `logout` | `() => void` | Function to log out the current user |

### Usage Examples

**Basic Usage:**
```vue
<script setup>
import { useAuth } from '@/composables';

const { user, isAuthenticated, logout } = useAuth();
</script>

<template>
  <div v-if="isAuthenticated">
    <p>Welcome, {{ user.name }}!</p>
    <button @click="logout">Logout</button>
  </div>
  <div v-else>
    <p>Please log in</p>
  </div>
</template>
```

**Conditional Rendering:**
```vue
<script setup>
import { useAuth } from '@/composables';

const { user, isAuthenticated } = useAuth();
</script>

<template>
  <nav>
    <template v-if="isAuthenticated">
      <a href="/dashboard">Dashboard</a>
      <a href="/profile">Profile</a>
    </template>
    <template v-else>
      <a href="/login">Login</a>
      <a href="/register">Register</a>
    </template>
  </nav>
</template>
```

**Accessing User Properties:**
```vue
<script setup>
import { useAuth } from '@/composables';

const { user } = useAuth();

// Access user properties
const userName = computed(() => user.value?.name ?? 'Guest');
const userEmail = computed(() => user.value?.email ?? '');
</script>
```

## useFlash

Manages flash messages (success, error, warning, info) from the server.

### API Reference

```typescript
function useFlash(): {
  flash: ComputedRef<FlashMessages>;
  success: ComputedRef<string | null>;
  error: ComputedRef<string | null>;
  warning: ComputedRef<string | null>;
  info: ComputedRef<string | null>;
  clearFlash: () => void;
  setSuccess: (message: string) => void;
  setError: (message: string) => void;
  setWarning: (message: string) => void;
  setInfo: (message: string) => void;
}
```

### Returns

| Property | Type | Description |
|----------|------|-------------|
| `flash` | `ComputedRef<FlashMessages>` | Complete flash messages object |
| `success` | `ComputedRef<string \| null>` | Success message or null |
| `error` | `ComputedRef<string \| null>` | Error message or null |
| `warning` | `ComputedRef<string \| null>` | Warning message or null |
| `info` | `ComputedRef<string \| null>` | Info message or null |
| `clearFlash` | `() => void` | Clear all flash messages |
| `setSuccess` | `(message: string) => void` | Set success message |
| `setError` | `(message: string) => void` | Set error message |
| `setWarning` | `(message: string) => void` | Set warning message |
| `setInfo` | `(message: string) => void` | Set info message |

### Usage Examples

**Displaying Flash Messages:**
```vue
<script setup>
import { useFlash } from '@/composables';
import Alert from '@/Components/Alert.vue';

const { success, error, warning, info } = useFlash();
</script>

<template>
  <Alert v-if="success" type="success" :message="success" />
  <Alert v-if="error" type="error" :message="error" />
  <Alert v-if="warning" type="warning" :message="warning" />
  <Alert v-if="info" type="info" :message="info" />
</template>
```

**Clearing Flash Messages:**
```vue
<script setup>
import { useFlash } from '@/composables';

const { clearFlash } = useFlash();

const handleDismiss = () => {
  clearFlash();
};
</script>
```

**Note:** Flash messages are typically set server-side. The `set*` methods are available but require server-side support to persist.

## useForm

Enhanced form composable that wraps Inertia's `useForm` with additional helper methods.

### API Reference

```typescript
function useForm(
  initialData?: Record<string, any>,
  options?: {
    preserveScroll?: boolean;
    resetOnSuccess?: boolean;
    resetFields?: string[];
  }
): FormInstance
```

### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `initialData` | `Record<string, any>` | `{}` | Initial form data |
| `options.preserveScroll` | `boolean` | `true` | Preserve scroll position on submit |
| `options.resetOnSuccess` | `boolean` | `false` | Reset form on successful submission |
| `options.resetFields` | `string[]` | `[]` | Specific fields to reset on success |

### Returns

All properties and methods from Inertia's `useForm`, plus:

| Method | Type | Description |
|--------|------|-------------|
| `submit` | `(method, url, options?) => void` | Enhanced submit with method selection |
| `hasError` | `(field: string) => boolean` | Check if field has error |
| `getError` | `(field: string) => string \| null` | Get error message for field |
| `clearErrors` | `() => void` | Clear all errors |
| `clearError` | `(field: string) => void` | Clear error for specific field |
| `setError` | `(field: string, message: string) => void` | Set error for field |
| `hasErrors` | `() => boolean` | Check if form has any errors |
| `isDirty` | `() => boolean` | Check if form has been modified |
| `reset` | `(...fields: string[]) => void` | Reset form to initial values |

### Usage Examples

**Basic Form:**
```vue
<script setup>
import { useForm } from '@/composables';
import { store } from '@/actions/UserController';

const form = useForm({
  name: '',
  email: '',
});

const submit = () => {
  form.post(store());
};
</script>

<template>
  <form @submit.prevent="submit">
    <input v-model="form.name" />
    <input v-model="form.email" />
    <button type="submit" :disabled="form.processing">
      Submit
    </button>
  </form>
</template>
```

**With Auto-Reset:**
```vue
<script setup>
import { useForm } from '@/composables';

const form = useForm({
  password: '',
  password_confirmation: '',
}, {
  resetOnSuccess: true,
  resetFields: ['password', 'password_confirmation'],
});

const submit = () => {
  form.put('/user/password');
};
</script>
```

**Error Handling:**
```vue
<script setup>
import { useForm } from '@/composables';

const form = useForm({
  email: '',
});

const submit = () => {
  form.post('/users', {
    onError: () => {
      if (form.hasError('email')) {
        console.log('Email error:', form.getError('email'));
      }
    },
  });
};
</script>
```

**Using Enhanced Submit:**
```vue
<script setup>
import { useForm } from '@/composables';

const form = useForm({
  name: '',
});

const submit = () => {
  // Automatically uses correct HTTP method
  form.submit('post', '/users', {
    onSuccess: () => {
      console.log('User created!');
    },
  });
};
</script>
```

## useModal

Manages modal open/close state.

### API Reference

```typescript
function useModal(initialState?: boolean): {
  isOpen: Ref<boolean>;
  open: () => void;
  close: () => void;
  toggle: () => void;
}
```

### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `initialState` | `boolean` | `false` | Initial open state |

### Returns

| Property | Type | Description |
|----------|------|-------------|
| `isOpen` | `Ref<boolean>` | Whether modal is open |
| `open` | `() => void` | Open the modal |
| `close` | `() => void` | Close the modal |
| `toggle` | `() => void` | Toggle modal state |

### Usage Examples

**Basic Modal:**
```vue
<script setup>
import { useModal } from '@/composables';
import Modal from '@/Components/Modal.vue';

const { isOpen, open, close } = useModal();
</script>

<template>
  <button @click="open">Open Modal</button>
  
  <Modal :show="isOpen" @close="close">
    <h2>Modal Title</h2>
    <p>Modal content</p>
    <button @click="close">Close</button>
  </Modal>
</template>
```

**Toggle Modal:**
```vue
<script setup>
import { useModal } from '@/composables';

const { isOpen, toggle } = useModal();
</script>

<template>
  <button @click="toggle">
    {{ isOpen ? 'Close' : 'Open' }} Modal
  </button>
</template>
```

**Multiple Modals:**
```vue
<script setup>
import { useModal } from '@/composables';

const deleteModal = useModal();
const editModal = useModal();
</script>

<template>
  <button @click="deleteModal.open">Delete</button>
  <button @click="editModal.open">Edit</button>
</template>
```

## useRoute

Provides utilities for working with Wayfinder routes.

### API Reference

```typescript
function useRoute(): {
  route: (name: string, options?: RouteOptions) => string;
  current: (name: string) => boolean;
  has: (name: string) => boolean;
  visit: (name: string, options?: VisitOptions) => void;
  currentRouteName: ComputedRef<string | null>;
  currentUrl: ComputedRef<string>;
}
```

### Returns

| Property | Type | Description |
|----------|------|-------------|
| `route` | `(name, options?) => string` | Generate URL for a route |
| `current` | `(name: string) => boolean` | Check if current route matches name |
| `has` | `(name: string) => boolean` | Check if route exists |
| `visit` | `(name, options?) => void` | Visit a route using Inertia |
| `currentRouteName` | `ComputedRef<string \| null>` | Current route name |
| `currentUrl` | `ComputedRef<string>` | Current URL path |

### Usage Examples

**Generate URLs:**
```vue
<script setup>
import { useRoute } from '@/composables';

const { route } = useRoute();

const loginUrl = route('login');
const dashboardUrl = route('dashboard', { query: { page: 1 } });
</script>
```

**Check Current Route:**
```vue
<script setup>
import { useRoute } from '@/composables';

const { current } = useRoute();

const isDashboard = computed(() => current('dashboard'));
</script>

<template>
  <nav>
    <a :class="{ active: isDashboard }" href="/dashboard">
      Dashboard
    </a>
  </nav>
</template>
```

**Programmatic Navigation:**
```vue
<script setup>
import { useRoute } from '@/composables';

const { visit } = useRoute();

const goToDashboard = () => {
  visit('dashboard', { preserveState: true });
};
</script>
```

**Route Existence Check:**
```vue
<script setup>
import { useRoute } from '@/composables';

const { has } = useRoute();

if (has('admin')) {
  // Admin route exists
}
</script>
```

**Note:** For nested routes (e.g., `@/routes/profile`), import them directly:
```vue
<script setup>
import { edit as profileEdit } from '@/routes/profile';

const url = profileEdit.url();
</script>
```

## Best Practices

### 1. Import from Index

Always import composables from the index file:

```vue
// ✅ Good
import { useAuth, useFlash, useForm } from '@/composables';

// ❌ Bad
import { useAuth } from '@/composables/useAuth';
```

### 2. Use Computed Properties

When accessing reactive values, use computed properties:

```vue
<script setup>
import { useAuth } from '@/composables';

const { user } = useAuth();

// ✅ Good
const userName = computed(() => user.value?.name ?? 'Guest');

// ❌ Bad (in template)
{{ user?.name ?? 'Guest' }} // Works but not reactive
</script>
```

### 3. Destructure Responsibly

Only destructure what you need:

```vue
<script setup>
// ✅ Good - only what you need
const { user, isAuthenticated } = useAuth();

// ❌ Bad - unnecessary destructuring
const { user, isAuthenticated, logout } = useAuth();
// (if you don't use logout)
</script>
```

### 4. Combine Composables

Composables work well together:

```vue
<script setup>
import { useAuth, useForm } from '@/composables';

const { user } = useAuth();
const form = useForm({
  name: user.value?.name ?? '',
  email: user.value?.email ?? '',
});
</script>
```

### 5. Type Safety

While JavaScript, you can add JSDoc for better IDE support:

```vue
<script setup>
/**
 * @typedef {Object} User
 * @property {number} id
 * @property {string} name
 * @property {string} email
 */

import { useAuth } from '@/composables';

const { user } = useAuth();
// user.value is now typed as User | null
</script>
```

## Creating New Composables

### Structure

```javascript
import { ref, computed } from 'vue';

/**
 * Composable description
 * 
 * @returns {Object} Composable return object
 * @returns {Ref|ComputedRef} property - Property description
 * @returns {Function} method - Method description
 * 
 * @example
 * const { property, method } = useMyComposable();
 */
export function useMyComposable() {
    // State
    const state = ref(initialValue);
    
    // Computed
    const computedValue = computed(() => {
        return state.value * 2;
    });
    
    // Methods
    const method = () => {
        // Implementation
    };
    
    return {
        state,
        computedValue,
        method,
    };
}
```

### Example: useCounter

```javascript
import { ref } from 'vue';

/**
 * Simple counter composable
 * 
 * @param {number} initialValue - Initial counter value
 * @returns {Object} Counter composable
 * @returns {Ref<number>} count - Current count
 * @returns {Function} increment - Increment count
 * @returns {Function} decrement - Decrement count
 * @returns {Function} reset - Reset to initial value
 */
export function useCounter(initialValue = 0) {
    const count = ref(initialValue);
    
    const increment = () => {
        count.value++;
    };
    
    const decrement = () => {
        count.value--;
    };
    
    const reset = () => {
        count.value = initialValue;
    };
    
    return {
        count,
        increment,
        decrement,
        reset,
    };
}
```

### Export from Index

Add to `resources/js/composables/index.js`:

```javascript
export { useMyComposable } from './useMyComposable';
```

## Additional Resources

- [Vue 3 Composition API](https://vuejs.org/guide/extras/composition-api-faq.html)
- [Inertia.js Forms](https://inertiajs.com/forms)
- [Laravel Wayfinder](https://github.com/laravel/wayfinder)

