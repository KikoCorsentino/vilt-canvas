<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { welcome, login, register, dashboard } from '@/routes';

defineProps({
    auth: {
        type: Object,
        default: () => ({
            user: null,
        }),
    },
    appName: {
        type: String,
        default: 'Laravel',
    },
});

const page = usePage();
const isWelcomePage = page.url === welcome.url();
</script>

<template>
    <Head title="Welcome" />

    <div class="min-h-screen bg-surface-0 dark:bg-surface-100 flex items-center justify-center transition-colors duration-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-text-primary mb-4">
                    Welcome to {{ appName }}
                </h1>
                <p class="text-lg text-text-muted mb-8">
                    Your Inertia.js + Vue 3 application is ready!
                </p>

                <div class="bg-surface-0 dark:bg-surface-100 rounded-lg shadow-lg p-8 mb-8 border border-border transition-colors duration-200">
                    <h2 class="text-2xl font-semibold text-text-primary mb-4">
                        Getting Started
                    </h2>
                    <p class="text-text-muted mb-4">
                        This is a basic Welcome page component to test your Inertia.js setup.
                    </p>
                    <div class="flex gap-4 justify-center mt-6">
                        <a
                            href="https://inertiajs.com"
                            target="_blank"
                            class="px-4 py-2 rounded-lg bg-primary-500 hover:bg-primary-400 text-white transition-colors"
                        >
                            Inertia.js Docs
                        </a>
                        <a
                            href="https://vuejs.org"
                            target="_blank"
                            class="px-4 py-2 rounded-lg bg-primary-500 hover:bg-primary-400 text-white transition-colors"
                        >
                            Vue 3 Docs
                        </a>
                    </div>
                    <div v-if="!auth.user" class="flex gap-4 justify-center mt-4">
                        <Link
                            :href="login.url()"
                            class="px-4 py-2 rounded-lg bg-primary-500 hover:bg-primary-400 text-white transition-colors"
                        >
                            Login
                        </Link>
                        <Link
                            :href="register.url()"
                            class="px-4 py-2 rounded-lg bg-primary-500 hover:bg-primary-400 text-white transition-colors"
                        >
                            Register
                        </Link>
                    </div>
                    <div v-else class="mt-4 text-center">
                        <p class="text-text-muted text-sm">
                            Current route: <code class="px-2 py-1 bg-surface-50 dark:bg-surface-200 rounded border border-border">{{ welcome.url() }}</code>
                        </p>
                        <p v-if="isWelcomePage" class="text-primary-500 text-sm mt-2">
                            ✓ You are on the welcome page
                        </p>
                    </div>
                </div>

                <div v-if="auth.user" class="bg-surface-0 dark:bg-surface-100 rounded-lg p-6 border border-border transition-colors duration-200">
                    <p class="text-text-primary">
                        Welcome back, <strong>{{ auth.user.name }}</strong>!
                    </p>
                    <p class="text-text-muted text-sm mt-2">
                        {{ auth.user.email }}
                    </p>
                    <p>
                        <Link
                            :href="dashboard.url()"
                            class="inline-flex px-4 py-2 rounded-lg bg-primary-500 hover:bg-primary-400 text-white transition-colors"
                        >
                            Go to Dashboard
                        </Link>
                    </p>
                </div>
                <div v-else class="bg-surface-0 dark:bg-surface-100 rounded-lg p-6 border border-border transition-colors duration-200">
                    <p class="text-text-muted">
                        You are not logged in.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

