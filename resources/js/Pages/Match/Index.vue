<script setup lang="ts">
const props = defineProps<{
	teamMatches: Matches
}>()
const tabs: TTab[] = [
	{
		label: wTrans('team-matches'),
		href: route('teams.index'),
		active: !route().params.tab,
	},
	{
		label: wTrans('individual-matches'),
		href: route('teams.index', {
			tab: 'individual-tab',
		}),
		active: route().params.tab === 'individual-tab',
	},
]
</script>
<template>
	<AppLayout :title="$t('matches')">
		<div class="grid lg:grid-cols-[1fr_minmax(15rem,20rem)] gap-6 items-start">
			<div class="space-y-6">
				<h2 class="page-title">{{ $t('matches') }}</h2>
				<div class="flex flex-wrap justify-between gap-3">
					<AppTabs :tabs="tabs" />
					<AppSearchInput />
					<MatchOptions />
				</div>
				<MatchTeamsList
					v-if="tabs[0].active"
					:matches="teamMatches" />
			</div>
			<div class="space-y-6">
				<MatchAdvertise />
				<MatchesLatestList :matches="[]" />
				<PlayerTopRatingList />
			</div>
		</div>
	</AppLayout>
</template>
