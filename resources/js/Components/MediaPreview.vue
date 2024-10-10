<script setup>
import { onMounted } from 'vue'
import {
	ArrowDownCircleIcon,
	DocumentArrowUpIcon,
} from '@heroicons/vue/24/outline'
const props = defineProps({
	fileType: String,
	filePreview: String,
	fileName: String,
})
</script>
<template>
	<img
		v-if="fileType.startsWith('image')"
		class="object-cover object-center w-full h-32 rounded-lg"
		:src="filePreview" />
	<div
		v-else-if="fileType.startsWith('video')"
		class="object-cover overflow-hidden rounded-lg aspect-video">
		<video
			:src="filePreview"
			class="w-full h-full"></video>
	</div>

	<div
		v-else-if="
			fileType.endsWith('.document') ||
			fileType.startsWith('application/msword')
		"
		class="">
		<img
			class="object-contain w-5 mx-auto h-7"
			src="/images/doc.png" />
		<p class="truncate">{{ fileName }}</p>
	</div>
	<div
		v-else-if="fileType.startsWith('application/pdf')"
		class="">
		<img
			class="object-contain mx-auto w-7 h-7"
			src="/images/pdf.png" />
		<p class="break-words truncate">{{ fileName }}</p>
	</div>
</template>
