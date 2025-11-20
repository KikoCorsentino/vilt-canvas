<script setup>
import { computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Alert from '@/Components/Alert.vue';
import LightDarkButton from '@/Components/LightDarkButton.vue';
import { welcome } from '@/routes';

const page = usePage();

const flash = computed(() => page.props.flash);

const showSuccessAlert = computed(() => flash.value?.success);
const showErrorAlert = computed(() => flash.value?.error);
const showWarningAlert = computed(() => flash.value?.warning);
</script>

<template>
    <div class="min-h-screen flex flex-col bg-surface-50 dark:bg-surface-300 transition-colors duration-200">
        <!-- Header -->
        <header class="bg-surface-100 dark:bg-surface-300 border-b border-border transition-colors duration-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <Link :href="welcome.url()">
                            <ApplicationLogo class="h-8" />
                        </Link>
                    </div>

                    <div class="flex items-center gap-4">
                        <nav class="hidden md:flex space-x-8">
                            <Link
                                :href="welcome.url()"
                                class="text-text-muted hover:text-text-primary px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out"
                            >
                                Home
                            </Link>
                            <Link
                                href="#"
                                class="text-text-muted hover:text-text-primary px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out"
                            >
                                About
                            </Link>
                            <Link
                                href="#"
                                class="text-text-muted hover:text-text-primary px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out"
                            >
                                Contact
                            </Link>
                        </nav>
                        <LightDarkButton />
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div v-if="showSuccessAlert || showErrorAlert || showWarningAlert" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="space-y-4">
                <Alert
                    v-if="showSuccessAlert"
                    type="success"
                    :message="flash.success"
                    :dismissible="true"
                />
                <Alert
                    v-if="showErrorAlert"
                    type="error"
                    :message="flash.error"
                    :dismissible="true"
                />
                <Alert
                    v-if="showWarningAlert"
                    type="warning"
                    :message="flash.warning"
                    :dismissible="true"
                />
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-surface-100 dark:bg-surface-300 border-t border-border transition-colors duration-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <ApplicationLogo class="h-6 mb-4" />
                        <p class="text-sm text-text-muted">
                            Building modern web applications with Laravel and Vue.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-text-primary mb-4">
                            Quick Links
                        </h3>
                        <ul class="space-y-2">
                            <li>
                                <Link
                                    :href="welcome.url()"
                                    class="text-sm text-text-muted hover:text-text-primary transition duration-150 ease-in-out"
                                >
                                    Home
                                </Link>
                            </li>
                            <li>
                                <Link
                                    href="#"
                                    class="text-sm text-text-muted hover:text-text-primary transition duration-150 ease-in-out"
                                >
                                    About
                                </Link>
                            </li>
                            <li>
                                <Link
                                    href="#"
                                    class="text-sm text-text-muted hover:text-text-primary transition duration-150 ease-in-out"
                                >
                                    Contact
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-text-primary mb-4">
                            Legal
                        </h3>
                        <ul class="space-y-2">
                            <li>
                                <Link
                                    href="#"
                                    class="text-sm text-text-muted hover:text-text-primary transition duration-150 ease-in-out"
                                >
                                    Privacy Policy
                                </Link>
                            </li>
                            <li>
                                <Link
                                    href="#"
                                    class="text-sm text-text-muted hover:text-text-primary transition duration-150 ease-in-out"
                                >
                                    Terms of Service
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-border">
                    <p class="text-center text-sm text-text-muted">
                        &copy; {{ new Date().getFullYear() }} VILT Canvas. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

