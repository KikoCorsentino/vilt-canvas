import { ref } from 'vue';

/**
 * Composable for managing modal state
 * 
 * @returns {Object} Modal state composable
 * @returns {import('vue').Ref<boolean>} isOpen - Whether the modal is open
 * @returns {Function} open - Open the modal
 * @returns {Function} close - Close the modal
 * @returns {Function} toggle - Toggle the modal state
 * 
 * @example
 * const { isOpen, open, close, toggle } = useModal();
 * 
 * // Open modal
 * open();
 * 
 * // Close modal
 * close();
 * 
 * // Toggle modal
 * toggle();
 * 
 * // Use in template
 * <Modal :show="isOpen" @close="close">
 *   Modal content
 * </Modal>
 */
export function useModal(initialState = false) {
    /**
     * Whether the modal is currently open
     * @type {import('vue').Ref<boolean>}
     */
    const isOpen = ref(initialState);

    /**
     * Open the modal
     */
    const open = () => {
        isOpen.value = true;
    };

    /**
     * Close the modal
     */
    const close = () => {
        isOpen.value = false;
    };

    /**
     * Toggle the modal state
     */
    const toggle = () => {
        isOpen.value = !isOpen.value;
    };

    return {
        isOpen,
        open,
        close,
        toggle,
    };
}

