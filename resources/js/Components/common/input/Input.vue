<script setup lang="ts">
import { onMounted, ref } from 'vue'
import type { InputProps } from '.'

const props = defineProps<InputProps>()

const modelValue = defineModel<string | number>()

const input = ref<HTMLInputElement>()

onMounted(() => {
	if (input.value && input.value.hasAttribute('autofocus')) {
		input.value?.focus()
	}
})

defineExpose({ focus: () => (input.value ? input.value.focus() : null) })
</script>

<template>
	<div
		:class="
			cn(
				'relative flex grow items-center overflow-hidden shadow-sm rounded-full transition-colors duration-300 selection:bg-secondary-200 selection:text-primary form-input',
				'border border-gray-300  has-[input:focus:not([readonly])]:border-secondary has-[input[aria-invalid=true]]:border-red-500',
				'bg-white  has-[input[disabled]]:bg-gray-200 has-[input[readonly]]:bg-gray-100 ',
				'has-[input[disabled]]:text-gray-500 has-[input[readonly]]:text-gray-500 ',
				'[--icon-padding:theme(spacing.2)]',
				'has-[input:focus:not([readonly])]:border-primary',
				props.class
			)
		">
		<span
			v-if="$slots.leading"
			:class="
				cn(
					'absolute inset-y-0 start-0 flex h-full w-[--icon-width] items-center justify-center px-[--icon-padding]',
					leadingIconWrapperClass
				)
			">
			<slot name="leading"> </slot>
		</span>
		<input
			ref="input"
			class="px-4 text-xs sm:text-sm grow focus-visible:outline-none readonly:cursor-not-allowed disabled:cursor-not-allowed"
			:type="type"
			v-model="modelValue"
			disabled
			readonly
			autocomplete
			:placeholder />

		<span
			v-if="$slots.trailing"
			:class="
				cn(
					'absolute inset-y-0 start-0 flex h-full w-[--icon-width] items-center justify-center px-[--icon-padding]',
					trailingIconWrapperClass
				)
			">
			<slot name="trailing"> </slot>
		</span>
	</div>
</template>
