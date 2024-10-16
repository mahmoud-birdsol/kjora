<script setup>
import { XMarkIcon } from '@heroicons/vue/24/solid'
</script>

<template>
	<p class="text-xs text-gray-900 font-light">
		<span class="inline">
			<XMarkIcon class="h-5 w-5 text-red-500 inline" />
		</span>

		<slot />
	</p>
</template>
