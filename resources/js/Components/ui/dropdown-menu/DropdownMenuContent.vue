<script setup lang="ts">
import { type HTMLAttributes, computed } from 'vue'
import {
	DropdownMenuContent,
	type DropdownMenuContentEmits,
	type DropdownMenuContentProps,
	DropdownMenuPortal,
	useForwardPropsEmits,
	DropdownMenuArrow,
} from 'radix-vue'
import { cn } from '@/Utils'

const props = withDefaults(
	defineProps<
		DropdownMenuContentProps & {
			class?: HTMLAttributes['class']
			arrow?: boolean
		}
	>(),
	{
		sideOffset: 4,
		arrow: true,
		collisionPadding: 10,
	}
)
const emits = defineEmits<DropdownMenuContentEmits>()

const delegatedProps = computed(() => {
	const { class: _, ...delegated } = props

	return delegated
})

const forwarded = useForwardPropsEmits(delegatedProps, emits)
</script>

<template>
	<DropdownMenuPortal>
		<DropdownMenuContent
			v-bind="forwarded"
			:class="
				cn(
					'z-50 min-w-32 overflow-hidden rounded-md border border-muted bg-popover text-popover-foreground shadow-black/20 p-1  shadow-md data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2',
					props.class
				)
			">
			<slot />
			<DropdownMenuArrow class="fill-white stroke-border" />
		</DropdownMenuContent>
	</DropdownMenuPortal>
</template>
