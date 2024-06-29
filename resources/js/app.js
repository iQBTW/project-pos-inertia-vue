import './bootstrap';
import '../css/app.css';
import 'flowbite';

import { createApp, h } from 'vue';
import { createInertiaApp} from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import Lara from '../../public/assets/primevuepreset/lara';
import DataTableLib from 'datatables.net-bs5'; ;
import DataTable from 'datatables.net-vue3' ;
import VueSweetAlert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

DataTable.use(DataTableLib);

const appName = import.meta.env.VITE_APP_NAME || 'Project POS';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(VueSweetAlert2)
            .component('DataTable', DataTable)
            .use(PrimeVue, {
                unstyled: true,
                pt: Lara,
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
})


