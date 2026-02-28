import { usePage } from '@inertiajs/vue3';

/**
 * Enhanced route helper that automatically includes locale
 */
export function useRoute() {
    const page = usePage();

    return (name, params = {}, absolute = true) => {
        const locale = page.props.locale || 'uk';

        // If params doesn't have locale, add it
        if (!params.locale) {
            params = { locale, ...params };
        }

        return window.route(name, params, absolute);
    };
}

/**
 * Global route helper with automatic locale injection
 */
export function setupRouteHelper(app) {
    app.config.globalProperties.$route = function(name, params = {}, absolute = true) {
        const page = usePage();
        const locale = page.props.locale || 'uk';

        // If params doesn't have locale, add it
        if (!params.locale) {
            params = { locale, ...params };
        }

        return window.route(name, params, absolute);
    };
}
