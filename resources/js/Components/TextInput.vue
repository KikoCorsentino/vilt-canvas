<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: '',
    },
    type: {
        type: String,
        default: 'text',
        validator: (value) =>
            ['text', 'email', 'password', 'number', 'tel', 'url', 'search'].includes(value),
    },
    id: {
        type: String,
        default: null,
    },
    required: {
        type: Boolean,
        default: false,
    },
    autofocus: {
        type: Boolean,
        default: false,
    },
    placeholder: {
        type: String,
        default: '',
    },
    error: {
        type: String,
        default: null,
    },
    errorId: {
        type: String,
        default: null,
    },
});

const emit = defineEmits(['update:modelValue']);

const inputId = computed(() => props.id || `input-${Math.random().toString(36).substr(2, 9)}`);

const updateValue = (event) => {
    emit('update:modelValue', event.target.value);
};
</script>

<template>
    <input
        :id="inputId"
        :type="type"
        :value="modelValue"
        :required="required"
        :autofocus="autofocus"
        :placeholder="placeholder"
        :aria-invalid="error ? 'true' : 'false'"
        :aria-describedby="error ? (errorId || `${inputId}-error`) : null"
        :class="[
            'block w-full rounded-lg border px-3 py-2 text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-0',
            error
                ? 'border-red-500 bg-surface-100 text-text-primary focus:border-red-500 focus:ring-red-500 dark:border-red-500 dark:bg-surface-300 dark:focus:ring-red-500'
                : 'border-border bg-surface-100 text-text-primary placeholder:text-text-muted focus:border-primary-500 focus:ring-ring/20 dark:bg-surface-300 dark:placeholder:text-text-muted',
        ]"
        @input="updateValue"
    />
</template>

