import { computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import * as routes from '@/routes';

/**
 * Composable for working with Wayfinder routes
 * Provides a clean interface for route generation and checking
 * 
 * Note: For nested routes (e.g., password routes), import them directly:
 * import { request as forgotPassword } from '@/routes/password';
 * 
 * @returns {Object} Route composable
 * @returns {Function} route - Generate URL for a route from main routes
 * @returns {Function} current - Check if current route matches a route name
 * @returns {Function} has - Check if a route exists in main routes
 * @returns {Function} visit - Visit a route
 * @returns {import('vue').ComputedRef<string|null>} currentRouteName - Current route name
 * @returns {import('vue').ComputedRef<string>} currentUrl - Current URL
 * 
 * @example
 * const { route, current, has, visit } = useRoute();
 * 
 * // Generate URL for routes in @/routes
 * const loginUrl = route('login');
 * const welcomeUrl = route('welcome');
 * 
 * // Check if current route
 * if (current('dashboard')) {
 *   // On dashboard page
 * }
 * 
 * // Check if route exists
 * if (has('login')) {
 *   // Route exists
 * }
 * 
 * // Visit a route
 * visit('welcome');
 * 
 * // For nested routes, import directly:
 * import { request } from '@/routes/password';
 * const url = request.url();
 */
export function useRoute() {
    const page = usePage();

    /**
     * Current route name from page props
     * @type {import('vue').ComputedRef<string|null>}
     */
    const currentRouteName = computed(() => page.props.routeName ?? null);

    /**
     * Current route URL
     * @type {import('vue').ComputedRef<string>}
     */
    const currentUrl = computed(() => {
        if (typeof window !== 'undefined') {
            return window.location.pathname;
        }
        return '';
    });

    /**
     * Generate URL for a route from the main routes object
     * For nested routes, import them directly from their module
     * 
     * @param {string} name - Route name (e.g., 'login', 'welcome')
     * @param {Object} options - Route options (query, mergeQuery)
     * @returns {string} Generated URL
     * 
     * @example
     * route('login') // '/login'
     * route('welcome', { query: { page: 1 } }) // '/?page=1'
     */
    const route = (name, options = {}) => {
        const routeFunction = routes[name];

        if (!routeFunction) {
            console.warn(`Route "${name}" not found in main routes. For nested routes, import them directly.`);
            return '#';
        }

        if (typeof routeFunction === 'function') {
            const routeDef = routeFunction(options);
            return routeDef.url ?? routeDef;
        }

        if (routeFunction && typeof routeFunction.url === 'function') {
            return routeFunction.url(options);
        }

        return '#';
    };

    /**
     * Check if current route matches a route name
     * 
     * @param {string} name - Route name to check
     * @returns {boolean} Whether current route matches
     * 
     * @example
     * if (current('dashboard')) {
     *   // On dashboard
     * }
     */
    const current = (name) => {
        return currentRouteName.value === name;
    };

    /**
     * Check if a route exists in main routes
     * 
     * @param {string} name - Route name to check
     * @returns {boolean} Whether route exists
     * 
     * @example
     * if (has('login')) {
     *   // Route exists
     * }
     */
    const has = (name) => {
        return name in routes && typeof routes[name] === 'function';
    };

    /**
     * Visit a route using Inertia
     * 
     * @param {string} name - Route name from main routes
     * @param {Object} options - Inertia visit options
     * 
     * @example
     * visit('welcome');
     * visit('login', { preserveState: true });
     */
    const visit = (name, options = {}) => {
        const url = route(name);
        if (url && url !== '#') {
            router.visit(url, options);
        }
    };

    return {
        route,
        current,
        has,
        visit,
        currentRouteName,
        currentUrl,
    };
}

