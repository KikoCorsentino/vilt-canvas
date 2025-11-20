# Components Documentation

VILT Canvas includes a comprehensive library of reusable Vue 3 components built with Tailwind CSS. All components are designed to be accessible, responsive, and support dark mode.

## Table of Contents

- [Button](#button)
- [Alert](#alert)
- [TextInput](#textinput)
- [InputLabel](#inputlabel)
- [InputError](#inputerror)
- [Checkbox](#checkbox)
- [Dropdown](#dropdown)
- [Modal](#modal)
- [LightDarkButton](#lightdarkbutton)
- [ApplicationLogo](#applicationlogo)

## Button

A versatile button component with multiple variants, sizes, and states.

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | `String` | `'button'` | Button type: `'button'`, `'submit'`, or `'reset'` |
| `variant` | `String` | `'primary'` | Button style: `'primary'`, `'outlined'`, `'danger'`, or `'ghost'` |
| `size` | `String` | `'default'` | Button size: `'big'`, `'default'`, or `'small'` |
| `disabled` | `Boolean` | `false` | Whether the button is disabled |
| `loading` | `Boolean` | `false` | Shows loading spinner when true |

### Events

- `@click` - Emitted when button is clicked

### Usage Examples

**Basic Button:**
```vue
<Button>Click Me</Button>
```

**Primary Button:**
```vue
<Button variant="primary">Save</Button>
```

**Outlined Button:**
```vue
<Button variant="outlined">Cancel</Button>
```

**Danger Button:**
```vue
<Button variant="danger">Delete</Button>
```

**Ghost Button:**
```vue
<Button variant="ghost">Skip</Button>
```

**Different Sizes:**
```vue
<Button size="big">Large Button</Button>
<Button size="default">Default Button</Button>
<Button size="small">Small Button</Button>
```

**Loading State:**
```vue
<Button :loading="isProcessing">Processing...</Button>
```

**Disabled State:**
```vue
<Button :disabled="!canSubmit">Submit</Button>
```

**Submit Button:**
```vue
<Button type="submit" variant="primary">Submit Form</Button>
```

## Alert

Displays contextual feedback messages with different types and auto-dismiss functionality.

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | `String` | `'info'` | Alert type: `'success'`, `'error'`, `'warning'`, or `'info'` |
| `message` | `String` | `''` | Alert message text |
| `dismissible` | `Boolean` | `true` | Whether the alert can be dismissed |
| `autoDismiss` | `Boolean` | `false` | Automatically dismiss after delay |
| `autoDismissDelay` | `Number` | `5000` | Auto-dismiss delay in milliseconds |

### Events

- `@close` - Emitted when alert is dismissed

### Usage Examples

**Basic Alert:**
```vue
<Alert type="success" message="Operation completed successfully!" />
```

**Error Alert:**
```vue
<Alert type="error" message="Something went wrong!" />
```

**Warning Alert:**
```vue
<Alert type="warning" message="Please review your input." />
```

**Info Alert:**
```vue
<Alert type="info" message="Here is some information." />
```

**Auto-dismissing Alert:**
```vue
<Alert 
    type="success" 
    message="Saved!" 
    :auto-dismiss="true"
    :auto-dismiss-delay="3000"
/>
```

**Non-dismissible Alert:**
```vue
<Alert 
    type="error" 
    message="Critical error!" 
    :dismissible="false"
/>
```

**With Slot Content:**
```vue
<Alert type="success">
    <strong>Success!</strong> Your changes have been saved.
</Alert>
```

## TextInput

A styled text input component with error states and various input types.

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `modelValue` | `String\|Number` | `''` | Input value (v-model) |
| `type` | `String` | `'text'` | Input type: `'text'`, `'email'`, `'password'`, `'number'`, `'tel'`, `'url'`, `'search'` |
| `id` | `String` | `null` | Input ID (auto-generated if not provided) |
| `required` | `Boolean` | `false` | Whether the input is required |
| `autofocus` | `Boolean` | `false` | Whether to autofocus the input |
| `placeholder` | `String` | `''` | Placeholder text |
| `error` | `String` | `null` | Error message to display |

### Events

- `@update:modelValue` - Emitted when input value changes

### Usage Examples

**Basic Input:**
```vue
<TextInput v-model="name" placeholder="Enter your name" />
```

**Email Input:**
```vue
<TextInput 
    v-model="email" 
    type="email" 
    placeholder="Enter your email"
    required
/>
```

**Password Input:**
```vue
<TextInput 
    v-model="password" 
    type="password" 
    placeholder="Enter password"
    required
/>
```

**With Error:**
```vue
<TextInput 
    v-model="email" 
    type="email"
    error="Please enter a valid email address"
/>
```

**With Label and Error:**
```vue
<InputLabel for="email" value="Email" required />
<TextInput 
    id="email"
    v-model="email" 
    type="email"
    :error="form.errors.email"
/>
<InputError :message="form.errors.email" />
```

## InputLabel

A styled label component for form inputs.

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `for` | `String` | `null` | ID of the associated input |
| `value` | `String` | `''` | Label text |
| `required` | `Boolean` | `false` | Shows required indicator (*) |

### Usage Examples

**Basic Label:**
```vue
<InputLabel for="name" value="Name" />
```

**Required Label:**
```vue
<InputLabel for="email" value="Email" required />
```

**With Slot:**
```vue
<InputLabel for="terms">
    I agree to the <a href="/terms">terms and conditions</a>
</InputLabel>
```

## InputError

Displays validation error messages for form inputs.

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `message` | `String` | `null` | Error message to display |
| `id` | `String` | `null` | Error element ID (auto-generated if not provided) |

### Usage Examples

**Basic Error:**
```vue
<InputError :message="form.errors.email" />
```

**Conditional Error:**
```vue
<InputError 
    v-if="form.errors.password" 
    :message="form.errors.password" 
/>
```

**Complete Form Field:**
```vue
<div>
    <InputLabel for="email" value="Email" required />
    <TextInput 
        id="email"
        v-model="form.email" 
        type="email"
        :error="form.errors.email"
    />
    <InputError :message="form.errors.email" />
</div>
```

## Checkbox

A styled checkbox component with label support.

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `modelValue` | `Boolean` | `false` | Checkbox value (v-model) |
| `id` | `String` | `null` | Checkbox ID (auto-generated if not provided) |
| `value` | `String\|Number\|Boolean` | `true` | Value when checked |
| `required` | `Boolean` | `false` | Whether the checkbox is required |
| `disabled` | `Boolean` | `false` | Whether the checkbox is disabled |

### Events

- `@update:modelValue` - Emitted when checkbox state changes

### Usage Examples

**Basic Checkbox:**
```vue
<Checkbox v-model="agreed" id="terms">
    I agree to the terms and conditions
</Checkbox>
```

**Required Checkbox:**
```vue
<Checkbox v-model="subscribed" id="newsletter" required>
    Subscribe to newsletter
</Checkbox>
```

**Disabled Checkbox:**
```vue
<Checkbox v-model="option" id="option" :disabled="true">
    This option is disabled
</Checkbox>
```

## Dropdown

A dropdown menu component with customizable alignment and width.

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `align` | `String` | `'right'` | Alignment: `'left'` or `'right'` |
| `verticalAlign` | `String` | `'bottom'` | Vertical alignment: `'top'` or `'bottom'` |
| `width` | `String` | `'48'` | Dropdown width: `'48'`, `'56'`, `'64'`, `'72'`, or `'80'` |

### Slots

- `trigger` - Content that triggers the dropdown (receives `open` state)
- `content` - Dropdown menu content (receives `close` function)

### Events

- `@close` - Emitted when dropdown closes

### Usage Examples

**Basic Dropdown:**
```vue
<Dropdown>
    <template #trigger>
        <Button>Menu</Button>
    </template>
    
    <template #content="{ close }">
        <button @click="close" class="block w-full text-left px-4 py-2">
            Option 1
        </button>
        <button @click="close" class="block w-full text-left px-4 py-2">
            Option 2
        </button>
    </template>
</Dropdown>
```

**Left-aligned Dropdown:**
```vue
<Dropdown align="left" width="64">
    <template #trigger>
        <Button>More Options</Button>
    </template>
    
    <template #content="{ close }">
        <!-- Menu items -->
    </template>
</Dropdown>
```

**Top-aligned Dropdown:**
```vue
<Dropdown vertical-align="top">
    <template #trigger>
        <Button>Menu</Button>
    </template>
    
    <template #content="{ close }">
        <!-- Menu items -->
    </template>
</Dropdown>
```

## Modal

A modal dialog component with backdrop, keyboard, and click-outside support.

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `show` | `Boolean` | `false` | Whether the modal is visible |
| `maxWidth` | `String` | `'md'` | Maximum width: `'sm'`, `'md'`, `'lg'`, `'xl'`, or `'2xl'` |
| `closeable` | `Boolean` | `true` | Whether the modal can be closed |

### Events

- `@close` - Emitted when modal should close

### Usage Examples

**Basic Modal:**
```vue
<script setup>
import { ref } from 'vue';

const showModal = ref(false);
</script>

<template>
    <Button @click="showModal = true">Open Modal</Button>
    
    <Modal :show="showModal" @close="showModal = false">
        <h2>Modal Title</h2>
        <p>Modal content goes here.</p>
        <Button @click="showModal = false">Close</Button>
    </Modal>
</template>
```

**Large Modal:**
```vue
<Modal :show="showModal" @close="showModal = false" max-width="xl">
    <!-- Large content -->
</Modal>
```

**Non-closeable Modal:**
```vue
<Modal :show="showModal" :closeable="false">
    <!-- Modal that must be closed programmatically -->
</Modal>
```

**With useModal Composable:**
```vue
<script setup>
import { useModal } from '@/composables';

const { isOpen, open, close } = useModal();
</script>

<template>
    <Button @click="open">Open Modal</Button>
    
    <Modal :show="isOpen" @close="close">
        <h2>Modal Content</h2>
    </Modal>
</template>
```

## LightDarkButton

A button component for toggling between light and dark modes.

### Props

None

### Usage Examples

**Basic Usage:**
```vue
<LightDarkButton />
```

The button automatically:
- Detects current theme
- Toggles between light and dark modes
- Persists preference in localStorage
- Updates the `<html>` element's class

## ApplicationLogo

Displays the application logo.

### Props

None (uses CSS classes for sizing)

### Usage Examples

**Basic Logo:**
```vue
<ApplicationLogo />
```

**Sized Logo:**
```vue
<ApplicationLogo class="h-12 w-auto" />
```

**In Navigation:**
```vue
<Link :href="welcome.url()">
    <ApplicationLogo class="block h-9 w-auto" />
</Link>
```

## Best Practices

### Component Composition

Combine components for complete form fields:

```vue
<div>
    <InputLabel for="email" value="Email" required />
    <TextInput 
        id="email"
        v-model="form.email" 
        type="email"
        placeholder="Enter your email"
        :error="form.errors.email"
        required
    />
    <InputError :message="form.errors.email" />
</div>
```

### Accessibility

All components include proper ARIA attributes:
- Labels are properly associated with inputs
- Error messages are linked to inputs
- Buttons have appropriate roles and states
- Modals are properly announced to screen readers

### Dark Mode

All components automatically support dark mode through Tailwind's dark mode classes. No additional configuration needed.

### Styling

Components use the centralized color system. To customize:
1. Update color variables in `resources/css/app.css`
2. See [COLOR-SYSTEM.md](./COLOR-SYSTEM.md) for details

### Form Integration

Components work seamlessly with Inertia forms:

```vue
<script setup>
import { useForm } from '@inertiajs/vue3';
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
        <InputLabel for="name" value="Name" required />
        <TextInput 
            id="name"
            v-model="form.name" 
            :error="form.errors.name"
        />
        <InputError :message="form.errors.name" />
        
        <Button type="submit" :loading="form.processing">
            Submit
        </Button>
    </form>
</template>
```

