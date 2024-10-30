<script setup lang="ts">
import { teamAvatarVariants, type TeamAvatarProps } from '.'

type Model = Team
const props = defineProps<{
	team: Prettify<Model>
	direction?: TeamAvatarProps['direction']
}>()
</script>
<template>
	<div :class="cn('flex items-center', teamAvatarVariants({ direction }))">
		<Avatar
			size="lg"
			:image-url="team.team_logo_url"
			:username="team.name" />
		<div>
			<Link
				class="text-sm font-semibold uppercase line-clamp-1"
				:href="route('teams.show', [team])"
				>{{ `${team.name} (${team.code})` }}</Link
			>
			<StarRating
				class="justify-center mx-auto"
				disabled
				:modelValue="4" />
		</div>
	</div>
</template>
