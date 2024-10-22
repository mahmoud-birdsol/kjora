<script setup lang="ts">
type Model = Prettify<Team>
const props = defineProps<{
	team: Model
}>()
</script>
<template>
	<div
		class="bg-center bg-cover bg-no-repeat rounded-xl p-4 min-h-48 flex flex-col justify-between"
		:style="{ backgroundImage: 'url(/images/team-image.webp)' }">
		<div :class="'flex items-center justify-between'">
			<Avatar
				size="lg"
				:image-url="team.image"
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
			<div class="size-6 rounded-full overflow-hidden">
				<img
					:src="team.country.flag"
					:alt="team.country.name"
					class="object-cover object-center h-full w-full" />
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
