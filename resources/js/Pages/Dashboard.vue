<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AuthenticatedSidebarLayout from '@/Layouts/AuthenticatedSidebarLayout.vue';
import Button from '@/Components/Button.vue';
import Dropdown from '@/Components/Dropdown.vue';

const page = usePage();
const auth = computed(() => page.props.auth);

// Layout switching state
const layoutType = ref('header');

onMounted(() => {
    // Load layout preference from localStorage
    const savedLayout = localStorage.getItem('dashboardLayout');
    if (savedLayout) {
        layoutType.value = savedLayout;
    }
});

const switchLayout = (type) => {
    layoutType.value = type;
    localStorage.setItem('dashboardLayout', type);
};

// Widget data (placeholder)
const stats = [
    { label: 'Total Items', value: '24', icon: '📦', color: 'primary' },
    { label: 'Active Users', value: '142', icon: '👥', color: 'success' },
    { label: 'Pending Tasks', value: '8', icon: '📋', color: 'warning' },
    { label: 'Completed', value: '156', icon: '✅', color: 'info' },
];

const recentActivity = [
    { action: 'User created new item', time: '2 minutes ago', icon: '➕' },
    { action: 'Profile updated', time: '15 minutes ago', icon: '✏️' },
    { action: 'Task completed', time: '1 hour ago', icon: '✓' },
    { action: 'New user registered', time: '2 hours ago', icon: '👤' },
];

const quickActions = [
    { label: 'Create New', icon: '➕', action: () => {} },
    { label: 'View Reports', icon: '📊', action: () => {} },
    { label: 'Settings', icon: '⚙️', action: () => {} },
    { label: 'Help', icon: '❓', action: () => {} },
];

const systemStatus = {
    status: 'operational',
    uptime: '99.9%',
    lastCheck: 'Just now',
};
</script>

<template>
    <AuthenticatedLayout v-if="layoutType === 'header'">
        <Head title="Dashboard" />

        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-xl text-text-primary leading-tight">
                        Welcome back, {{ auth.user?.name }}!
                    </h2>
                    <p class="mt-1 text-sm text-text-muted">
                        Here's what's happening with your VILT Canvas application today.
                    </p>
                </div>

                <!-- Layout Switcher -->
                <Dropdown align="right" width="56">
                    <template #trigger="{ open }">
                        <button
                            type="button"
                            class="inline-flex items-center px-3 py-2 border border-border rounded-lg text-sm font-medium text-text-primary bg-surface-0 dark:bg-surface-100 hover:bg-surface-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                        >
                            <svg
                                class="mr-2 h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                                />
                            </svg>
                            Layout
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
                        <button
                            type="button"
                            :class="[
                                'block w-full px-4 py-2 text-left text-sm leading-5 transition duration-150 ease-in-out',
                                layoutType === 'header'
                                    ? 'text-primary-500 bg-primary-50 dark:bg-primary-900/20'
                                    : 'text-text-primary hover:bg-surface-200 focus:outline-none focus:bg-surface-200',
                            ]"
                            @click="switchLayout('header'); close()"
                        >
                            <div class="font-medium">Header Layout</div>
                            <div class="text-xs text-text-muted">
                                Navigation in header bar
                            </div>
                        </button>
                        <button
                            type="button"
                            :class="[
                                'block w-full px-4 py-2 text-left text-sm leading-5 transition duration-150 ease-in-out',
                                layoutType === 'sidebar'
                                    ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20'
                                    : 'text-text-primary hover:bg-surface-200 dark:hover:bg-surface-300 focus:outline-none focus:bg-surface-200 dark:focus:bg-surface-300',
                            ]"
                            @click="switchLayout('sidebar'); close()"
                        >
                            <div class="font-medium">Sidebar Layout</div>
                            <div class="text-xs text-text-muted">
                                Navigation in sidebar
                            </div>
                        </button>
                    </template>
                </Dropdown>
            </div>
        </template>

        <div class="space-y-6">
            <!-- Description Section -->
            <div class="bg-surface-0 dark:bg-surface-100 rounded-lg shadow p-6 border border-border">
                <h3 class="text-lg font-semibold text-text-primary mb-2">
                    About VILT Canvas
                </h3>
                <p class="text-sm text-text-muted leading-relaxed">
                    VILT Canvas is a modern Laravel application skeleton built with Inertia.js, Vue 3, and Tailwind CSS.
                    It provides a solid foundation for building scalable web applications with authentication, profile
                    management, and multiple layout options. This dashboard demonstrates the flexibility and power of the
                    VILT stack.
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="stat in stats"
                    :key="stat.label"
                    class="bg-surface-0 dark:bg-surface-100 rounded-lg shadow p-6 border border-border hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-700 transition-all duration-200 cursor-pointer group"
                >
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-text-muted group-hover:text-text-primary transition-colors">
                                {{ stat.label }}
                            </p>
                            <p class="mt-2 text-3xl font-bold text-text-primary">
                                {{ stat.value }}
                            </p>
                        </div>
                        <div class="ml-4 text-4xl opacity-80 group-hover:opacity-100 transition-opacity">
                            {{ stat.icon }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Recent Activity -->
                <div class="lg:col-span-2 bg-surface-0 dark:bg-surface-100 rounded-lg shadow p-6 border border-border hover:shadow-lg transition-shadow duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-text-primary">
                            Recent Activity
                        </h3>
                        <span class="text-2xl">📈</span>
                    </div>
                    <div class="space-y-4">
                        <div
                            v-for="(activity, index) in recentActivity"
                            :key="index"
                            class="flex items-start space-x-3 p-3 rounded-lg hover:bg-surface-200 transition-colors"
                        >
                            <div class="flex-shrink-0 text-2xl">{{ activity.icon }}</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-text-primary">
                                    {{ activity.action }}
                                </p>
                                <p class="text-xs text-text-muted mt-1">
                                    {{ activity.time }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-surface-0 dark:bg-surface-100 rounded-lg shadow p-6 border border-border hover:shadow-lg transition-shadow duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-text-primary">
                            Quick Actions
                        </h3>
                        <span class="text-2xl">⚡</span>
                    </div>
                    <div class="space-y-3">
                        <Button
                            v-for="(action, index) in quickActions"
                            :key="index"
                            variant="outlined"
                            class="w-full justify-start"
                            @click="action.action"
                        >
                            <span class="mr-2 text-lg">{{ action.icon }}</span>
                            {{ action.label }}
                        </Button>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-surface-0 dark:bg-surface-100 rounded-lg shadow p-6 border border-border hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="text-3xl">🖥️</div>
                        <div>
                            <h3 class="text-lg font-semibold text-text-primary">
                                System Status
                            </h3>
                            <p class="text-sm text-text-muted mt-1">
                                All systems operational
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center space-x-2">
                            <div class="h-3 w-3 rounded-full bg-green-500 animate-pulse"></div>
                            <span class="text-sm font-medium text-green-600 dark:text-green-400">
                                {{ systemStatus.status }}
                            </span>
                        </div>
                        <p class="text-xs text-text-muted mt-1">
                            Uptime: {{ systemStatus.uptime }}
                        </p>
                        <p class="text-xs text-text-muted">
                            Last check: {{ systemStatus.lastCheck }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <AuthenticatedSidebarLayout v-else>
        <Head title="Dashboard" />

        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-xl text-text-primary leading-tight">
                        Welcome back, {{ auth.user?.name }}!
                    </h2>
                    <p class="mt-1 text-sm text-text-muted">
                        Here's what's happening with your VILT Canvas application today.
                    </p>
                </div>

                <!-- Layout Switcher -->
                <Dropdown align="right" width="56">
                    <template #trigger="{ open }">
                        <button
                            type="button"
                            class="inline-flex items-center px-3 py-2 border border-border rounded-lg text-sm font-medium text-text-primary bg-surface-0 dark:bg-surface-100 hover:bg-surface-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                        >
                            <svg
                                class="mr-2 h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                                />
                            </svg>
                            Layout
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
                        <button
                            type="button"
                            :class="[
                                'block w-full px-4 py-2 text-left text-sm leading-5 transition duration-150 ease-in-out',
                                layoutType === 'header'
                                    ? 'text-primary-500 bg-primary-50 dark:bg-primary-900/20'
                                    : 'text-text-primary hover:bg-surface-200 focus:outline-none focus:bg-surface-200',
                            ]"
                            @click="switchLayout('header'); close()"
                        >
                            <div class="font-medium">Header Layout</div>
                            <div class="text-xs text-text-muted">
                                Navigation in header bar
                            </div>
                        </button>
                        <button
                            type="button"
                            :class="[
                                'block w-full px-4 py-2 text-left text-sm leading-5 transition duration-150 ease-in-out',
                                layoutType === 'sidebar'
                                    ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20'
                                    : 'text-text-primary hover:bg-surface-200 dark:hover:bg-surface-300 focus:outline-none focus:bg-surface-200 dark:focus:bg-surface-300',
                            ]"
                            @click="switchLayout('sidebar'); close()"
                        >
                            <div class="font-medium">Sidebar Layout</div>
                            <div class="text-xs text-text-muted">
                                Navigation in sidebar
                            </div>
                        </button>
                    </template>
                </Dropdown>
            </div>
        </template>

        <div class="space-y-6">
            <!-- Description Section -->
            <div class="bg-surface-0 dark:bg-surface-100 rounded-lg shadow p-6 border border-border">
                <h3 class="text-lg font-semibold text-text-primary mb-2">
                    About VILT Canvas
                </h3>
                <p class="text-sm text-text-muted leading-relaxed">
                    VILT Canvas is a modern Laravel application skeleton built with Inertia.js, Vue 3, and Tailwind CSS.
                    It provides a solid foundation for building scalable web applications with authentication, profile
                    management, and multiple layout options. This dashboard demonstrates the flexibility and power of the
                    VILT stack.
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="stat in stats"
                    :key="stat.label"
                    class="bg-surface-0 dark:bg-surface-100 rounded-lg shadow p-6 border border-border hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-700 transition-all duration-200 cursor-pointer group"
                >
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-text-muted group-hover:text-text-primary transition-colors">
                                {{ stat.label }}
                            </p>
                            <p class="mt-2 text-3xl font-bold text-text-primary">
                                {{ stat.value }}
                            </p>
                        </div>
                        <div class="ml-4 text-4xl opacity-80 group-hover:opacity-100 transition-opacity">
                            {{ stat.icon }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Recent Activity -->
                <div class="lg:col-span-2 bg-surface-0 dark:bg-surface-100 rounded-lg shadow p-6 border border-border hover:shadow-lg transition-shadow duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-text-primary">
                            Recent Activity
                        </h3>
                        <span class="text-2xl">📈</span>
                    </div>
                    <div class="space-y-4">
                        <div
                            v-for="(activity, index) in recentActivity"
                            :key="index"
                            class="flex items-start space-x-3 p-3 rounded-lg hover:bg-surface-200 transition-colors"
                        >
                            <div class="flex-shrink-0 text-2xl">{{ activity.icon }}</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-text-primary">
                                    {{ activity.action }}
                                </p>
                                <p class="text-xs text-text-muted mt-1">
                                    {{ activity.time }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-surface-0 dark:bg-surface-100 rounded-lg shadow p-6 border border-border hover:shadow-lg transition-shadow duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-text-primary">
                            Quick Actions
                        </h3>
                        <span class="text-2xl">⚡</span>
                    </div>
                    <div class="space-y-3">
                        <Button
                            v-for="(action, index) in quickActions"
                            :key="index"
                            variant="outlined"
                            class="w-full justify-start"
                            @click="action.action"
                        >
                            <span class="mr-2 text-lg">{{ action.icon }}</span>
                            {{ action.label }}
                        </Button>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-surface-0 dark:bg-surface-100 rounded-lg shadow p-6 border border-border hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="text-3xl">🖥️</div>
                        <div>
                            <h3 class="text-lg font-semibold text-text-primary">
                                System Status
                            </h3>
                            <p class="text-sm text-text-muted mt-1">
                                All systems operational
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center space-x-2">
                            <div class="h-3 w-3 rounded-full bg-green-500 animate-pulse"></div>
                            <span class="text-sm font-medium text-green-600 dark:text-green-400">
                                {{ systemStatus.status }}
                            </span>
                        </div>
                        <p class="text-xs text-text-muted mt-1">
                            Uptime: {{ systemStatus.uptime }}
                        </p>
                        <p class="text-xs text-text-muted">
                            Last check: {{ systemStatus.lastCheck }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedSidebarLayout>
</template>

