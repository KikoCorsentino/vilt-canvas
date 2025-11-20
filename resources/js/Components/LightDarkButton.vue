<script setup>
import { ref, computed, onMounted } from 'vue';

const STORAGE_KEY = 'theme-preference';

// Get initial theme from localStorage or default to 'light'
const getInitialTheme = () => {
    if (typeof window === 'undefined') {
        return 'light';
    }
    const stored = localStorage.getItem(STORAGE_KEY);
    return stored === 'dark' ? 'dark' : 'light';
};

const theme = ref(getInitialTheme());

// Apply theme to <html> element
const applyTheme = (newTheme) => {
    if (typeof document === 'undefined') {
        return;
    }

    const html = document.documentElement;
    html.classList.remove('light', 'dark');
    html.classList.add(newTheme);
};

// Initialize theme on mount
onMounted(() => {
    applyTheme(theme.value);
});

// Toggle between light and dark
const toggle = () => {
    theme.value = theme.value === 'light' ? 'dark' : 'light';
    applyTheme(theme.value);
    
    // Store preference in localStorage
    if (typeof window !== 'undefined') {
        localStorage.setItem(STORAGE_KEY, theme.value);
    }
};

const isDark = computed(() => theme.value === 'dark');
const themeLabel = computed(() => isDark.value ? 'Switch to light mode' : 'Switch to dark mode');
</script>

<template>
    <button
        type="button"
        @click="toggle"
        :aria-label="themeLabel"
        :title="themeLabel"
        class="inline-flex items-center justify-center p-2 rounded-lg text-text-muted hover:text-text-primary hover:bg-surface-200 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 focus:ring-offset-surface-100 dark:focus:ring-offset-surface-300 transition-colors duration-200"
    >
        <!-- Sun Icon (Light Mode) -->
        <svg
            v-if="isDark"
            class="h-5 w-5 transition-all duration-300"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
        >
            <path
                fill-rule="evenodd"
                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                clip-rule="evenodd"
            />
        </svg>

        <!-- Moon Icon (Dark Mode) -->
        <svg
            v-else
            class="h-5 w-5 transition-all duration-300"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
        >
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
        </svg>
    </button>
</template>

