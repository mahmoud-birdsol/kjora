<script setup lang="ts">
const props = defineProps<{
	matches: Matches
}>()
</script>
<template>
	<div
		v-if="matches.length"
		class="grid gap-4 lg:grid-cols-2">
		<template
			v-for="match in matches"
			:key="match.id">
			<MatchCard :match="match" />
		</template>
	</div>
	<Empty v-else />
</template>
