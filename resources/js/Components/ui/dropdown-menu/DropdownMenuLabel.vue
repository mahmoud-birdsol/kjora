<script setup lang="ts">
import { type HTMLAttributes, computed } from 'vue'
import {
	DropdownMenuLabel,
	type DropdownMenuLabelProps,
	useForwardProps,
} from 'radix-vue'
import { cn } from '@/Utils'

const props = defineProps<
	DropdownMenuLabelProps & {
		class?: HTMLAttributes['class']
		inset?: boolean
		label?: string
		icon?: string
	}
>()

const delegatedProps = computed(() => {
	const { class: _, ...delegated } = props

	return delegated
})

const forwardedProps = useForwardProps(delegatedProps)
</script>

<template>
	<DropdownMenuLabel
		v-bind="forwardedProps"
		:class="
			cn('px-2 py-1.5 text-sm font-medium', inset && 'pl-8', props.class)
		">
		<slot>
			<span
				v-if="icon"
				:class="cn('size-4 shrink-0', icon)" />
			<span class="first-letter:capitalize">{{ label }}</span>
		</slot>
	</DropdownMenuLabel>
</template>
