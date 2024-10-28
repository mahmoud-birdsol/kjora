<script setup lang="ts">
import { type VisitOptions } from '@inertiajs/core'
import { trans, wTrans } from 'laravel-vue-i18n'
import type { BadgeProps } from '../ui/badge'
type Model = Prettify<TeamInvitation>
const props = defineProps<{
	invitation: Model
}>()

const canAccept = computed(() => {
	return props.invitation.state === 'pending'
})
const canReject = computed(() => {
	return props.invitation.state === 'pending'
})

const visitOptions: Partial<VisitOptions> = {
	preserveScroll: true,
	preserveState: true,
}
const acceptInvitationForm = useForm(() => ({}))
const acceptInvitation = () => {
	acceptInvitationForm.post(
		route('team.invitation.accept', [props.invitation]),
		{
			...visitOptions,
			onError: () => {
				props.invitation.state = 'pending'
			},
			onSuccess: () => {
				props.invitation.state = 'accepted'
			},
		}
	)
}

const rejectInvitationForm = useForm(() => ({}))
const rejectInvitation = () => {
	rejectInvitationForm.delete(
		route('team.invitation.reject', [props.invitation]),
		{
			...visitOptions,
			onError: () => {
				props.invitation.state = 'pending'
			},
			onSuccess: () => {
				props.invitation.state = 'rejected'
			},
		}
	)
}

const stateVariants: Record<Model['state'], BadgeProps> = {
	accepted: {
		label: wTrans('accepted'),
	},
	rejected: {
		label: wTrans('rejected'),
		variant: 'destructive',
	},
	cancelled: {
		label: wTrans('cancelled'),
		variant: 'secondary',
	},
}
</script>
<template>
	<section
		class="p-4 text-white rounded-xl flex flex-col gap-1 items-center bg-[linear-gradient(to_top_left,#000,#006400,#052D05E3,#005700,#000000)]">
		<Avatar
			:id="invitation.invited_player.id"
			:username="invitation.invited_player.username" />
		<Link
			class="font-medium capitalize"
			:href="route('profile.show', [invitation.invited_player])"
			>{{ invitation.invited_player.name }}</Link
		>
		<StarRating
			:modelValue="Number(invitation.invited_player.rating)"
			disabled />
		<p class="text-xs">
			{{
				$t('wants-to-invite-you-for-a-join-his-team-team', {
					team: invitation.team.name,
				})
			}}
		</p>
		<div class="flex gap-2 mt-6">
			<Button
				v-if="canReject"
				@click="rejectInvitation"
				:loading="rejectInvitationForm.processing"
				aria-label="reject invitation"
				icon="i-heroicons-x-mark text-red-600"
				color="white"
				size="icon" />
			<Button
				v-if="canAccept"
				@click="acceptInvitation"
				:loading="acceptInvitationForm.processing"
				aria-label="accept invitation"
				icon="i-heroicons-check text-green-600"
				color="white"
				size="icon" />
		</div>
		<Badge
			v-if="stateVariants[invitation.state]"
			v-bind="stateVariants[invitation.state]" />
	</section>
</template>
