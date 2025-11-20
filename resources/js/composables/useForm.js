import { useForm as useInertiaForm } from '@inertiajs/vue3';

/**
 * Enhanced form composable wrapper around Inertia's useForm
 * Provides common patterns and helper methods
 * 
 * @param {Object} initialData - Initial form data
 * @param {Object} options - Form options
 * @param {boolean} options.preserveScroll - Preserve scroll position on submit (default: true)
 * @param {boolean} options.resetOnSuccess - Reset form on successful submission (default: false)
 * @param {string[]} options.resetFields - Fields to reset on success (default: [])
 * 
 * @returns {Object} Enhanced form object with additional helper methods
 * 
 * @example
 * const form = useForm({
 *   name: '',
 *   email: '',
 * }, {
 *   preserveScroll: true,
 *   resetOnSuccess: true,
 *   resetFields: ['password', 'password_confirmation']
 * });
 * 
 * form.submit('post', '/users', {
 *   onSuccess: () => {
 *     // Form will auto-reset if resetOnSuccess is true
 *   }
 * });
 * 
 * // Clear all errors
 * form.clearErrors();
 * 
 * // Check if form has specific error
 * if (form.hasError('email')) {
 *   // Handle email error
 * }
 */
export function useForm(initialData = {}, options = {}) {
    const {
        preserveScroll = true,
        resetOnSuccess = false,
        resetFields = [],
    } = options;

    /**
     * Base Inertia form instance
     */
    const form = useInertiaForm(initialData);

    /**
     * Enhanced submit method with common options
     * 
     * @param {string} method - HTTP method (get, post, put, patch, delete)
     * @param {string|Object} url - URL or route object
     * @param {Object} submitOptions - Additional submit options
     */
    const submit = (method, url, submitOptions = {}) => {
        const defaultOptions = {
            preserveScroll,
            onSuccess: () => {
                if (resetOnSuccess) {
                    if (resetFields.length > 0) {
                        form.reset(...resetFields);
                    } else {
                        form.reset();
                    }
                }
                if (submitOptions.onSuccess) {
                    submitOptions.onSuccess();
                }
            },
        };

        const mergedOptions = { ...defaultOptions, ...submitOptions };

        switch (method.toLowerCase()) {
            case 'get':
                form.get(url, mergedOptions);
                break;
            case 'post':
                form.post(url, mergedOptions);
                break;
            case 'put':
                form.put(url, mergedOptions);
                break;
            case 'patch':
                form.patch(url, mergedOptions);
                break;
            case 'delete':
                form.delete(url, mergedOptions);
                break;
            default:
                form.post(url, mergedOptions);
        }
    };

    /**
     * Check if form has a specific error
     * 
     * @param {string} field - Field name to check
     * @returns {boolean} Whether the field has an error
     */
    const hasError = (field) => {
        return !!form.errors[field];
    };

    /**
     * Get error message for a specific field
     * 
     * @param {string} field - Field name
     * @returns {string|null} Error message or null
     */
    const getError = (field) => {
        return form.errors[field] ?? null;
    };

    /**
     * Clear all form errors
     */
    const clearErrors = () => {
        form.clearErrors();
    };

    /**
     * Clear error for a specific field
     * 
     * @param {string} field - Field name
     */
    const clearError = (field) => {
        form.clearErrors(field);
    };

    /**
     * Set error for a specific field
     * 
     * @param {string} field - Field name
     * @param {string} message - Error message
     */
    const setError = (field, message) => {
        form.setError(field, message);
    };

    /**
     * Check if form has any errors
     * 
     * @returns {boolean} Whether form has any errors
     */
    const hasErrors = () => {
        return Object.keys(form.errors).length > 0;
    };

    /**
     * Check if form is dirty (has been modified)
     * 
     * @returns {boolean} Whether form is dirty
     */
    const isDirty = () => {
        return form.isDirty;
    };

    /**
     * Reset form to initial values
     * 
     * @param {string[]} fields - Optional fields to reset
     */
    const resetForm = (...fields) => {
        if (fields.length > 0) {
            form.reset(...fields);
        } else {
            form.reset();
        }
    };

    return {
        ...form,
        submit,
        hasError,
        getError,
        clearErrors,
        clearError,
        setError,
        hasErrors,
        isDirty,
        reset: resetForm,
    };
}

