<script setup>
import { computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'info',
        validator: (value) => ['success', 'error', 'warning', 'info'].includes(value),
    },
    message: {
        type: String,
        default: '',
    },
    dismissible: {
        type: Boolean,
        default: true,
    },
    autoDismiss: {
        type: Boolean,
        default: false,
    },
    autoDismissDelay: {
        type: Number,
        default: 5000,
    },
});

const emit = defineEmits(['close']);

const toneMap = {
    success: { hue: 'calc(var(--primary-h) + 120)' },
    error: { hue: 'calc(var(--primary-h) - 40)' },
    warning: { hue: 'calc(var(--primary-h) + 60)' },
    info: { hue: 'var(--primary-h)' },
};

const buildColor = (hue, saturation, lightness) => `hsl(${hue} ${saturation} ${lightness})`;

const alertStyle = computed(() => {
    const tone = toneMap[props.type] || toneMap.info;
    return {
        '--alert-bg': buildColor(tone.hue, '55%', '95%'),
        '--alert-border': buildColor(tone.hue, '55%', '80%'),
        '--alert-text': buildColor(tone.hue, '45%', '30%'),
        '--alert-icon': buildColor(tone.hue, '60%', '45%'),
        '--alert-hover': buildColor(tone.hue, '50%', '90%'),
    };
});

const alertClasses = computed(
    () =>
        'rounded-lg p-4 border transition-colors duration-200 bg-[var(--alert-bg)] border-[var(--alert-border)] text-[var(--alert-text)]',
);

const iconClasses = computed(() => 'text-[var(--alert-icon)]');

const icons = {
    success: 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    error: 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    warning: 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z',
    info: 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z',
};

let autoDismissTimer = null;

const close = () => {
    emit('close');
};

const startAutoDismiss = () => {
    if (props.autoDismiss && props.dismissible) {
        autoDismissTimer = setTimeout(() => {
            close();
        }, props.autoDismissDelay);
    }
};

onMounted(() => {
    startAutoDismiss();
});

onUnmounted(() => {
    if (autoDismissTimer) {
        clearTimeout(autoDismissTimer);
    }
});
</script>

<template>
    <Transition
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-2"
    >
        <div v-if="message" :class="alertClasses" :style="alertStyle" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg
                        class="h-5 w-5"
                        :class="iconClasses"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            v-if="type === 'success'"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            :d="icons.success"
                        />
                        <path
                            v-else-if="type === 'error'"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            :d="icons.error"
                        />
                        <path
                            v-else-if="type === 'warning'"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            :d="icons.warning"
                        />
                        <path
                            v-else
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            :d="icons.info"
                        />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-[var(--alert-text)]">
                        <slot>{{ message }}</slot>
                    </p>
                </div>
                <div v-if="dismissible" class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button
                            type="button"
                            :class="[
                                'inline-flex rounded-lg p-1.5 text-[var(--alert-icon)] hover:bg-[var(--alert-hover)] focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 focus:ring-offset-surface-100 dark:focus:ring-offset-surface-300 transition-colors duration-200',
                            ]"
                            @click="close"
                        >
                            <span class="sr-only">Dismiss</span>
                            <svg
                                class="h-5 w-5"
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
                </div>
            </div>
        </div>
    </Transition>
</template>

