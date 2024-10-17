<script setup lang="ts">
const props = defineProps<{
	matches: Matches
}>()
</script>
<template>
	<div class="card">
		<h2 class="card-title">{{ $t('latest-matches') }}</h2>
		<template
			v-for="match in matches"
			:key="match.id">
			<div>
				<Avatar imageUrl="" />
				<span>VS</span>
				<Avatar imageUrl="" />
			</div>
		</template>
		<Empty />
	</div>
</template>
