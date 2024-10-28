import { watch, ref } from 'vue'
import { useDebounceFn } from '@vueuse/core'
import { router } from '@inertiajs/vue3'

export default function useFilter<T extends object>(
	data: T,
	options?: {
		withQueryParam: boolean
		parameterName: string
	}
) {
	const { parameterName = 'search', withQueryParam = true } = options ?? {}

	const form = useForm<T>(data)

	watch(
		() => form.data(),
		useDebounceFn(
			(newQuery) => {
				const currentLocation = withQueryParam
					? location.href
					: location.origin + location.pathname
				router.get(currentLocation, form.data(), {
					preserveState: true,
					preserveScroll: true,
					replace: true,
				})
			},
			250,
			{
				maxWait: 1500,
			}
		)
	)

	//reset all
	const resetAllFilters = () => {
		const currentLocation = location.origin + location.pathname
		router.get(
			currentLocation,
			{},
			{
				preserveScroll: true,
				replace: true,
			}
		)
	}

	//reset single value (remove it from url)
	const resetSingleFilter = (parameter: string) => {
		let url = new URL(window.location.toString())
		url.searchParams.delete(parameter)
		history.replaceState(null, '', url.href)
		const currentLocation = location.href
		router.get(
			currentLocation,
			{},
			{
				preserveScroll: true,
				replace: true,
			}
		)
	}
	return { filterForm: form, resetAllFilters, resetSingleFilter }
}
