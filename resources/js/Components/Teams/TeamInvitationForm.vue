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
	players: { id: User['id'] }[]
}
const form = useForm<TFormModel>(() => ({
	team_id: props?.team?.id,
	players: [],
}))

const submit = () => {
	form.post(route('teams.invite'), {
		preserveScroll: true,
		preserveState: true,
		onSuccess: () => {
			closeForm()
		},
	})
}

const {
	data: users,
	isLoading: isLoadingUsers,
	execute: fetchUser,
} = useAxios<Resource<Users>>(
	route('team.invitation.users', [props.team]),
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
const togglePlayer = (playerId: Model['id']) => {
	let playerIndex: number
	const playerObj = form.players.find((player, index) => {
		if (player.id === playerId) {
			playerIndex = index
			return true
		}
		return false
	})
	if (playerObj) {
		form.players.splice(playerIndex, 1)
	} else {
		form.players.push({
			id: playerId,
		})
	}
}
</script>
<template>
	<Modal
		:show="showForm"
		@close="closeForm">
		<div class="p-6 space-y-6">
			<TextInput
				v-model="query"
				type="search" />
			<form
				@submit.prevent="submit"
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
								:checked="form.players.find((id) => user.id === id)"
								@update:checked="togglePlayer(user.id)"
								:value="String(user.id)" />
							<PlayerSimpleCard :player="user" />
							<span class="ms-auto" />
							<Badge>{{ user.position.name[$page.props.locale] }}</Badge>
						</div>
					</template>
				</ElScrollbar>
				<div class="grid grid-cols-2 gap-4">
					<Button
						type="submit"
						:loading="form.processing"
						>{{ $t('invite') }}</Button
					>
					<SecondaryButton
						size="sm"
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
