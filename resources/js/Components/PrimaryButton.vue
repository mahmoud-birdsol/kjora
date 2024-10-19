<script setup>
import { usePage } from '@inertiajs/vue3'
defineProps({
	type: {
		type: String,
		default: 'submit',
	},
})
const state = usePage().props?.value?.auth?.user?.state_name
</script>

<template>
	<button
		:type="type"
		:class="
			cn(
				[
					'inline-flex items-center justify-center w-full px-4 py-2 text-xs font-bold text-center text-white uppercase transition border border-transparent rounded-full whitespace-nowrap focus:ring ltr:tracking-widest focus:outline-none',
					state !== 'Premium'
						? 'bg-black enabled:hover:bg-stone-800 active:bg-gray-900  focus:border-gray-900  disabled:bg-stone-500'
						: 'bg-golden enabled:hover:bg-golden/50 focus:border-golden/90 focus:ring-golden disabled:bg-golden/30',
				],
				$attrs.class
			)
		">
		<slot />
	</button>
</template>
