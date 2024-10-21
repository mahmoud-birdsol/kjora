<script setup lang="ts">
const props = defineProps<{
	matches: Matches
}>()
</script>
<template>
	<section
		v-if="matches.length"
		class="grid gap-6 md:grid-cols-3">
		<template
			v-for="match in matches"
			:key="match.id">
			<MatchCard :match="match" />
		</template>
	</section>
	<Empty v-else />
</template>
