<script setup lang="ts">
const props = withDefaults(
	defineProps<{
		message?: string
		description?: string

		ui?: {
			message?: string
			description?: string
			image?: string
		}
	}>(),
	{}
)
</script>

<template>
	<div class="flex flex-col items-center gap-1 text-center">
		<slot name="content">
			<slot name="image">
				<img
					:class="cn('w-28 object-contain text-secondary-200', ui?.image)"
					src="/images/no-data.webp" />
			</slot>
			<slot name="message">
				<span
					class="text-xl font-medium text-gray-500 first-letter:capitalize"
					:class="cn('', ui?.message)"
					v-text="props.message ?? $t('no-data')" />
			</slot>
			<slot name="description">
				<span
					class="text-xs text-gray-400 first-letter:capitalize"
					:class="cn('', ui?.description)"
					v-text="
						description ?? $t('there-is-no-data-to-show-you-right-now')
					" />
			</slot>
			<slot v-if="$slots.default" />
		</slot>
	</div>
</template>

<style></style>
