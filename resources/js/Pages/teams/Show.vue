<script setup lang="ts">
type Model = Team
const props = defineProps<{
	team: Model
}>()
</script>
<template>
	<AppLayout :title="team.name">
		<div class="grid lg:grid-cols-[1fr_minmax(15rem,20rem)] gap-6 items-start">
			<div class="space-y-6">
				<div class="flex items-center gap-3">
					<Avatar
						size="xlg"
						:id="team.id"
						:image-url="team.image" />
					<div class="space-y-1 text-white">
						<StarRating />
						<h2 class="text-3xl font-bold capitalize">{{ team.name }}</h2>
						<span class="text-lg font-medium">{{
							$tChoice('count-player-or-count-players', team.users.length)
						}}</span>
					</div>
				</div>
				<div>
					<AppSearchInput />
					<PrimaryButton></PrimaryButton>
				</div>
			</div>
			<div class="space-y-6">
				<MatchAdvertise />
				<MatchesLatestList :matches="[]" />
				<PlayerTopRatingList :players="[]" />
			</div>
		</div>
	</AppLayout>
</template>
