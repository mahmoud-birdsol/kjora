<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/Utils'

const props = defineProps<{
	class?: HTMLAttributes['class']
}>()
</script>

<template>
	<tr
		:class="
			cn(
				'border-b border-primary transition-colors data-[state=selected]:bg-muted',
				props.class
			)
		">
		<slot />
	</tr>
</template>
