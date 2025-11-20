<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col items-center justify-center bg-surface-50 dark:bg-surface-300 px-4">
        <div class="max-w-md w-full text-center">
            <div class="mb-8 flex justify-center">
                <ApplicationLogo class="h-12" />
            </div>

            <slot />
        </div>
    </div>
</template>

