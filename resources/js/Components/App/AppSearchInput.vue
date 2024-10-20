<script setup lang="ts">
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline'

const { query, searchForm, search, clear } = useSearch()
</script>
<template>
	<Input
		v-model="query"
		:placeholder="$t('search')"
		@keydown.enter="search">
		<template #leading>
			<MagnifyingGlassIcon class="text-gray-400 size-4" />
		</template>
		<template #trailing>
			<Button
				aria-label="clear"
				icon="i-radix-icons-cross-2"
				@click="clear"
				size="sm"
				:class="{ invisible: !query?.length }"
				variant="link" />
		</template>
	</Input>
</template>
