<script setup lang="ts">
import { cn } from '@/Utils'
import { type BadgeProps, badgeVariants } from '.'

const props = defineProps<BadgeProps>()
</script>

<template>
	<div :class="cn(badgeVariants({ variant }), props.class)">
		<slot>
			{{ label }}
		</slot>
	</div>
</template>
