<script setup>
import { cva } from 'class-variance-authority'
defineProps({
	value: String,
	color: {
		required: false,
		type: String,
		default: 'white',
	},
})
</script>

<template>
	<label
		class="block mb-1 ml-4 text-xs font-medium uppercase"
		:class="`text-${color}`">
		<span v-if="value">{{ value }}</span>
		<span v-else>
			<slot />
		</span>
	</label>
</template>
