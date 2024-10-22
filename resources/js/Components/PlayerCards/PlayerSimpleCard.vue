<script setup lang="ts">
const props = defineProps<{
	player: User
}>()
</script>
<template>
	<div class="flex items-center gap-3">
		<Avatar
			:id="player.id"
			:username="player.username"
			:imageUrl="player.avatar_url" />
		<div>
			<Link
				:href="route('player.profile', player.id)"
				class="text-sm font-medium">
				{{ `${player.first_name} ${player.last_name}` }}
			</Link>
			<StarRating
				:modelValue="Number(player.rating)"
				disabled
				showRatingValue />
		</div>
	</div>
</template>
