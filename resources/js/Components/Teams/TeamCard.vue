<script setup lang="ts">
type Model = Prettify<Team>
const props = defineProps<{
	team: Model
}>()
</script>
<template>
	<div
		class="flex flex-col justify-between p-4 bg-center bg-no-repeat bg-cover rounded-xl min-h-48"
		:style="{ backgroundImage: 'url(/images/team-image.webp)' }">
		<div :class="'flex items-center justify-between'">
			<Avatar
				size="lg"
				:image-url="team.team_logo_url"
				:username="team.name" />
			<div class="text-center">
				<Link
					class="text-sm font-semibold uppercase"
					:href="route('teams.show', [team])"
					>{{ team.name }}</Link
				>
				<p>{{ team.code }}</p>
				<StarRating
					showRatingValue
					disabled
					:modelValue="4" />
			</div>
		</div>
		<div class="flex justify-between">
			<div class="overflow-hidden rounded-full size-6">
				<img
					:src="team.country.flag"
					:alt="team.country.name"
					class="object-cover object-center w-full h-full" />
				<!-- [TODO] add distance between team current user -->
			</div>
			<Button
				icon="i-heroicons-chevron-double-right"
				trailing
				variant="link"
				color="white"
				size="xs"
				:label="$t('apply-to-join')" />
		</div>
	</div>
</template>
