<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ErrorLayout from '@/Layouts/ErrorLayout.vue';
import Button from '@/Components/Button.vue';
import { welcome } from '@/routes';

defineProps({
    status: {
        type: Number,
        default: 500,
    },
    message: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <Head title="500 - Server Error" />

    <ErrorLayout>
        <div class="space-y-6">
            <div class="space-y-2">
                <h1 class="text-6xl font-bold text-primary-500">
                    500
                </h1>
                <h2 class="text-2xl font-semibold text-text-primary">
                    Server Error
                </h2>
                <p class="text-text-muted">
                    <span v-if="message">{{ message }}</span>
                    <span v-else>
                        Something went wrong on our end. We've been notified and are working to fix the issue. Please try again later.
                    </span>
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <Link :href="welcome.url()">
                    <Button variant="primary">
                        Go to Home
                    </Button>
                </Link>
                <button
                    type="button"
                    @click="window.location.reload()"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-medium text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 focus:ring-offset-surface-100 dark:focus:ring-offset-surface-300 bg-surface-200 text-text-primary hover:bg-surface-300"
                >
                    Refresh Page
                </button>
            </div>
        </div>
    </ErrorLayout>
</template>

