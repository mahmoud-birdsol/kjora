<script setup lang="ts">
import {
	EllipsisHorizontalIcon,
	StarIcon,
	TrashIcon,
} from '@heroicons/vue/24/outline'
type Model = Team
const props = defineProps<{
	team: Prettify<Model>
}>()

const deleteTeamForm = useForm({})
const deleteTeam = () => {
	deleteTeamForm.delete(route('teams.destroy', [props.team]), {
		only: ['myTeams'],
	})
}
const page = usePage()
const isCurrentUser = computed(() => {
	return page.props.auth.user.id === props.team.owner_id
})
const canTakeAction = computed(() => {
	return isCurrentUser.value
})
</script>
<template>
	<section class="flex flex-col items-center gap-1 card min-w-60">
		<div class="self-end">
			<slot name="top-actions" />
			<button
				v-if="canTakeAction"
				class="bg-black text-white p-0.5 rounded-full">
				<StarIcon class="w-5 h-5" />
			</button>
		</div>
		<Avatar
			:image-url="team.team_logo_url"
			:size="'xlg'"
			:username="team.name"
			:enableLightBox="true" />
		<Link
			:href="route('teams.show', [team])"
			class="text-sm font-semibold text-black capitalize"
			>{{ team.name }}</Link
		>
		<StarRating
			show-rating-value
			:model-value="4"
			disabled />
		<p class="text-xs font-medium text-primary">
			{{ $tChoice('count-player-or-count-players', team.players.length) }}
		</p>
		<div
			class="self-end space-x-1 rtl:space-x-reverse"
			v-if="canTakeAction">
			<Button
				icon="i-heroicons-trash"
				variant="ghost"
				size="icon"
				:aria-label="$t('delete-team')"
				@click="deleteTeam"
				:loading="deleteTeamForm.processing" />
			<DropdownMenu :modal="false">
				<DropdownMenuTrigger color="black" />
				<DropdownMenuContent
					@interactOutside.prevent=""
					@pointerDownOutside.prevent="">
					<TeamForm :team="team">
						<template #trigger>
							<DropdownMenuItem
								@select.prevent=""
								:label="$t('edit')"
								icon="i-heroicons-pencil" />
						</template>
					</TeamForm>
				</DropdownMenuContent>
			</DropdownMenu>
		</div>
	</section>
</template>
