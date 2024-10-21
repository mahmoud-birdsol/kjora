<script setup lang="ts">
type Model = Team
const props = defineProps<{
	team: Model
}>()
</script>
<template>
	<div class="flex flex-col items-center gap-1">
		<Avatar
			size="lg"
			:image-url="team.image"
			:username="team.name" />
		<Link
			class="text-sm font-semibold uppercase"
			:href="route('teams.show', [team])"
			>{{ `${team.name} (${team.code})` }}</Link
		>
		<StarRating
			disabled
			:modelValue="4" />
	</div>
</template>
