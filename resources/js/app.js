import "./bootstrap";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const vuetify = createVuetify({
    components,
    directives,
});

createInertiaApp({
    resolve: async (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob("./pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .component("Datepicker", Datepicker)
            .mount(el);
    },
});
