import "./bootstrap";
import "../css/app.css";
import "@splidejs/splide/css";
import "@splidejs/vue-splide/css/core";
import "@splidejs/vue-splide/css";
import VueApexCharts from "vue3-apexcharts";
import { createSSRApp, h } from 'vue'
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { createPinia } from "pinia";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import {i18nVue} from "laravel-vue-i18n";
import VueGoogleMaps from "@fawmi/vue-google-maps";

import EmojiPicker from "vue3-emoji-picker";
import { OnClickOutside } from "@vueuse/components";
// import "vue3-emoji-picker/css";
import "../../node_modules/vue3-emoji-picker/dist/style.css";
library.add();
const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

const pinia = createPinia();
const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, app, props, plugin }) {
        return createSSRApp({ render: () => h(app, props) })
            .use(plugin)
            .use(i18nVue, {
                resolve: (lang) => import(`../../lang/${lang}.json`)
            })
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .use(VueApexCharts)
            .use(VueGoogleMaps, {
                load: {
                    key: apiKey,
                    libraries: "places",
                    // language: 'de',
                },
            })
            .component("EmojiPicker", EmojiPicker)
            .component("OnClickOutside", OnClickOutside)
            .component("font-awesome-icon", FontAwesomeIcon)
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
