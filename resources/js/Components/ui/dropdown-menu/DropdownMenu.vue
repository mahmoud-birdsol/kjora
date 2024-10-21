<script setup lang="ts">
import {
	DropdownMenuRoot,
	type DropdownMenuRootEmits,
	type DropdownMenuRootProps,
	useForwardPropsEmits,
} from 'radix-vue'
import type { HTMLAttributes } from 'vue'

const props = defineProps<
	DropdownMenuRootProps & { class?: HTMLAttributes['class'] }
>()
const emits = defineEmits<DropdownMenuRootEmits>()

const forwarded = useForwardPropsEmits(props, emits)
</script>

<template>
	<DropdownMenuRoot v-bind="forwarded">
		<slot />
	</DropdownMenuRoot>
</template>
