<script setup lang="ts">
import { type HTMLAttributes, computed } from 'vue'
import {
	DropdownMenuItem,
	type DropdownMenuItemProps,
	useForwardProps,
} from 'radix-vue'
import { cn } from '@/Utils'

const props = defineProps<
	DropdownMenuItemProps & {
		class?: HTMLAttributes['class']
		inset?: boolean
		truncate?: boolean
		loading?: boolean
		icon?: string
		label?: string
		ui?: {
			icon?: string
			label?: string
		}
	}
>()

const delegatedProps = computed(() => {
	const { class: _, ...delegated } = props

	return delegated
})

const forwardedProps = useForwardProps(delegatedProps)
const page = usePage()
const locale = computed(() => page.props.locale)
</script>

<template>
	<DropdownMenuItem
		v-bind="forwardedProps"
		:class="
			cn(
				'relative flex cursor-default select-none items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-none transition-colors focus:bg-primary-200  data-[disabled]:pointer-events-none data-[disabled]:opacity-50',
				inset && 'pl-8',
				props.class
			)
		"
		:dir="locale === 'ar' ? 'rtl' : 'ltr'"
		:disabled="loading || props.disabled">
		<slot>
			<span
				v-if="icon"
				:class="
					cn(
						'size-3.5 shrink-0',
						loading ? 'i-app-loading animate-spin' : icon,
						ui?.icon
					)
				" />
			<span
				:class="
					cn('first-letter:capitalize', ui?.label, truncate && 'text-truncate')
				"
				v-text="label" />
		</slot>
	</DropdownMenuItem>
</template>
