<script setup>
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
	title: String,
})
const state = usePage().props?.auth?.user?.state_name
</script>

<template>
	<div class="min-h-[500px] flex flex-col gap-4">
		<div v-if="props.title">
			<div class="flex justify-center my-4">
				<h2
					class="text-xl font-bold uppercase"
					:class="state !== 'Premium' ? 'text-primary' : 'text-golden'">
					{{ props.title }}
				</h2>
			</div>
		</div>
		<div class="mx-2 text-black md:mx-8">
			<slot name="body"></slot>
		</div>
		<div
			class="my-4 md:mx-8"
			v-if="$slots.footer">
			<slot name="footer"></slot>
		</div>
	</div>
</template>
