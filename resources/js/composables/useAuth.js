import { computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { logout as logoutRoute } from '@/routes';

/**
 * Composable for authentication state and actions
 * 
 * @returns {Object} Authentication composable
 * @returns {import('vue').ComputedRef<Object|null>} user - Current authenticated user
 * @returns {import('vue').ComputedRef<boolean>} isAuthenticated - Whether user is authenticated
 * @returns {Function} logout - Function to log out the user
 * 
 * @example
 * const { user, isAuthenticated, logout } = useAuth();
 * 
 * if (isAuthenticated.value) {
 *   console.log(user.value.name);
 * }
 * 
 * logout();
 */
export function useAuth() {
    const page = usePage();

    /**
     * Current authenticated user
     * @type {import('vue').ComputedRef<Object|null>}
     */
    const user = computed(() => page.props.auth?.user ?? null);

    /**
     * Whether the user is authenticated
     * @type {import('vue').ComputedRef<boolean>}
     */
    const isAuthenticated = computed(() => !!user.value);

    /**
     * Log out the current user
     * Posts to the logout route and redirects
     */
    const logout = () => {
        router.post(logoutRoute.url());
    };

    return {
        user,
        isAuthenticated,
        logout,
    };
}

