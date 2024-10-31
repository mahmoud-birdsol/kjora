import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'
import i18n from 'laravel-vue-i18n/vite'
import { visualizer } from 'rollup-plugin-visualizer'
import { watch } from 'vite-plugin-watch'

export default defineConfig({
	build: {
		rollupOptions: {
			output: {
				manualChunks: (id) => {
					if (id.includes('element-plus')) {
						return 'element-plus'
					}
					if (id.includes('headlessui')) {
						return 'headlessui'
					}
					if (id.includes('@fawmi/vue-google-maps')) {
						return '@fawmi/vue-google-maps'
					}
					if (id.includes('vue3-apexcharts')) {
						return 'vue3-apexcharts'
					}
					if (id.includes('apexcharts')) {
						return 'apexcharts'
					}
					if (id.includes('vue-datepicker')) {
						return 'vue-datepicker'
					}
					if (id.includes('emoji-picker')) {
						return 'emoji-picker'
					}
					if (id.includes('lodash-es')) {
						return 'lodash-es'
					}
					if (id.includes('pusher-js')) {
						return 'pusher-js'
					}
					if (id.includes('@tanstack')) {
						return '@tanstack'
					}
					if (id.includes('@fortawesome')) {
						return '@fortawesome'
					}
					if (id.includes('date-fns')) {
						return 'date-fns'
					}
					if (id.includes('vue-picture-cropper')) {
						return 'vue-picture-cropper'
					}
					if (id.includes('vue-easy-lightbox')) {
						return 'vue-easy-lightbox'
					}
					if (id.includes('node_modules')) {
						return 'vendor'
					}
				},
			},
		},
	},
	plugins: [
		watch({
			pattern: ['routes/*.php'],
			command: 'php artisan ziggy:generate --types-only',
		}),
		laravel({
			input: 'resources/js/app.js',
			ssr: 'resources/js/ssr.js',
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
			dts: true,
			dirs: ['./resources/js/Composables', './resources/js/Utils'],
			resolvers: [
				ElementPlusResolver({
					importStyle: 'sass',
				}),
			],
			vueTemplate: true,
			imports: [
				'vue',
				{
					'@inertiajs/vue3': ['useForm', 'usePage', 'router'],
				},
				{
					'laravel-vue-i18n': ['trans', 'wTrans'],
				},
				{
					uuid: [['v4', 'uuid']],
				},
			],
		}),
		Components({
			dts: 'auto-components.d.ts',
			dirs: ['./resources/js/Components', './resources/js/Layouts'],
			resolvers: [
				ElementPlusResolver({ importStyle: 'sass' }),
				{
					resolve: (componentName) => {
						if (['Link', 'Head'].includes(componentName)) {
							return {
								name: componentName,
								from: '@inertiajs/vue3',
							}
						}
					},
					type: 'component',
				},
			],
		}),
		visualizer(),
	],
	resolve: {
		alias: {
			'@': '/resources/js',
		},
	},
	css: {
		preprocessorOptions: {
			scss: {
				additionalData: `@use "/resources/css/element-plus.scss" as *;`,
			},
		},
	},
})
