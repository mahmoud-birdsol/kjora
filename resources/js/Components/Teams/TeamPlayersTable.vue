<script setup lang="ts">
import { createColumnHelper } from '@tanstack/vue-table'
import { trans } from 'laravel-vue-i18n'
import PlayerSimpleCard from '@/Components/PlayerCards/PlayerSimpleCard.vue'

type Model = User

const props = defineProps<{
	players: Model[]
}>()

const columnHelper = createColumnHelper<Model>()
const columns = [
	columnHelper.accessor('name', {
		header: trans('player-info'),
		cell: (context) =>
			h(PlayerSimpleCard, {
				player: context.row.original,
			}),
	}),
	columnHelper.accessor('position.name', {
		header: trans('position'),
		cell: (context) => context.getValue(),
	}),
]
</script>
<template>
	<DataTable
		:columns
		:data="players" />
</template>
