<script setup lang="ts">
const props = defineProps<{
	teams: PaginationData<Team>
}>()

const { data, loadFun, canLoad } = useInfiniteScroll<Team>('myTeams')
</script>
<template>
	<section
		class="space-y-6"
		v-if="teams.data.length">
		<ElScrollbar>
			<div
				v-pagination-scroll="{
					loadFun: loadFun,
					getCanLoad: () => canLoad,
				}"
				class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 max-md:grid-flow-col">
				<template
					v-for="team in data"
					:key="team.id">
					<MyTeamCard
						class=""
						:team="team" />
				</template>
			</div>
		</ElScrollbar>
	</section>
	<Empty v-else />
</template>
