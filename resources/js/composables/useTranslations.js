import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

/**
 * Composable for accessing translations in Vue components
 *
 * Usage:
 * const { t, trans } = useTranslations();
 * const welcomeTitle = t('welcome.title');
 * const navHome = trans('nav.home');
 */
export function useTranslations() {
    const page = usePage();

    const translations = computed(() => page.props.translations || {});

    /**
     * Get a translation by key using dot notation
     * @param {string} key - The translation key (e.g., 'welcome.title')
     * @param {string} defaultValue - Default value if translation not found
     * @returns {string}
     */
    const t = (key, defaultValue = '') => {
        const keys = key.split('.');
        let value = translations.value;

        for (const k of keys) {
            if (value && typeof value === 'object' && k in value) {
                value = value[k];
            } else {
                return defaultValue || key;
            }
        }

        return value || defaultValue || key;
    };

    /**
     * Alias for t() function
     */
    const trans = t;

    return {
        t,
        trans,
        translations,
    };
}
