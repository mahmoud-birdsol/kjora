<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import { type TTab } from '@/Components/App/AppTabs.vue'
import { trans } from 'laravel-vue-i18n'
type Model = TeamInvitation
const props = defineProps<{
	invitations: PaginationData<Model>
}>()

const { filterForm } = useFilter({
	dateFrom: route().params.dateFrom,
	dateTo: route().params.dateTo,
})
const filterDateRange = ref<(Date | undefined)[]>([
	filterForm.dateFrom,
	filterForm.dateTo,
])

const { loadFun, data, canLoad } = useInfiniteScroll<Model>('invitations')
const tabs = computed<TTab[]>(() => [
	{
		label: trans('match-invitations'),
		href: route('invitation.index'),
		active: !route().params.tab,
	},
	{
		label: trans('team-invitations'),
		href: route('invitation.index', {
			tab: 'team-invitations',
		}),
		active: route().params.tab == 'team-invitations',
	},
])
</script>

<template>
	<Head title="Invitations" />

	<AppLayout title="Invitations">
		<section class="grid lg:grid-cols-[1fr_20rem] gap-6 items-start">
			<div class="space-y-6">
				<h2 class="page-title">{{ $t('invitations') }}</h2>
				<div class="flex flex-wrap justify-between gap-4">
					<AppSearchInput />
					<AppTabs :tabs />
				</div>
				<template v-if="invitations.data.length">
					<div
						class="grid gap-6 md:grid-cols-2 lg:grid-cols-3"
						v-pagination-scroll="{
							loadFun,
							canLoad,
						}">
						<template
							v-for="invitation in data"
							:key="invitation.id">
							<TeamInvitationCard :invitation="invitation" />
						</template>
					</div>
				</template>
				<v-else v-else />
			</div>
			<div class="space-y-6">
				<InputDate
					:teleport="false"
					v-model="filterDateRange"
					@update:model-value="
						() => {
							filterForm.dateFrom = filterDateRange[0]
							filterForm.dateTo = filterDateRange[1]
						}
					"
					inline
					range
					auto-apply />
				<MatchesLatestList :matches="[]" />
			</div>
		</section>
	</AppLayout>
</template>
<style>
.el-input__wrapper {
	background-color: black;
	color: white;
}

.el-input__inner {
	color: white;
}
</style>
