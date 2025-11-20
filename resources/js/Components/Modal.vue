<script setup>
import { computed, watch, onMounted, onUnmounted } from 'vue';

/**
 * Modal component with backdrop, keyboard, and click-outside support
 * Uses Teleport to render outside component tree
 * Prevents body scroll when open
 */
const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg', 'xl', '2xl'].includes(value),
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['close']);

/**
 * Computed Tailwind max-width class based on maxWidth prop
 */
const maxWidthClass = computed(() => {
    return {
        sm: 'max-w-sm',
        md: 'max-w-md',
        lg: 'max-w-lg',
        xl: 'max-w-xl',
        '2xl': 'max-w-2xl',
    }[props.maxWidth];
});

/**
 * Closes modal if closeable
 * Emits close event to parent component
 */
const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

/**
 * Handles Escape key press to close modal
 */
const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

/**
 * Handles backdrop click to close modal
 * Only closes if click is directly on backdrop (not modal content)
 */
const closeOnBackdropClick = (e) => {
    if (e.target === e.currentTarget && props.closeable) {
        close();
    }
};

onMounted(() => {
    document.addEventListener('keydown', closeOnEscape);
});

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
});

/**
 * Watches show prop to prevent body scroll when modal is open
 * Sets overflow: hidden on body when modal opens, restores when closed
 */
watch(
    () => props.show,
    (show) => {
    if (show) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
    },
);
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-show="show"
                class="fixed inset-0 z-50 overflow-y-auto bg-overlay backdrop-blur-xs transition-colors duration-200"
                aria-labelledby="modal-title"
                role="dialog"
                aria-modal="true"
                @click="closeOnBackdropClick"
            >
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <Transition
                        enter-active-class="ease-out duration-300"
                        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-active-class="ease-in duration-200"
                        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <div
                            v-show="show"
                            :class="[
                                'relative transform overflow-hidden rounded-lg bg-surface-100 dark:bg-surface-300 text-left shadow-xl transition-all w-full transition-colors duration-200',
                                maxWidthClass,
                            ]"
                            @click.stop
                        >
                            <div class="bg-surface-100 dark:bg-surface-300 px-4 pb-4 pt-5 sm:p-6 transition-colors duration-200">
                                <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                                    <button
                                        v-if="closeable"
                                        type="button"
                                        class="rounded-lg text-text-muted hover:text-text-primary focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 focus:ring-offset-surface-100 dark:focus:ring-offset-surface-300"
                                        @click="close"
                                    >
                                        <span class="sr-only">Close</span>
                                        <svg
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12"
                                            />
                                        </svg>
                                    </button>
                                </div>
                                <slot />
                            </div>
                        </div>
                    </Transition>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

