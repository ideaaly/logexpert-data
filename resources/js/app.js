require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import PrimeVue from "primevue/config";
import ToastService from "primevue/toastservice";

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

/* PrimeVue Styles */
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";

import VCalendar from "v-calendar";
import "v-calendar/dist/style.css";

import VueApexCharts from "vue3-apexcharts";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

const optionsToast = {
    // You can set your default options here
};

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(PrimeVue, {
                ripple: true,
            })
            .use(ToastService)
            .use(Toast, optionsToast)
            .use(VCalendar)
            .use(VueApexCharts)

            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 0,

    // The color of the progress bar.
    // color: "#3da4b5",
    // color: "#ffffff",
    color: "#76d5e2",

    // Whether to include the default NProgress styles.
    includeCSS: true,

    // Whether the NProgress spinner will be shown.
    showSpinner: true,
});
