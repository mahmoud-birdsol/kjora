import { default as routeFn } from 'ziggy-js'
export {}
declare module '@vue/runtime-core' {
	interface ComponentCustomProperties {
		route: typeof routeFn
	}
}
