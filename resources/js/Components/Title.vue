<template>
	<div class="flex justify-center">
		<h2
			class="text-xl font-bold uppercase"
			:class="state !== 'Premium' ? 'text-primary' : 'text-golden'">
			<slot />
		</h2>
	</div>
</template>
<script setup>
import { usePage } from '@inertiajs/vue3'

const state = usePage().props?.auth?.user?.state_name
</script>

<style></style>
