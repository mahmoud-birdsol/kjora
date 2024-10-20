<script setup lang="ts">
import axios from 'axios'
import { useAxios } from '@vueuse/integrations/useAxios'
import { useDebounceFn } from '@vueuse/core'

const props = defineProps<{
	team: Team
}>()

const showForm = defineModel<boolean>('open', {
	default: false,
})
const openForm = () => {
	showForm.value = true
}
const closeForm = () => {
	showForm.value = false
}
type TFormModel = {
	team_id: number
	players: User['id'][]
}
const form = useForm<TFormModel>(() => ({
	team_id: props?.team?.id,
	players: [],
}))
const {
	data: users,
	isLoading: isLoadingUsers,
	execute: fetchUser,
} = useAxios<Resource<Users>>(
	route('api.users.index'),
	{
		method: 'get',
	},
	axios,
	{
		immediate: true,
	}
)

const query = ref<string>('')
watch(
	query,
	useDebounceFn(() => {
		fetchUser(
			route('api.users.index', {
				_query: {
					search: query.value,
				},
			})
		)
	}, 500)
)
</script>
<template>
	<Modal
		:show="showForm"
		@close="closeForm"
		:title="$t('invite-players')">
		<div class="p-6 space-y-6">
			<TextInput
				v-model="query"
				type="search" />
			<form
				class="space-y-6"
				v-if="users?.data.length">
				<ElScrollbar
					height="300px"
					view-class="space-y-4"
					v-loading="isLoadingUsers">
					<template
						v-for="user in users?.data"
						:key="user.id">
						<div class="flex items-center gap-3">
							<Checkbox
								v-model:checked="form.players"
								:value="String(user.id)" />
							<PlayerSimpleCard :player="user" />
						</div>
					</template>
				</ElScrollbar>
				<div class="flex gap-4">
					<PrimaryButton>{{ $t('invite') }}</PrimaryButton>
					<SecondaryButton
						@click="closeForm"
						type="button"
						>{{ $t('Cancel') }}</SecondaryButton
					>
				</div>
			</form>
			<Empty v-else />
		</div>
	</Modal>
</template>
