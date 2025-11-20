<script setup>
import { ref, computed } from 'vue';
import { usePage, Link, router } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import Alert from '@/Components/Alert.vue';
import LightDarkButton from '@/Components/LightDarkButton.vue';
import { welcome, logout as logoutRoute } from '@/routes';
import { edit as profileRoute } from '@/routes/profile';
import { demo, colors } from '@/routes';

const page = usePage();
const showingNavigationDropdown = ref(false);

const auth = computed(() => page.props.auth);
const flash = computed(() => page.props.flash);

const showSuccessAlert = computed(() => flash.value?.success);
const showErrorAlert = computed(() => flash.value?.error);
const showWarningAlert = computed(() => flash.value?.warning);

const logout = () => {
    router.post(logoutRoute.url());
};
</script>

<template>
    <div class="min-h-screen bg-surface-50 dark:bg-surface-300 transition-colors duration-200">
        <nav class="bg-surface-100 dark:bg-surface-300 border-b border-border transition-colors duration-200">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <Link :href="welcome.url()">
                                <ApplicationLogo class="block h-9 w-auto" />
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                            <Link
                                :href="welcome.url()"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-text-muted hover:text-text-primary focus:outline-none focus:text-text-primary transition duration-150 ease-in-out"
                            >
                                Dashboard
                            </Link>
                            <Link
                                :href="demo.url()"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-text-muted hover:text-text-primary focus:outline-none focus:text-text-primary transition duration-150 ease-in-out"
                            >
                                Demo
                            </Link>
                            <Link
                                :href="colors.url()"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-text-muted hover:text-text-primary focus:outline-none focus:text-text-primary transition duration-150 ease-in-out"
                            >
                                Colors
                            </Link>
                            
                            <Dropdown align="left" width="56" class="flex items-center">
                                <template #trigger>
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-text-muted hover:text-text-primary focus:outline-none focus:text-text-primary transition duration-150 ease-in-out"
                                    >
                                        More
                                        <svg
                                            class="ml-1 -mr-0.5 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </template>

                                <template #content="{ close }">
                                    <Link
                                        href="#"
                                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-text-primary hover:bg-surface-200 focus:outline-none focus:bg-surface-200 transition duration-150 ease-in-out"
                                        @click="close"
                                    >
                                        Settings
                                    </Link>
                                    <Link
                                        href="#"
                                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-text-primary hover:bg-surface-200 focus:outline-none focus:bg-surface-200 transition duration-150 ease-in-out"
                                        @click="close"
                                    >
                                        Reports
                                    </Link>
                                    <Link
                                        href="#"
                                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-text-primary hover:bg-surface-200 focus:outline-none focus:bg-surface-200 transition duration-150 ease-in-out"
                                        @click="close"
                                    >
                                        Analytics
                                    </Link>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6 sm:gap-4">
                        <LightDarkButton />
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-3 py-2 text-sm text-text-muted leading-4 font-medium rounded-md bg-surface-100 dark:bg-surface-300 hover:text-text-primary focus:outline-none transition ease-in-out duration-150"
                                    >
                                        {{ auth.user?.name }}

                                        <svg
                                            class="ml-2 -mr-0.5 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content="{ close }">
                                <Link
                                    :href="profileRoute.url()"
                                    class="block w-full px-4 py-2 text-left text-sm leading-5 text-text-primary hover:bg-surface-200 focus:outline-none focus:bg-surface-200 transition duration-150 ease-in-out"
                                    @click="close"
                                >
                                    Profile
                                </Link>

                                <button
                                    type="button"
                                    class="block w-full px-4 py-2 text-left text-sm leading-5 text-text-primary hover:bg-surface-200 focus:outline-none focus:bg-surface-200 transition duration-150 ease-in-out"
                                    @click="logout"
                                >
                                    Log Out
                                </button>
                            </template>
                        </Dropdown>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center gap-2 sm:hidden">
                        <LightDarkButton />
                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center p-2 rounded-md text-text-primary hover:text-text-primary hover:bg-surface-200 focus:outline-none focus:bg-surface-200 focus:text-text-primary transition duration-150 ease-in-out"
                        >
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }"
                class="sm:hidden"
            >
                <div class="pt-2 pb-3 space-y-1">
                    <Link
                        :href="welcome.url()"
                        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-text-muted hover:text-text-primary hover:bg-surface-200 hover:border-border focus:outline-none focus:text-text-primary focus:bg-surface-200 focus:border-border transition duration-150 ease-in-out"
                    >
                        Dashboard
                    </Link>
                    <Link
                        :href="demo.url()"
                        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-text-muted hover:text-text-primary hover:bg-surface-200 hover:border-border focus:outline-none focus:text-text-primary focus:bg-surface-200 focus:border-border transition duration-150 ease-in-out"
                    >
                        Demo
                    </Link>
                    <div class="pl-3 pr-4 py-2">
                        <div class="text-base font-medium text-text-muted mb-1">More</div>
                        <div class="pl-4 space-y-1">
                            <Link
                                href="#"
                                class="block py-2 text-sm text-text-muted hover:text-text-primary hover:bg-surface-200 focus:outline-none focus:text-text-primary focus:bg-surface-200 transition duration-150 ease-in-out rounded px-2"
                            >
                                Settings
                            </Link>
                            <Link
                                href="#"
                                class="block py-2 text-sm text-text-muted hover:text-text-primary hover:bg-surface-200 focus:outline-none focus:text-text-primary focus:bg-surface-200 transition duration-150 ease-in-out rounded px-2"
                            >
                                Reports
                            </Link>
                            <Link
                                href="#"
                                class="block py-2 text-sm text-text-muted hover:text-text-primary hover:bg-surface-200 focus:outline-none focus:text-text-primary focus:bg-surface-200 transition duration-150 ease-in-out rounded px-2"
                            >
                                Analytics
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-border">
                    <div class="px-4 flex items-center justify-between">
                        <div>
                            <div class="font-medium text-base text-text-primary">
                                {{ auth.user?.name }}
                            </div>
                            <div class="font-medium text-sm text-text-muted">
                                {{ auth.user?.email }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <Link
                            href="#"
                            class="block px-4 py-2 text-base font-medium text-text-muted hover:text-text-primary hover:bg-surface-200 focus:outline-none focus:text-text-primary focus:bg-surface-200 transition duration-150 ease-in-out"
                        >
                            Profile
                        </Link>

                        <button
                            type="button"
                            class="block w-full text-left px-4 py-2 text-base font-medium text-text-muted hover:text-text-primary hover:bg-surface-200 focus:outline-none focus:text-text-primary focus:bg-surface-200 transition duration-150 ease-in-out"
                            @click="logout"
                        >
                            Log Out
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header v-if="$slots.header" class="bg-surface-100 dark:bg-surface-300 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Flash Messages -->
        <div v-if="showSuccessAlert || showErrorAlert || showWarningAlert" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
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

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <slot />
        </main>
    </div>
</template>

