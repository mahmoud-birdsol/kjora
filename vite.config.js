import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import AutoImport from "unplugin-auto-import/vite";
import Components from "unplugin-vue-components/vite";
import { ElementPlusResolver } from "unplugin-vue-components/resolvers";
import i18n from "laravel-vue-i18n/vite";

export default defineConfig({
   plugins: [
      laravel({
         input: "resources/js/app.js",
         ssr: "resources/js/ssr.js",
         refresh: true,
      }),
      vue({
         template: {
            transformAssetUrls: {
               base: null,
               includeAbsolute: false,
            },
         },
      }),
      i18n(),
      AutoImport({
         dirs: [
            "./resources/js/Composables",
            "./resources/js/utils",
            // "./resources/js/Stores",
         ],
         imports: [
            "vue",
            "@vueuse/core",
            {
               "@inertiajs/vue3": ["useForm", "usePage", "router"],
            },
            {
               dayjs: [["default", "dayjs"]],
            },

            {
               "laravel-vue-i18n": ["trans", "wTrans"],
            },
         ],
         vueTemplate: true,
         dts: true,
         resolvers: [ElementPlusResolver()],
      }),
      Components({
         dts: "./auto-components.d.ts",
         resolvers: [
            ElementPlusResolver(),
            {
               resolve: (componentName) => {
                  if (["Link", "Head"].includes(componentName)) {
                     return {
                        name: componentName,
                        from: "@inertiajs/vue3",
                     };
                  }
               },
               type: "component",
            },
         ],
         dirs: ["./resources/js/Components"],
      }),
   ],
   ssr: {
      noExternal: ["@inertiajs/server"],
   },
   // resolve: {
   //     alias: {
   //         '@': '/resources/js',
   //     },
   // },
});
