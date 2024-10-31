const useCurrentUser = () => {
	const page = usePage()
	const currentUser = computed(() => page.props.auth.user)

	return { currentUser }
}
export default useCurrentUser
