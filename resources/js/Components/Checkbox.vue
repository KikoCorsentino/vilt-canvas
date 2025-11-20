<script setup>
import { computed } from 'vue';

/**
 * Checkbox component with label support and accessibility features
 * Supports v-model two-way binding
 */
const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false,
    },
    id: {
        type: String,
        default: null,
    },
    value: {
        type: [String, Number, Boolean],
        default: true,
    },
    required: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['update:modelValue']);

/**
 * Generates unique ID for checkbox if not provided
 * Used for associating label with checkbox
 */
const checkboxId = computed(() => props.id || `checkbox-${Math.random().toString(36).substr(2, 9)}`);

/**
 * Computed checked state
 * Checks if modelValue matches the checkbox value
 */
const isChecked = computed(() => props.modelValue === props.value);

/**
 * Updates checkbox value and emits to parent
 * Sets modelValue to props.value when checked, false when unchecked
 */
const updateValue = (event) => {
    emit('update:modelValue', event.target.checked ? props.value : false);
};
</script>

<template>
    <div class="flex items-center">
        <input
            :id="checkboxId"
            type="checkbox"
            :checked="isChecked"
            :value="value"
            :required="required"
            :disabled="disabled"
            :aria-required="required"
            :aria-disabled="disabled"
            :class="[
                'h-4 w-4 rounded border-border text-primary-600 focus:ring-2 focus:ring-ring focus:ring-offset-0 transition-colors disabled:opacity-50 disabled:cursor-not-allowed bg-surface-100 dark:bg-surface-300 dark:checked:bg-primary-500',
            ]"
            @change="updateValue"
        />
        <label
            v-if="$slots.default"
            :for="checkboxId"
            class="ml-2 text-sm text-text-primary cursor-pointer"
        >
            <slot />
        </label>
    </div>
</template>

