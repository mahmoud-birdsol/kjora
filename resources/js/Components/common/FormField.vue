<script setup lang="ts">
const props = defineProps<{
	label?: string
	error?: string
}>()
</script>
<template>
	<div class="mb-4">
		<Label
			color="black"
			:value="label ?? ''" />
		<slot></slot>
		<InputError :message="error" />
	</div>
</template>
