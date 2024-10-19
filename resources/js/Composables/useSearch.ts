import { watch, ref } from 'vue'
import { useDebounceFn } from '@vueuse/core'
import { router } from '@inertiajs/vue3'
import { removeUrlParameter } from '@/Utils'

export default function useSearch(options?: {
	withQueryParam: boolean
	parameterName: string
}) {
	const { parameterName = 'search', withQueryParam = true } = options ?? {}
	const query = ref<string>((route().params?.[parameterName] as string) ?? '')

	const searchForm = useForm({})
	const search = () => {
		const currentLocation = withQueryParam
			? location.href
			: location.origin + location.pathname
		searchForm
			.transform((data) => {
				return { [parameterName]: query.value || undefined }
			})
			.get(
				currentLocation,

				{
					preserveState: true,
					preserveScroll: true,
					replace: true,
				}
			)
	}

	const clear = () => {
		const currentLocation = removeUrlParameter(location.href, parameterName)
		router.get(
			currentLocation,
			{},
			{
				preserveScroll: true,
				replace: true,
			}
		)
	}
	watch(
		query,
		useDebounceFn(
			(newQuery) => {
				console.log('newQuery:', newQuery)
				search()
			},
			500,
			{
				maxWait: 1500,
			}
		)
	)

	return { query, searchForm, search, clear }
}
