import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { createSSRApp, h } from 'vue';
import { renderToString } from 'vue/server-renderer';
import { ZiggyVue } from 'ziggy-js';
import { resolveView } from './lib/helpers';

const appName = import.meta.env.VITE_APP_NAME || 'LaraVibe-Vue';

createServer(
    (page) =>
        createInertiaApp({
            page,
            render: renderToString,
            title: (title) => (title ? `${title} - ${appName}` : appName),
            resolve: (name) => resolveView(name),
            setup: ({ App, props, plugin }) =>
                createSSRApp({ render: () => h(App, props) })
                    .use(plugin)
                    .use(ZiggyVue, {
                        ...page.props.ziggy,
                        location: new URL(page.props.ziggy.location),
                    }),
        }),
    { cluster: true },
);
