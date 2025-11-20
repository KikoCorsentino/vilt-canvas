<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import ErrorLayout from '@/Layouts/ErrorLayout.vue';
import Button from '@/Components/Button.vue';
import { welcome } from '@/routes';

defineProps({
    status: {
        type: Number,
        default: 404,
    },
});

const goBack = () => {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        router.visit(welcome.url());
    }
};
</script>

<template>
    <Head title="404 - Page Not Found" />

    <ErrorLayout>
        <div class="space-y-6">
            <div class="space-y-2">
                <h1 class="text-6xl font-bold text-primary-500">
                    404
                </h1>
                <h2 class="text-2xl font-semibold text-text-primary">
                    Page Not Found
                </h2>
                <p class="text-text-muted">
                    Sorry, we couldn't find the page you're looking for. The page may have been moved, deleted, or the URL might be incorrect.
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
                    @click="goBack"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-medium text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 focus:ring-offset-surface-100 dark:focus:ring-offset-surface-300 bg-surface-200 text-text-primary hover:bg-surface-300"
                >
                    Go Back
                </button>
            </div>
        </div>
    </ErrorLayout>
</template>

