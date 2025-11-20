<script setup>
import { computed } from 'vue';

/**
 * Error message component for form validation
 * Displays error messages with proper ARIA attributes for accessibility
 */
const props = defineProps({
    message: {
        type: String,
        default: null,
    },
    id: {
        type: String,
        default: null,
    },
});

/**
 * Generates unique ID for error element if not provided
 * Used for associating error with input via aria-describedby
 */
const errorId = computed(() => props.id || `error-${Math.random().toString(36).substr(2, 9)}`);
</script>

<template>
    <p
        v-if="message"
        :id="errorId"
               class="mt-1 text-sm text-primary-600"
        role="alert"
    >
        {{ message }}
    </p>
</template>

