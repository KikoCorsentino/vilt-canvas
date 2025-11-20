<script setup>
import { ref, computed, onMounted } from 'vue';

/**
 * Light/Dark mode toggle button component
 * Manages theme preference in localStorage and applies to <html> element
 */

/** LocalStorage key for theme preference */
const STORAGE_KEY = 'theme-preference';

/**
 * Gets initial theme from localStorage or defaults to 'light'
 * Handles SSR by checking for window object
 * @returns {string} 'light' or 'dark'
 */
const getInitialTheme = () => {
    if (typeof window === 'undefined') {
        return 'light';
    }
    const stored = localStorage.getItem(STORAGE_KEY);
    return stored === 'dark' ? 'dark' : 'light';
};

/** Current theme state */
const theme = ref(getInitialTheme());

/**
 * Applies theme class to <html> element
 * Removes both light and dark classes before adding new one
 * @param {string} newTheme - 'light' or 'dark'
 */
const applyTheme = (newTheme) => {
    if (typeof document === 'undefined') {
        return;
    }

    const html = document.documentElement;
    html.classList.remove('light', 'dark');
    html.classList.add(newTheme);
};

/**
 * Initialize theme on component mount
 * Ensures theme is applied even if localStorage was set before component loaded
 */
onMounted(() => {
    applyTheme(theme.value);
});

/**
 * Toggles between light and dark themes
 * Updates state, applies to DOM, and persists to localStorage
 */
const toggle = () => {
    theme.value = theme.value === 'light' ? 'dark' : 'light';
    applyTheme(theme.value);
    
    // Store preference in localStorage
    if (typeof window !== 'undefined') {
        localStorage.setItem(STORAGE_KEY, theme.value);
    }
};

/** Computed property indicating if dark mode is active */
const isDark = computed(() => theme.value === 'dark');

/** Computed accessibility label for the toggle button */
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

