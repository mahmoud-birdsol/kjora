import VueGoogleMaps from "@fawmi/vue-google-maps";
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { createInertiaApp } from "@inertiajs/vue3";
import "@splidejs/splide/css";
import "@splidejs/vue-splide/css";
import "@splidejs/vue-splide/css/core";
import { OnClickOutside } from "@vueuse/components";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { i18nVue } from "laravel-vue-i18n";
import { createPinia } from "pinia";
import { createApp, h } from "vue";
import VueApexCharts from "vue3-apexcharts";
import EmojiPicker from "vue3-emoji-picker";
import "../../node_modules/vue3-emoji-picker/dist/style.css";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import "../css/app.css";
import "./bootstrap";

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
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18nVue, {
                resolve: (lang) => import(`../../lang/${lang}.json`),
            })
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .use(VueApexCharts)
            .use(VueGoogleMaps, {
                load: {
                    key: apiKey,
                    libraries: "places",
                },
            })
            .component("EmojiPicker", EmojiPicker)
            .component("OnClickOutside", OnClickOutside)
            .component("font-awesome-icon", FontAwesomeIcon)
            .mount(el);
    },
    progress: {
        color: "rgb(0, 100, 0)",
        showSpinner: true,
    },
});
