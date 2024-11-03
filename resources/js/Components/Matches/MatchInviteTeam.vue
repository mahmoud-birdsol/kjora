<script lang="ts" setup>
import { CheckboxRoot } from 'radix-vue'
const props = defineProps<{
	teams: Teams
}>()
const emit = defineEmits<{ (e: 'goToNext'): void; (e: 'goToPrevious'): void }>()

type ModelForm = {
	team_id?: number
	players: number[]
}
const form = useForm<ModelForm>(() => ({
	team_id: undefined,
	players: [],
}))
const selectedTeam = computed<Team | undefined>(() => {
	return props.teams.find((team) => team.id == form.team_id)
})

const togglePlayer = (checked: boolean, player: User) => {
	checked
		? form.players.push(player.id)
		: form.players.splice(
				form.players.findIndex((id) => id === player.id),
				1
			)
}
const selectAllPlayers = () => {
	if (!selectedTeam.value) return
	const isSelectedAll = selectedTeam.value.players.every((user) =>
		form.players.includes(user.id)
	)
	console.log('isSelectedAll:', isSelectedAll)
	if (isSelectedAll) {
		form.players = form.players.filter(
			(id) => !selectedTeam.value.players.find((player) => id === player.id)
		)
	} else {
		form.players = [
			...form.players,
			...selectedTeam.value.players.reduce(
				(arr: number[], user) =>
					form.players.includes(user.id) ? arr : (arr = [...arr, user.id]),
				[]
			),
		]
	}
}
</script>

<template>
	<Card>
		<CardContent>
			<template #body>
				<div class="mb-5 space-y-4">
					<p class="card-title">
						{{ $t('1-invite-my-team') }}
					</p>
					<FormField
						:label="$t('select-team')"
						:error="form.errors.team_id">
						<RichSelectInput
							v-model="form.team_id"
							:options="teams"
							textName="name"
							valueName="id" />
					</FormField>
				</div>
				<div class="flex flex-wrap justify-between gap-3 mb-3">
					<div class="flex items-center gap-3">
						<h2 class="font-medium text-black">{{ $t('team-members') }}</h2>
						<Button
							@click="selectAllPlayers"
							variant="link"
							:label="$t('select-all')"
							color="primary" />
					</div>
					<p>
						{{
							$t('selected-members-count', {
								count: String(form.players.length),
							})
						}}
					</p>
				</div>
				<div
					class="grid gap-3 lg:grid-cols-3"
					v-if="selectedTeam">
					<template
						v-for="player in selectedTeam.players"
						:key="player.id">
						<div class="flex items-center gap-2">
							<Checkbox
								:aria-label="player.name"
								:checked="form.players.includes(player.id)"
								@update:checked="(checked) => togglePlayer(checked, player)" />
							<PlayerSimpleCard :player />
						</div>
					</template>
				</div>
			</template>
		</CardContent>

		<div
			class="flex justify-between w-full max-md:flex-col-reverse max-md:items-stretch">
			<Button
				@click="$emit('goToPrevious')"
				:label="$t('Back')"
				variant="outline"
				color="black"
				icon="i-radix-icons-caret-left rtl:i-radix-icons-caret-right" />

			<Button
				@click="$emit('goToNext')"
				:label="$t('send-invitation-and-continue')" />
		</div>
	</Card>
</template>
