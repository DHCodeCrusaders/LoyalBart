import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import "../css/app.css";
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import { InertiaProgress } from '@inertiajs/progress';
import 'vue3-toastify/dist/index.css';

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#FFC0CB' });
