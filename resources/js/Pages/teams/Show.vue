<script setup lang="ts">
import { trans } from 'laravel-vue-i18n'
import { useBrowserLocation } from '@vueuse/core'

type Model = Team
const props = defineProps<{
	team: Model
	players: Users
	matches: Matches
}>()

const location = useBrowserLocation()

const showInvitationForm = ref<boolean>(false)
const tabs = computed(() => [
	{
		label: trans('team-players'),
		href: route('teams.show', [props.team]),
		component: defineAsyncComponent({
			loader: () => import('@/Components/Teams/TeamPlayersTable.vue'),
		}),
		props: { players: props.players },
	},
	{
		label: trans('matches'),
		href: route('teams.show', [
			props.team,
			{
				tab: 'matches',
			},
		]),
		component: defineAsyncComponent({
			loader: () => import('@/Components/Teams/TeamMatchesList.vue'),
		}),
		props: { matches: props.matches },
	},
])
</script>
<template>
	<AppLayout :title="team.name">
		<div class="grid lg:grid-cols-[1fr_minmax(15rem,20rem)] gap-6 items-start">
			<div class="space-y-6">
				<div class="flex items-center gap-3">
					<Avatar
						size="xlg"
						:image-url="team.image" />
					<div class="space-y-1 text-white">
						<StarRating />
						<h2 class="text-3xl font-bold capitalize">{{ team.name }}</h2>
						<span class="text-lg font-medium">{{
							$tChoice('count-player-or-count-players', team.users.length)
						}}</span>
					</div>
				</div>
				<div class="flex flex-wrap items-center gap-3">
					<AppTabs :tabs />
					<span class="ms-auto grow" />
					<AppSearchInput />
					<PrimaryButton
						class="w-fit"
						@click="showInvitationForm = true"
						>{{ $t('invite-players') }}</PrimaryButton
					>
				</div>
				<template v-for="tab in tabs">
					<component
						v-bind="tab.props"
						v-if="tab.href === location.href"
						:is="tab.component" />
				</template>
			</div>
			<div class="space-y-6">
				<MatchAdvertise />
				<MatchesLatestList :matches="[]" />
				<PlayerTopRatingList :players="[]" />
			</div>
		</div>
	</AppLayout>
	<TeamInvitationForm
		:team="team"
		v-model:open="showInvitationForm" />
</template>
