<script setup lang="ts">
import { useBrowserLocation } from '@vueuse/core'
type TTab = {
	label: string
	href: string
	component: Component
}
const location = useBrowserLocation()
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
				:class="tab.href == location.href ? 'bg-primary-100 text-primary' : ''"
				:href="tab.href">
				{{ tab.label }}
			</Button>
		</template>
	</div>
</template>
