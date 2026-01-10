import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h } from 'vue';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { Head } from '@inertiajs/vue3';
import { clickAway } from './directives/clickAway';

const appName = import.meta.env.VITE_APP_NAME || 'EduCore';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('Head', Head)
            .use(ZiggyVue)
            .directive('click-away', clickAway)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
        showSpinner: true,
    },
});
