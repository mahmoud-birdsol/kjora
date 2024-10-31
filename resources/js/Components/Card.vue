<script setup lang="ts">
const props = defineProps<{ class: string }>()
</script>

<template>
	<div
		:class="
			cn(
				'bg-white rounded-2xl px-2 py-6 md:p-6 w-full min-h-[500px] text-black',
				props.class
			)
		">
		<slot />
	</div>
</template>
