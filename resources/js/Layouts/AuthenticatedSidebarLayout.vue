<script setup>
import { ref, computed } from 'vue';
import { usePage, Link, router } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import Alert from '@/Components/Alert.vue';
import LightDarkButton from '@/Components/LightDarkButton.vue';
import { welcome, logout as logoutRoute } from '@/routes';
import { edit as profileEditRoute } from '@/routes/profile';

const page = usePage();
const sidebarOpen = ref(false);

const auth = computed(() => page.props.auth);
const flash = computed(() => page.props.flash);

const showSuccessAlert = computed(() => flash.value?.success);
const showErrorAlert = computed(() => flash.value?.error);
const showWarningAlert = computed(() => flash.value?.warning);

const logout = () => {
    router.post(logoutRoute.url());
};

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

const closeSidebar = () => {
    sidebarOpen.value = false;
};
</script>

<template>
    <div class="min-h-screen bg-surface-50 dark:bg-surface-300 transition-colors duration-200 flex">
        <!-- Mobile sidebar backdrop -->
        <Transition
            enter-active-class="transition-opacity ease-linear duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity ease-linear duration-300"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-show="sidebarOpen"
                class="fixed inset-0 bg-overlay z-40 lg:hidden"
                @click="closeSidebar"
            />
        </Transition>

        <!-- Sidebar -->
        <aside
            :class="[
                'fixed inset-y-0 left-0 z-50 w-64 h-screen bg-surface-100 dark:bg-surface-300 border-r border-border transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:sticky lg:top-0 lg:z-auto lg:h-screen shrink-0',
                sidebarOpen ? 'translate-x-0' : '-translate-x-full',
            ]"
        >
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between h-16 px-4 shrink-0">
                    <Link :href="welcome.url()" @click="closeSidebar">
                        <ApplicationLogo class="h-8" />
                    </Link>
                    <button
                        class="lg:hidden text-text-muted hover:text-text-primary"
                        @click="closeSidebar"
                    >
                            <svg
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto min-h-0">
                    <Link
                        :href="welcome.url()"
                        class="flex items-center px-4 py-2 text-sm font-medium rounded-lg text-text-muted hover:bg-surface-200 hover:text-text-primary focus:outline-none focus:bg-surface-200 focus:text-text-primary transition duration-150 ease-in-out"
                        @click="closeSidebar"
                    >
                        <svg
                            class="mr-3 h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                            />
                        </svg>
                        Dashboard
                    </Link>
                </nav>

                <!-- User Menu -->
                <div class="p-4 border-t border-border shrink-0">
                    <Dropdown align="right" vertical-align="top" width="48">
                        <template #trigger="{ open }">
                            <button
                                type="button"
                                class="flex items-center w-full px-4 py-2 text-sm font-medium rounded-lg text-text-primary hover:bg-surface-200 focus:outline-none focus:bg-surface-200 transition duration-150 ease-in-out"
                            >
                                <div class="flex-shrink-0 mr-3">
                                    <div class="h-8 w-8 rounded-full bg-primary-500 flex items-center justify-center text-white text-sm font-medium">
                                        {{ auth.user?.name?.charAt(0).toUpperCase() }}
                                    </div>
                                </div>
                                <div class="flex-1 text-left">
                                    <div class="text-sm font-medium text-text-primary">
                                        {{ auth.user?.name }}
                                    </div>
                                    <div class="text-xs text-text-muted">
                                        {{ auth.user?.email }}
                                    </div>
                                </div>
                                <svg
                                    class="ml-2 h-4 w-4"
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
                            </button>
                        </template>

                        <template #content="{ close }">
                            <Link
                                :href="profileEditRoute.url()"
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
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 min-w-0 flex flex-col">
            <!-- Top Bar -->
            <header class="sticky top-0 z-30 bg-surface-100 dark:bg-surface-300 border-b border-border transition-colors duration-200">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <button
                        class="lg:hidden text-text-muted hover:text-text-primary"
                        @click="toggleSidebar"
                    >
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>

                    <div class="flex-1"></div>
                    <div class="flex items-center">
                        <LightDarkButton />
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            <div v-if="showSuccessAlert || showErrorAlert || showWarningAlert" class="px-4 sm:px-6 lg:px-8 mt-4">
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

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-surface-100 dark:bg-surface-300">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="px-4 sm:px-6 lg:px-8 py-6">
                <slot />
            </main>
        </div>
    </div>
</template>

