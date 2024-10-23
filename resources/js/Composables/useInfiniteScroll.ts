import { type PageProps } from '@inertiajs/core'
export default <T extends object>(propsKey: keyof PageProps) => {
	const page = usePage()
	const dataFromProps = computed(
		() => page.props?.[propsKey] as PaginationData<T>
	)
	const canLoad = computed(() => {
		return (
			(dataFromProps.value.meta?.current_page ??
				dataFromProps.value.current_page) <
			(dataFromProps.value.meta?.last_page ?? dataFromProps.value.last_page)
		)
	})
	const data = ref(dataFromProps?.value.data)
	const loadFun = async () => {
		await new Promise((resolve, reject) => {
			router.visit(location.href, {
				data: {
					...route().params,
					page:
						(dataFromProps.value.current_page ??
							dataFromProps.value.meta.current_page) + 1,
				},
				only: [propsKey],
				replace: true,
				preserveScroll: true,
				preserveState: true,
				onSuccess: () => {
					data.value = data.value.concat(dataFromProps.value.data)

					// history.replaceState(
					// 	null,
					// 	'',
					// 	removeUrlParameter(location.href, 'page')
					// )
					router.visit(removeUrlParameter(location.href, 'page'), {
						replace: true,
						only: ['skdl'],
						preserveScroll: true,
						preserveState: true,
					})
					resolve(data.value)
				},
			})
		})
	}
	return {
		data,
		loadFun,
		canLoad,
	}
}
