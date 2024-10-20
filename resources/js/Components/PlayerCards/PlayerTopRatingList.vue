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
				<PlayerSimpleCard :player="player" />
			</template>
		</ul>
		<Empty v-else />
	</div>
</template>
