<script setup lang="ts">
const props = defineProps<{
	teams: PaginationData<Team>
}>()
</script>
<template>
	<section
		class="space-y-6"
		v-if="teams.data.length">
		<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
			<template
				v-for="team in teams.data"
				:key="team.id">
				<MyTeamCard :team="team" />
			</template>
		</div>
		<Pagination :links="teams.links" />
	</section>
	<Empty v-else />
</template>
