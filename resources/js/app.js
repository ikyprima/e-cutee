import './bootstrap';

import "@fortawesome/fontawesome-free/css/all.min.css";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import "@vueform/multiselect/themes/default.css";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader
// import { createVuetify } from 'vuetify'
// import * as components from 'vuetify/components'
// import * as directives from 'vuetify/directives'


// const vuetify = createVuetify({
//   components,
//   directives,
//   icons: {
//     defaultSet: 'mdi', // This is already the default value - only for display purposes
//   },
// })

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            // .use(vuetify)
            .component('VueDatePicker', VueDatePicker)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
