<script setup lang="ts">
const props = defineProps<{
	players: User[]
}>()
</script>
<template>
	<div class="space-y-4 card">
		<h2 class="card-title">{{ $t('top-rating-players') }}</h2>
		<ul
			class="space-y-3"
			v-if="players.length">
			<template
				v-for="player in players"
				:key="player.id">
				<li class="flex items-center gap-3">
					<Avatar
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
				</li>
			</template>
		</ul>
		<Empty v-else />
	</div>
</template>
