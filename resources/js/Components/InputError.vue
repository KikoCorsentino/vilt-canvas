<script setup>
import { computed } from 'vue';

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

const errorId = computed(() => props.id || `error-${Math.random().toString(36).substr(2, 9)}`);
</script>

<template>
    <p
        v-if="message"
        :id="errorId"
               class="mt-1 text-sm text-red-500"
        role="alert"
    >
        {{ message }}
    </p>
</template>

