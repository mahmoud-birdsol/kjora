<script setup lang="ts">
import { trans } from 'laravel-vue-i18n'

type Model = Team
const props = defineProps<{
	team: Model
	players: Users
	matches: Matches
}>()

const showInvitationForm = ref<boolean>(false)
const tabs = computed(() => [
	{
		label: trans('team-players'),
		value: undefined,
	},
	{
		label: trans('matches'),
		value: 'matches',
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
				<div class="flex flex-wrap items-center gap-3">
					<template
						v-for="tab in tabs"
						:key="tab.value">
						<Link
							:class="[
								'px-3 py-1 text-center bg-white rounded-full ',
								route().current('teams.show', [team.id, { tab: tab.value }])
									? 'text-primary'
									: 'text-stone-400',
							]"
							:href="route('teams.show', [team.id, { tab: tab.value }])">
							{{ tab.label }}
						</Link>
					</template>
					<span class="ms-auto grow" />
					<AppSearchInput />
					<PrimaryButton
						class="w-fit"
						@click="showInvitationForm = true"
						>{{ $t('invite-players') }}</PrimaryButton
					>
				</div>
				<TeamPlayersTable
					v-if="!route().params.tab"
					:players="players" />
				<TeamMatchesList
					v-if="route().params.tab === 'matches'"
					:matches="matches" />
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
