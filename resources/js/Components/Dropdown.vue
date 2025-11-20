<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    align: {
        type: String,
        default: 'right',
        validator: (value) => ['left', 'right'].includes(value),
    },
    verticalAlign: {
        type: String,
        default: 'bottom',
        validator: (value) => ['top', 'bottom'].includes(value),
    },
    width: {
        type: String,
        default: '48',
        validator: (value) => ['48', '56', '64', '72', '80'].includes(value),
    },
});

const emit = defineEmits(['close']);

const open = ref(false);
const trigger = ref(null);
const content = ref(null);

const widthClass = computed(() => {
    return `w-${props.width}`;
});

const alignmentClasses = computed(() => {
    const horizontal = props.align === 'left' ? 'left-0' : 'right-0';
    
    if (props.verticalAlign === 'top') {
        const origin = props.align === 'left' ? 'origin-bottom-left' : 'origin-bottom-right';
        return `bottom-full mb-2 ${horizontal} ${origin}`;
    }
    
    // Default: bottom alignment
    const origin = props.align === 'left' ? 'origin-top-left' : 'origin-top-right';
    return `top-full mt-2 ${horizontal} ${origin}`;
});

const closeDropdown = () => {
    open.value = false;
    emit('close');
};

const toggleDropdown = () => {
    open.value = !open.value;
};

const handleClickOutside = (event) => {
    if (
        open.value &&
        trigger.value &&
        content.value &&
        !trigger.value.contains(event.target) &&
        !content.value.contains(event.target)
    ) {
        closeDropdown();
    }
};

const handleEscape = (event) => {
    if (event.key === 'Escape' && open.value) {
        closeDropdown();
    }
};

const handleArrowKeys = (event) => {
    if (!open.value) {
        return;
    }

    const focusableElements = content.value?.querySelectorAll(
        'a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])',
    );
    if (!focusableElements || focusableElements.length === 0) {
        return;
    }

    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];
    const currentIndex = Array.from(focusableElements).indexOf(document.activeElement);

    if (event.key === 'ArrowDown') {
        event.preventDefault();
        if (currentIndex === -1 || currentIndex === focusableElements.length - 1) {
            firstElement.focus();
        } else {
            focusableElements[currentIndex + 1].focus();
        }
    } else if (event.key === 'ArrowUp') {
        event.preventDefault();
        if (currentIndex === -1 || currentIndex === 0) {
            lastElement.focus();
        } else {
            focusableElements[currentIndex - 1].focus();
        }
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
    document.addEventListener('keydown', handleEscape);
    document.addEventListener('keydown', handleArrowKeys);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
    document.removeEventListener('keydown', handleEscape);
    document.removeEventListener('keydown', handleArrowKeys);
});
</script>

<template>
    <div class="relative">
        <div ref="trigger" @click="toggleDropdown">
            <slot name="trigger" :open="open" />
        </div>

        <Transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <div
                v-show="open"
                ref="content"
                :class="[
                    'absolute z-50 mt-2 rounded-lg shadow-lg bg-surface-100 dark:bg-surface-300 border border-border py-1 focus:outline-none transition-colors duration-200',
                    widthClass,
                    alignmentClasses,
                ]"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="dropdown-button"
            >
                <slot name="content" :close="closeDropdown" />
            </div>
        </Transition>
    </div>
</template>

