<script setup>
const props = defineProps({
	active: {
		required: false,
		type: Boolean,
		default: false,
	},
})
</script>

<template>
	<button
		class="rounded-lg p-6 w-full flex justify-center items-center min-h-[200px]"
		:class="{ 'bg-primary': !active, 'bg-primaryDark': active }"
		role="button"
		type="button">
		<div>
			<div class="flex justify-center mb-4">
				<slot name="icon"></slot>
			</div>
			<p class="text-white font-bold uppercase">
				<slot />
			</p>
		</div>
	</button>
</template>
