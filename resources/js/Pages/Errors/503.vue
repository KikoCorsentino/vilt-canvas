<script setup>
import { Head } from '@inertiajs/vue3';
import ErrorLayout from '@/Layouts/ErrorLayout.vue';

defineProps({
    status: {
        type: Number,
        default: 503,
    },
    message: {
        type: String,
        default: null,
    },
    retryAfter: {
        type: Number,
        default: null,
    },
});
</script>

<template>
    <Head title="503 - Service Unavailable" />

    <ErrorLayout>
        <div class="space-y-6">
            <div class="space-y-2">
                <h1 class="text-6xl font-bold text-primary-500">
                    503
                </h1>
                <h2 class="text-2xl font-semibold text-text-primary">
                    Service Unavailable
                </h2>
                <p class="text-text-muted">
                    <span v-if="message">{{ message }}</span>
                    <span v-else>
                        We're currently performing maintenance. Please check back shortly.
                    </span>
                </p>
                <p v-if="retryAfter" class="text-sm text-text-muted">
                    Service should be available again in {{ retryAfter }} seconds.
                </p>
            </div>

            <div class="flex justify-center">
                <button
                    type="button"
                    @click="window.location.reload()"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-medium text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 focus:ring-offset-surface-100 dark:focus:ring-offset-surface-300 bg-primary-500 text-white hover:bg-primary-400"
                >
                    <svg
                        class="h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                        />
                    </svg>
                    Refresh Page
                </button>
            </div>
        </div>
    </ErrorLayout>
</template>

