<script setup lang="ts">
import { createColumnHelper } from '@tanstack/vue-table'
import { trans } from 'laravel-vue-i18n'
import PlayerSimpleCard from '@/Components/PlayerCards/PlayerSimpleCard.vue'
import TeamPlayerActions from './TeamPlayerActions.vue'
import type { ButtonVariants } from '../ui/button'

type Model = User

const props = defineProps<{
	players: Model[]
}>()
const page = usePage()
const locale = computed(() => page.props.locale)

const columnHelper = createColumnHelper<Model>()
const columns = computed(() => [
	columnHelper.accessor('name', {
		header: trans('player-info'),
		cell: (context) =>
			h(PlayerSimpleCard, {
				player: context.row.original,
			}),
	}),
	columnHelper.accessor('position.name', {
		header: trans('position'),
		cell: (context) => context.row.original.position.name[locale.value],
	}),
	columnHelper.display({
		header: '-',
		cell: ({ row }) =>
			h(TeamPlayerActions, {
				player: row.original,
			}),
	}),
])
</script>
<template>
	<DataTable
		:columns
		:data="players" />
</template>
