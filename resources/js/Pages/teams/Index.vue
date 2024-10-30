<script setup lang="ts">
import type { TTab } from '@/Components/App/AppTabs.vue'
import { useBrowserLocation } from '@vueuse/core'
import { trans } from 'laravel-vue-i18n'

const props = defineProps<{
	teams: PaginationData<Team>
	myTeams: PaginationData<Teams>
}>()

const location = useBrowserLocation()

const tabs = computed<TTab[]>(() => [
	{
		label: trans('looking-for-team'),
		href: route('teams.index'),
		active: !route().params.tab,
		props: {
			teams: props.teams,
		},
	},
	{
		label: trans('my-teams'),
		href: route('teams.index', {
			tab: 'my_team',
		}),
		active: route().params.tab == 'my_team',
		props: {
			teams: props.myTeams,
		},
	},
])
</script>
<template>
	<Head :title="$t('teams')" />

	<AppLayout :title="$t('teams')">
		<div class="grid lg:grid-cols-[1fr_minmax(15rem,20rem)] gap-6 items-start">
			<div class="min-w-0 space-y-6">
				<div class="relative flex items-end justify-end">
					<div
						class="w-full bg-center bg-cover rounded-xl min-h-60 bg-primary rtl:-scale-x-100"
						style="background-image: url(/images/teams-banner.webp)"></div>
					<div class="absolute w-full max-w-xs p-6 -translate-y-1/2 top-1/2">
						<p class="font-medium">{{ $t('welcome-to-football-teams') }}</p>
						<h2 class="text-4xl font-semibold">
							{{ $t('bring-your-friends') }}
						</h2>
					</div>
				</div>
				<div class="flex flex-wrap items-center justify-between gap-2">
					<AppTabs :tabs />
					<AppSearchInput />
					<TeamForm />
				</div>
				<MyTeamsList
					v-if="route().params.tab === 'my_team'"
					:teams="myTeams" />
				<TeamsList
					v-else-if="!route().params.tab"
					:teams="teams" />
			</div>
			<div class="space-y-6">
				<MatchAdvertise />
				<MatchesLatestList :matches="[]" />
				<PlayerTopRatingList />
			</div>
		</div>
	</AppLayout>
</template>
