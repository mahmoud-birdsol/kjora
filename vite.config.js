import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'
import i18n from 'laravel-vue-i18n/vite'
import { watch } from 'vite-plugin-watch'

export default defineConfig({
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
			resolvers: [ElementPlusResolver()],
			vueTemplate: true,
			imports: [
				'vue',
				{
					'@inertiajs/vue3': ['useForm', 'usePage', 'router'],
				},
			],
		}),
		Components({
			dts: 'auto-components.d.ts',
			dirs: ['./resources/js/Components', './resources/js/Layouts'],
			resolvers: [
				ElementPlusResolver(),
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
	],
	ssr: {
		noExternal: ['@inertiajs/server'],
	},
	resolve: {
		alias: {
			'@': '/resources/js',
		},
	},
})
