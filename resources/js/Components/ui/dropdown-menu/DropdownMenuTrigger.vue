<script setup lang="ts">
import {
	DropdownMenuTrigger,
	type DropdownMenuTriggerProps,
	useForwardProps,
} from 'radix-vue'
import { useId } from 'vue'

const props = withDefaults(defineProps<DropdownMenuTriggerProps>(), {
	asChild: true,
})
const triggerId = `dropdown-menu-trigger-${useId()}`
const forwardedProps = useForwardProps(props)
</script>

<template>
	<DropdownMenuTrigger
		class="outline-none"
		v-bind="forwardedProps">
		<slot>
			<Button
				:aria-label="$t('options')"
				icon="i-heroicons-ellipsis-vertical"
				variant="ghost"
				color="white"
				class="radix-state-open:bg-primary radix-state-open:text-white"
				size="icon"
				:id="triggerId"
				v-bind="$attrs" />
		</slot>
	</DropdownMenuTrigger>
</template>
