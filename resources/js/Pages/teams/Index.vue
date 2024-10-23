<script setup lang="ts">
import type { TTab } from '@/Components/App/AppTabs.vue'
import { useBrowserLocation } from '@vueuse/core'
import { trans } from 'laravel-vue-i18n'

const props = defineProps<{
	teams: PaginationData<Team>
	myTeams: PaginationData<Teams>
	topRatingPlayer: Resource<Users>
}>()

const location = useBrowserLocation()

const tabs = computed<TTab[]>(() => [
	{
		label: trans('looking-for-team'),
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
		label: trans('my-teams'),
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
				<div class="relative">
					<div
						class="w-full p-6 bg-center bg-cover rounded-xl min-h-60 bg-primary rtl:-scale-x-100"
						style="background-image: url(/images/teams-banner.webp)"></div>
					<div class="absolute max-w-xs -translate-y-1/2 start-1/2 top-1/2">
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
