<script setup>
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/solid'
import { onMounted, ref } from 'vue'

defineProps({
	modelValue: String,
	placeholder: String,
})

defineEmits(['update:modelValue'])

const input = ref(null)

const type = ref('password')

onMounted(() => {
	if (input.value.hasAttribute('autofocus')) {
		input.value.focus()
	}
})

defineExpose({ focus: () => input.value.focus() })
</script>

<template>
	<div class="relative mt-1 rounded-md">
		<input
			ref="input"
			:type="type"
			:value="modelValue"
			:placeholder="placeholder"
			class="block w-full px-4 text-xs border-gray-300 rounded-full shadow-sm removeEyeIcon focus:border-primary focus:ring-primary sm:text-sm disabled:bg-gray-100 form-input"
			@input="$emit('update:modelValue', $event.target.value)"
			autocomplete="new-password"
			aria-required="true" />
		<div
			class="absolute inset-y-0 flex items-center cursor-pointer ltr:right-0 rtl:left-0 ltr:pr-3 rtl:pl-3">
			<EyeSlashIcon
				v-if="type == 'text'"
				@click="type = 'password'"
				class="w-5 h-5 text-gray-400" />
			<EyeIcon
				v-if="type == 'password'"
				@click="type = 'text'"
				class="w-5 h-5 text-gray-400" />
		</div>
	</div>
</template>

<style></style>
