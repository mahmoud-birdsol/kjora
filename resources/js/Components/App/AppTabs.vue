<script lang="ts">
type TTab = {
	label: string | ComputedRef<string>
	href: string
	active: boolean
}
</script>
<script setup lang="ts">
import { useBrowserLocation } from '@vueuse/core'
import type { ComputedRef } from 'vue'
const props = defineProps<{
	tabs: TTab[]
}>()
</script>
<template>
	<div class="flex gap-2">
		<template
			v-for="tab in tabs"
			:key="tab.value">
			<Button
				color="mute"
				:class="tab.active ? 'bg-primary-100 text-primary' : ''"
				:href="tab.href">
				{{ tab.label }}
			</Button>
		</template>
	</div>
</template>
