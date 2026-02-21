import { computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

/**
 * Composable for locale management
 *
 * Usage:
 * const { locale, switchLocale, localizedRoute } = useLocale();
 */
export function useLocale() {
    const page = usePage();

    const locale = computed(() => page.props.locale || 'uk');

    /**
     * Switch to a different locale
     * @param {string} newLocale - The locale to switch to (e.g., 'en', 'uk')
     */
    const switchLocale = (newLocale) => {
        router.post(route('locale.switch'), {
            locale: newLocale,
        }, {
            preserveState: false,
            preserveScroll: false,
        });
    };

    /**
     * Generate a localized route
     * @param {string} name - Route name
     * @param {object} params - Route parameters
     * @returns {string}
     */
    const localizedRoute = (name, params = {}) => {
        return route(name, { locale: locale.value, ...params });
    };

    return {
        locale,
        switchLocale,
        localizedRoute,
    };
}
