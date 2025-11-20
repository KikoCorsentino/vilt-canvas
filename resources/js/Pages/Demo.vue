<script setup>
import { ref, computed } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Alert from '@/Components/Alert.vue';
import Button from '@/Components/Button.vue';
import Checkbox from '@/Components/Checkbox.vue';
import Dropdown from '@/Components/Dropdown.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import LightDarkButton from '@/Components/LightDarkButton.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { useAuth, useFlash, useForm, useModal, useRoute } from '@/composables';
import { edit as profileEdit } from '@/routes/profile';
import { dashboard } from '@/routes';

// Composables examples
const { user, isAuthenticated, logout } = useAuth();
const { flash, success, error, warning, info, clearFlash } = useFlash();
const { route, current, has, visit, currentRouteName, currentUrl } = useRoute();

// Form example
const demoForm = useForm({
    name: '',
    email: '',
    password: '',
    terms: false,
});

// Modal example
const { isOpen: isModalOpen, open: openModal, close: closeModal } = useModal();

// Component state
const showAlert = ref(false);
const alertType = ref('success');
const alertMessage = ref('This is a success message!');
const checkboxValue = ref(false);
const textInputValue = ref('');
const dropdownOpen = ref(false);
const loadingButton = ref(false);

// Demo functions
const showAlertDemo = (type, message) => {
    alertType.value = type;
    alertMessage.value = message;
    showAlert.value = true;
    setTimeout(() => {
        showAlert.value = false;
    }, 5000);
};

const handleLoadingButton = () => {
    loadingButton.value = true;
    setTimeout(() => {
        loadingButton.value = false;
    }, 2000);
};

const handleFormSubmit = () => {
    console.log('Form submitted:', demoForm.data());
    // Simulate form submission
    demoForm.reset();
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Component & Composable Demo" />

        <template #header>
            <h2 class="font-semibold text-xl text-text-primary leading-tight">
                Component & Composable Demo
            </h2>
        </template>

        <div class="space-y-8">
            <!-- Alerts Section -->
            <section class="rounded-lg bg-surface-0 p-6 shadow dark:bg-surface-100">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Alerts</h3>
                <div class="space-y-4">
                    <Alert
                        v-if="showAlert"
                        :type="alertType"
                        :message="alertMessage"
                        :dismissible="true"
                        @close="showAlert = false"
                    />

                    <div class="flex flex-wrap gap-2">
                        <Button @click="showAlertDemo('success', 'Operation completed successfully!')">
                            Success Alert
                        </Button>
                        <Button @click="showAlertDemo('error', 'Something went wrong!')">
                            Error Alert
                        </Button>
                        <Button @click="showAlertDemo('warning', 'Please review your input.')">
                            Warning Alert
                        </Button>
                        <Button @click="showAlertDemo('info', 'Here is some information.')">
                            Info Alert
                        </Button>
                    </div>

                    <div class="mt-4 space-y-2">
                        <Alert type="success" message="This is a success alert with auto-dismiss" :auto-dismiss="true" />
                        <Alert type="error" message="This is an error alert" :dismissible="true" />
                        <Alert type="warning" message="This is a warning alert" :dismissible="true" />
                        <Alert type="info" message="This is an info alert" :dismissible="true" />
                    </div>
                </div>
            </section>

            <!-- Buttons Section -->
            <section class="rounded-lg bg-surface-0 p-6 shadow dark:bg-surface-100">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Buttons</h3>
                <div class="space-y-4">
                    <div class="flex flex-wrap gap-2">
                        <Button variant="primary">Primary Button</Button>
                        <Button variant="outlined">Outlined Button</Button>
                        <Button variant="danger">Danger Button</Button>
                        <Button variant="ghost">Ghost Button</Button>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <Button variant="primary" :loading="loadingButton" @click="handleLoadingButton">
                            Loading Button
                        </Button>
                        <Button variant="primary" :disabled="true">Disabled Button</Button>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <Button type="submit" variant="primary">Submit Button</Button>
                        <Button type="reset" variant="outlined">Reset Button</Button>
                    </div>

                    <div class="pt-4 border-t border-border">
                        <h4 class="text-base font-medium text-text-primary mb-3">Button Sizes</h4>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-text-muted mb-2">Big Size</p>
                                <div class="flex flex-wrap gap-2">
                                    <Button variant="primary" size="big">Big Primary</Button>
                                    <Button variant="outlined" size="big">Big Outlined</Button>
                                    <Button variant="danger" size="big">Big Danger</Button>
                                    <Button variant="ghost" size="big">Big Ghost</Button>
                                </div>
                            </div>

                            <div>
                                <p class="text-sm text-text-muted mb-2">Default Size</p>
                                <div class="flex flex-wrap gap-2">
                                    <Button variant="primary" size="default">Default Primary</Button>
                                    <Button variant="outlined" size="default">Default Outlined</Button>
                                    <Button variant="danger" size="default">Default Danger</Button>
                                    <Button variant="ghost" size="default">Default Ghost</Button>
                                </div>
                            </div>

                            <div>
                                <p class="text-sm text-text-muted mb-2">Small Size</p>
                                <div class="flex flex-wrap gap-2">
                                    <Button variant="primary" size="small">Small Primary</Button>
                                    <Button variant="outlined" size="small">Small Outlined</Button>
                                    <Button variant="danger" size="small">Small Danger</Button>
                                    <Button variant="ghost" size="small">Small Ghost</Button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Form Components Section -->
            <section class="rounded-lg bg-surface-0 p-6 shadow dark:bg-surface-100">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Form Components</h3>
                <div class="space-y-6 max-w-2xl">
                    <form @submit.prevent="handleFormSubmit" class="space-y-4">
                        <div>
                            <InputLabel for="demo-name" value="Name" required />
                            <TextInput
                                id="demo-name"
                                v-model="demoForm.name"
                                type="text"
                                placeholder="Enter your name"
                                class="mt-1"
                                :error="demoForm.errors.name"
                            />
                            <InputError :message="demoForm.errors.name" />
                        </div>

                        <div>
                            <InputLabel for="demo-email" value="Email" required />
                            <TextInput
                                id="demo-email"
                                v-model="demoForm.email"
                                type="email"
                                placeholder="Enter your email"
                                class="mt-1"
                                :error="demoForm.errors.email"
                            />
                            <InputError :message="demoForm.errors.email" />
                        </div>

                        <div>
                            <InputLabel for="demo-password" value="Password" required />
                            <TextInput
                                id="demo-password"
                                v-model="demoForm.password"
                                type="password"
                                placeholder="Enter your password"
                                class="mt-1"
                                :error="demoForm.errors.password"
                            />
                            <InputError :message="demoForm.errors.password" />
                        </div>

                        <div>
                            <Checkbox v-model="demoForm.terms" id="demo-terms">
                                I agree to the terms and conditions
                            </Checkbox>
                        </div>

                        <div class="flex gap-2">
                            <Button type="submit" variant="primary">Submit Form</Button>
                            <Button type="button" variant="outlined" @click="demoForm.reset()">
                                Reset Form
                            </Button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Checkbox Section -->
            <section class="rounded-lg bg-surface-0 p-6 shadow dark:bg-surface-100">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Checkboxes</h3>
                <div class="space-y-4">
                    <Checkbox v-model="checkboxValue" id="checkbox-1">
                        Checkbox Option 1
                    </Checkbox>
                    <Checkbox v-model="checkboxValue" id="checkbox-2" :disabled="true">
                        Disabled Checkbox
                    </Checkbox>
                    <Checkbox v-model="checkboxValue" id="checkbox-3" :required="true">
                        Required Checkbox
                    </Checkbox>
                    <p class="text-sm text-text-muted">Value: {{ checkboxValue }}</p>
                </div>
            </section>

            <!-- Text Input Section -->
            <section class="rounded-lg bg-surface-0 p-6 shadow dark:bg-surface-100">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Text Inputs</h3>
                <div class="space-y-4 max-w-2xl">
                    <div>
                        <InputLabel for="text-input" value="Text Input" />
                        <TextInput
                            id="text-input"
                            v-model="textInputValue"
                            type="text"
                            placeholder="Enter text"
                            class="mt-1"
                        />
                    </div>

                    <div>
                        <InputLabel for="email-input" value="Email Input" />
                        <TextInput
                            id="email-input"
                            v-model="textInputValue"
                            type="email"
                            placeholder="Enter email"
                            class="mt-1"
                        />
                    </div>

                    <div>
                        <InputLabel for="password-input" value="Password Input" />
                        <TextInput
                            id="password-input"
                            v-model="textInputValue"
                            type="password"
                            placeholder="Enter password"
                            class="mt-1"
                        />
                    </div>

                    <div>
                        <InputLabel for="error-input" value="Input with Error" />
                        <TextInput
                            id="error-input"
                            v-model="textInputValue"
                            type="text"
                            placeholder="This input has an error"
                            error="This field is required"
                            class="mt-1"
                        />
                        <InputError message="This field is required" />
                    </div>

                    <p class="text-sm text-text-muted">Value: {{ textInputValue }}</p>
                </div>
            </section>

            <!-- Dropdown Section -->
            <section class="rounded-lg bg-surface-0 p-6 shadow dark:bg-surface-100">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Dropdown</h3>
                <div class="space-y-4">
                    <Dropdown align="left" width="48">
                        <template #trigger="{ open }">
                            <Button variant="outlined">
                                Dropdown Menu
                                <svg
                                    class="ml-2 h-4 w-4"
                                    :class="{ 'rotate-180': open }"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </Button>
                        </template>

                        <template #content="{ close }">
                            <button
                                class="block w-full text-left px-4 py-2 text-sm text-text-primary hover:bg-surface-200 dark:hover:bg-surface-400 transition-colors"
                                @click="close"
                            >
                                Option 1
                            </button>
                            <button
                                class="block w-full text-left px-4 py-2 text-sm text-text-primary hover:bg-surface-200 dark:hover:bg-surface-400 transition-colors"
                                @click="close"
                            >
                                Option 2
                            </button>
                            <button
                                class="block w-full text-left px-4 py-2 text-sm text-text-primary hover:bg-surface-200 dark:hover:bg-surface-400 transition-colors"
                                @click="close"
                            >
                                Option 3
                            </button>
                        </template>
                    </Dropdown>
                </div>
            </section>

            <!-- Modal Section -->
            <section class="rounded-lg bg-surface-0 p-6 shadow dark:bg-surface-100">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Modal</h3>
                <div class="space-y-4">
                    <Button variant="primary" @click="openModal">Open Modal</Button>

                    <Modal :show="isModalOpen" @close="closeModal" max-width="lg">
                        <h2 class="text-lg font-medium text-text-primary mb-4">Modal Example</h2>
                        <p class="text-sm text-text-muted mb-4">
                            This is a modal dialog. You can close it by clicking the backdrop, pressing Escape, or clicking
                            the close button.
                        </p>
                        <div class="flex justify-end gap-2">
                            <Button variant="outlined" @click="closeModal">Close</Button>
                            <Button variant="primary" @click="closeModal">Confirm</Button>
                        </div>
                    </Modal>
                </div>
            </section>

            <!-- Light/Dark Button Section -->
            <section class="rounded-lg bg-surface-0 p-6 shadow dark:bg-surface-100">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Light/Dark Mode Toggle</h3>
                <div class="space-y-4">
                    <LightDarkButton />
                    <p class="text-sm text-text-muted">
                        Click the button above to toggle between light and dark mode.
                    </p>
                </div>
            </section>

            <!-- Application Logo Section -->
            <section class="rounded-lg bg-surface-0 p-6 shadow dark:bg-surface-100">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Application Logo</h3>
                <div class="space-y-4">
                    <ApplicationLogo class="h-12 w-auto" />
                    <p class="text-sm text-text-muted">Application logo component</p>
                </div>
            </section>

            <!-- Composables Section -->
            <section class="rounded-lg bg-surface-0 p-6 shadow dark:bg-surface-100">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Composables Examples</h3>
                <div class="space-y-6">
                    <!-- useAuth -->
                    <div>
                        <h4 class="text-base font-medium text-text-primary mb-2">useAuth</h4>
                        <div class="p-4 bg-surface-200 dark:bg-surface-300 rounded-lg space-y-2">
                            <p class="text-sm text-text-primary">
                                <strong>Is Authenticated:</strong> {{ isAuthenticated ? 'Yes' : 'No' }}
                            </p>
                            <p class="text-sm text-text-primary" v-if="user">
                                <strong>User:</strong> {{ user.name }} ({{ user.email }})
                            </p>
                            <Button variant="danger" @click="logout" v-if="isAuthenticated">
                                Logout
                            </Button>
                        </div>
                    </div>

                    <!-- useFlash -->
                    <div>
                        <h4 class="text-base font-medium text-text-primary mb-2">useFlash</h4>
                        <div class="p-4 bg-surface-200 dark:bg-surface-300 rounded-lg space-y-2">
                            <p class="text-sm text-text-primary">
                                <strong>Flash Messages:</strong>
                            </p>
                            <div class="space-y-1">
                                <p class="text-sm text-text-muted" v-if="success">
                                    Success: {{ success }}
                                </p>
                                <p class="text-sm text-text-muted" v-if="error">
                                    Error: {{ error }}
                                </p>
                                <p class="text-sm text-text-muted" v-if="warning">
                                    Warning: {{ warning }}
                                </p>
                                <p class="text-sm text-text-muted" v-if="info">
                                    Info: {{ info }}
                                </p>
                                <p class="text-sm text-text-muted" v-if="!success && !error && !warning && !info">
                                    No flash messages
                                </p>
                            </div>
                            <Button variant="outlined" @click="clearFlash">
                                Clear Flash
                            </Button>
                        </div>
                    </div>

                    <!-- useRoute -->
                    <div>
                        <h4 class="text-base font-medium text-text-primary mb-2">useRoute</h4>
                        <div class="p-4 bg-surface-200 dark:bg-surface-300 rounded-lg space-y-2">
                            <p class="text-sm text-text-primary">
                                <strong>Current Route:</strong> {{ currentRouteName || 'N/A' }}
                            </p>
                            <p class="text-sm text-text-primary">
                                <strong>Current URL:</strong> {{ currentUrl }}
                            </p>
                            <p class="text-sm text-text-primary">
                                <strong>Dashboard Route:</strong> {{ route('dashboard') || 'N/A' }}
                            </p>
                            <p class="text-sm text-text-primary">
                                <strong>Has 'dashboard' route:</strong> {{ has('dashboard') ? 'Yes' : 'No' }}
                            </p>
                            <p class="text-sm text-text-primary">
                                <strong>Is current route 'demo':</strong> {{ current('demo') ? 'Yes' : 'No' }}
                            </p>
                            <div class="flex gap-2">
                                <Button variant="outlined" @click="router.visit(dashboard.url())">
                                    Visit Dashboard
                                </Button>
                                <Button variant="outlined" @click="router.visit(profileEdit.url())">
                                    Visit Profile
                                </Button>
                            </div>
                        </div>
                    </div>

                    <!-- useForm -->
                    <div>
                        <h4 class="text-base font-medium text-text-primary mb-2">useForm</h4>
                        <div class="p-4 bg-surface-200 dark:bg-surface-300 rounded-lg space-y-2">
                            <p class="text-sm text-text-primary">
                                <strong>Form Processing:</strong> {{ demoForm.processing ? 'Yes' : 'No' }}
                            </p>
                            <p class="text-sm text-text-primary">
                                <strong>Has Errors:</strong> {{ demoForm.hasErrors() ? 'Yes' : 'No' }}
                            </p>
                            <p class="text-sm text-text-primary">
                                <strong>Is Dirty:</strong> {{ demoForm.isDirty() ? 'Yes' : 'No' }}
                            </p>
                            <p class="text-sm text-text-muted">
                                Use the form above to see form state changes.
                            </p>
                        </div>
                    </div>

                    <!-- useModal -->
                    <div>
                        <h4 class="text-base font-medium text-text-primary mb-2">useModal</h4>
                        <div class="p-4 bg-surface-200 dark:bg-surface-300 rounded-lg space-y-2">
                            <p class="text-sm text-text-primary">
                                <strong>Modal Open:</strong> {{ isModalOpen ? 'Yes' : 'No' }}
                            </p>
                            <p class="text-sm text-text-muted">
                                Use the modal example above to see modal state changes.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>

