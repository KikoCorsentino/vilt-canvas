import { computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

/**
 * Composable for managing flash messages
 * 
 * @returns {Object} Flash messages composable
 * @returns {import('vue').ComputedRef<Object>} flash - Flash messages object
 * @returns {import('vue').ComputedRef<string|null>} success - Success message
 * @returns {import('vue').ComputedRef<string|null>} error - Error message
 * @returns {import('vue').ComputedRef<string|null>} warning - Warning message
 * @returns {import('vue').ComputedRef<string|null>} info - Info message
 * @returns {Function} clearFlash - Clear all flash messages
 * @returns {Function} setSuccess - Set a success message
 * @returns {Function} setError - Set an error message
 * @returns {Function} setWarning - Set a warning message
 * @returns {Function} setInfo - Set an info message
 * 
 * @example
 * const { success, error, clearFlash, setSuccess } = useFlash();
 * 
 * if (success.value) {
 *   console.log(success.value);
 * }
 * 
 * setSuccess('Operation completed!');
 * clearFlash();
 */
export function useFlash() {
    const page = usePage();

    /**
     * Flash messages object from page props
     * @type {import('vue').ComputedRef<Object>}
     */
    const flash = computed(() => page.props.flash ?? {});

    /**
     * Success message
     * @type {import('vue').ComputedRef<string|null>}
     */
    const success = computed(() => flash.value?.success ?? null);

    /**
     * Error message
     * @type {import('vue').ComputedRef<string|null>}
     */
    const error = computed(() => flash.value?.error ?? null);

    /**
     * Warning message
     * @type {import('vue').ComputedRef<string|null>}
     */
    const warning = computed(() => flash.value?.warning ?? null);

    /**
     * Info message
     * @type {import('vue').ComputedRef<string|null>}
     */
    const info = computed(() => flash.value?.info ?? null);

    /**
     * Clear all flash messages by visiting the current page
     * This removes flash messages from the session
     */
    const clearFlash = () => {
        router.reload({ only: [] });
    };

    /**
     * Set a success flash message
     * Note: This requires server-side support to persist the message
     * 
     * @param {string} message - Success message to display
     */
    const setSuccess = (message) => {
        // Flash messages are typically set server-side
        // This is a placeholder for client-side usage if needed
        router.reload({
            only: [],
            data: { flash: { success: message } },
        });
    };

    /**
     * Set an error flash message
     * Note: This requires server-side support to persist the message
     * 
     * @param {string} message - Error message to display
     */
    const setError = (message) => {
        router.reload({
            only: [],
            data: { flash: { error: message } },
        });
    };

    /**
     * Set a warning flash message
     * Note: This requires server-side support to persist the message
     * 
     * @param {string} message - Warning message to display
     */
    const setWarning = (message) => {
        router.reload({
            only: [],
            data: { flash: { warning: message } },
        });
    };

    /**
     * Set an info flash message
     * Note: This requires server-side support to persist the message
     * 
     * @param {string} message - Info message to display
     */
    const setInfo = (message) => {
        router.reload({
            only: [],
            data: { flash: { info: message } },
        });
    };

    return {
        flash,
        success,
        error,
        warning,
        info,
        clearFlash,
        setSuccess,
        setError,
        setWarning,
        setInfo,
    };
}

