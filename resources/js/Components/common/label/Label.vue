<script setup lang="ts">
import { labelVariants, type LabelProps } from '.'

const props = defineProps<{
	value: string
	color: LabelProps['color']
}>()
</script>

<template>
	<label :class="cn(labelVariants({ color: props.color }))">
		<span v-if="value">{{ value }}</span>
		<span v-else>
			<slot />
		</span>
	</label>
</template>
