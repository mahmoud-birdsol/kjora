<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
	active: Boolean,
	href: String,
	as: String,
})
const sharedClasses =
	'block w-full py-2 pl-3 pr-4 text-base font-medium text-white uppercase transition rtl:border-r-4 ltr:border-l-4 hover:bg-gray-50 focus:outline-none focus:text-primary hover:text-primary'
const classes = computed(() => {
	return props.active
		? 'border-primary bg-transparent focus:bg-transparent' + '' + sharedClasses
		: 'border-transparent' + ' ' + sharedClasses
})
</script>

<template>
	<div>
		<button
			v-if="as == 'button'"
			:class="classes">
			<slot />
		</button>

		<Link
			v-else
			:href="href"
			class="flex items-center gap-2"
			:class="classes">
			<slot />
		</Link>
	</div>
</template>
