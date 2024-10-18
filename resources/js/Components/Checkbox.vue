<script setup>
import { computed } from 'vue'

const emit = defineEmits(['update:checked'])

const props = defineProps({
	checked: {
		type: [Array, Boolean],
		default: false,
	},
	value: {
		type: String,
		default: null,
	},
})

const proxyChecked = computed({
	get() {
		return props.checked
	},

	set(val) {
		emit('update:checked', val)
	},
})
</script>

<template>
	<input
		v-model="proxyChecked"
		type="checkbox"
		:value="value"
		class="mx-1 text-indigo-600 border-gray-300 rounded-full shadow-sm form-checkbox focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
</template>
