import { useDebounceFn, useThrottleFn } from '@vueuse/core'
import type { App, ObjectDirective } from 'vue'
import type { Directive } from 'vue'

const paginationScroll: ObjectDirective<
	HTMLElement,
	{
		loadFun: Function
		getCanLoad: () => boolean
	},
	string
> = {
	mounted(el, binding, vnode) {
		let element = el.lastElementChild
		if (!element) return
		const observerCallback: IntersectionObserverCallback = async (
			entries,
			observer
		) => {
			if (entries[0].isIntersecting) {
				const { loadFun, getCanLoad: getCanLoad } = binding.value
				if (loadFun) {
					await loadFun()
				}
				observer.unobserve(element)
				const newObserveElement = el.lastElementChild
				if (getCanLoad() && newObserveElement) {
					observer.observe(newObserveElement)
				} else {
					observer.disconnect()
				}
			}
		}
		const observer = new IntersectionObserver(
			useThrottleFn(observerCallback, 1000),
			{
				threshold: 1,
				rootMargin: '20px',
			}
		)
		observer.observe(element)
	},
}
export default paginationScroll
