<script setup lang="ts">
import type { TTab } from '@/Components/App/AppTabs.vue'
import { useBrowserLocation } from '@vueuse/core'

const props = defineProps<{
	teams: PaginationData<Team>
	myTeams: PaginationData<Teams>
	topRatingPlayer: Resource<Users>
}>()

const location = useBrowserLocation()

const tabs = computed<TTab[]>(() => [
	{
		label: 'Looking For Team',
		href: route('teams.index'),
		active: !route().params.tab,
		component: defineAsyncComponent({
			loader: () => import('@/Components/Teams/TeamsList.vue'),
		}),

		props: {
			teams: props.teams,
		},
	},
	{
		label: 'My Teams',
		href: route('teams.index', {
			tab: 'my_team',
		}),
		active: route().params.tab == 'my_team',
		component: defineAsyncComponent({
			loader: () => import('@/Components/Teams/MyTeamsList.vue'),
		}),
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
			<div class="space-y-6">
				<p class="text-4xl font-black text-white md:text-7xl">
					{{ $t('teams') }}
				</p>
				<div class="flex items-center justify-between gap-2 flex-wrap">
					<AppTabs :tabs />
					<AppSearchInput />
					<TeamForm />
				</div>
				<template v-for="tab in tabs">
					<component
						v-bind="tab.props"
						v-if="tab.active"
						:is="tab.component" />
				</template>
			</div>
			<div class="space-y-6">
				<MatchAdvertise />
				<MatchesLatestList :matches="[]" />
				<PlayerTopRatingList :players="topRatingPlayer.data" />
			</div>
		</div>
	</AppLayout>
</template>
