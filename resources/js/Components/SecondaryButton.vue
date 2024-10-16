<script setup>
import { computed } from 'vue'

const props = defineProps({
	type: {
		type: String,
		default: 'button',
	},
	size: {
		required: false,
		type: String,
		default: 'lg',
	},
})

const sizeClasses = computed(() => {
	return {
		sm: 'px-4 py-2',
		md: 'px-6 py-3',
		lg: 'px-2 lg:px-8 py-2 lg:py-4',
		xl: 'px-10 py-5',
		'2xl': 'px-12 py-6',
	}[props.size]
})
</script>

<template>
	<button
		:type="type"
		class="w-full text-center items-center bg-white border-2 border-gray-300 rounded-full font-semibold text-xs lg:text-[0.875rem] text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-primary active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition rtl:tracking-tight"
		:class="sizeClasses">
		<slot />
	</button>
</template>
