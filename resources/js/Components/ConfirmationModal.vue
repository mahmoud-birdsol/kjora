<script setup>
import Modal from './Modal.vue'

const emit = defineEmits(['close', 'delete'])

defineProps({
	show: {
		type: Boolean,
		default: false,
	},
	maxWidth: {
		type: String,
		default: 'sm',
	},
	closeable: {
		type: Boolean,
		default: true,
	},
})

const close = () => {
	emit('close')
}
</script>

<template>
	<Modal
		:show="show"
		:max-width="'sm'"
		:closeable="closeable"
		@close="close"
		:showCloseIcon="false">
		<div class="flex flex-col justify-center gap-6 p-6 text-stone-800">
			<p class="font-bold text-center text-md">
				<slot name="body" />
			</p>
			<div class="flex justify-center w-full gap-4">
				<button
					class="p-2 px-8 font-bold text-white uppercase bg-black border-2 border-black rounded-full hover:bg-transparent hover:text-black active:scale-95"
					@click="emit('close')">
					{{ $t('Cancel') }}
				</button>
				<button
					class="p-2 px-8 font-bold text-white uppercase bg-black border-2 border-black rounded-full hover:bg-transparent hover:text-black active:scale-95"
					@click="emit('delete')">
					{{ $t('delete') }}
				</button>
			</div>
		</div>
	</Modal>
</template>
