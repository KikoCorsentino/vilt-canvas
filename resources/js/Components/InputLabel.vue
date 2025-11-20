<script setup>
/**
 * Label component for form inputs
 * Supports required indicator and slot content
 */
defineProps({
    value: {
        type: String,
        default: '',
    },
    for: {
        type: String,
        default: null,
    },
    required: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <label
        :for="for"
        class="block text-sm font-medium text-text-primary mb-1"
    >
        <slot>{{ value }}</slot>
        <span v-if="required" class="text-primary-500 ml-1" aria-label="required"
            >*</span
        >
    </label>
</template>

