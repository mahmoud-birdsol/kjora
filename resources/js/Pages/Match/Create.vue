<script setup lang="ts">
import { useStepper } from '@vueuse/core'
const props = defineProps<{
	teams: Teams
	opponentTeams: Teams
	stadiums: Stadiums
}>()
const { steps, current, index, goToPrevious, goToNext, isCurrent, goTo } =
	useStepper({
		'invite-players': {
			step: 'invite-players',
			title: wTrans('invite-my-team'),
			show: true,
		},
		'invite-opponent-team': {
			step: 'invite-opponent-team',
			title: wTrans('invite-opponent-team'),
			show: route().params.type === 'team',
		},
		'match-details-information': {
			step: 'match-details-information',
			title: wTrans('match-details-information'),
			show: true,
		},
	})
</script>
<template>
	<AppLayout>
		<div class="grid md:grid-cols-[20rem,1fr] gap-6 items-start">
			<div>
				<AppStepper
					:steps="steps"
					:currentStep="current.step" />
			</div>
			<Transition
				name="fade"
				mode="out-in"
				:duration="1000">
				<MatchInviteTeam
					:teams="teams"
					v-if="isCurrent('invite-players')"
					@goToPrevious="goToPrevious"
					@goToNext="
						goTo(
							route().params.type === 'team'
								? 'invite-opponent-team'
								: 'match-details-information'
						)
					" />
				<MatchOpponentTeam
					:teams="opponentTeams"
					v-else-if="isCurrent('invite-opponent-team')"
					@goToPrevious="goToPrevious"
					@goToNext="goToNext" />
				<MatchDetailsStep
					v-else-if="isCurrent('match-details-information')"
					:stadiums
					@goToPrevious="goToPrevious"
					@goToNext="goToNext" />
			</Transition>
		</div>
	</AppLayout>
</template>
