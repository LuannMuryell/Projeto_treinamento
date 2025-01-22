import '../css/app.css';
import './bootstrap';

import { ref } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'
import { md1 } from 'vuetify/blueprints'
import Toast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import VueTheMask from "vue-the-mask";

const vuetify = createVuetify({
    components,
    directives,
    blueprint: md1,
  })
  
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(vuetify)
            .use(Toast)
            .use(VueTheMask)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
