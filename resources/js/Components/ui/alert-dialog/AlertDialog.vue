<script setup lang="ts">
const props = defineProps<{
	title: string
	description: string
	onClickSolid: Function
	onClickOutline: Function
	solidLabel: string
	outlineLabel: string
}>()
const showModal = defineModel('open')
const closeModal = (params) => {
	showModal.value = false
}
const clickSolid = (params) => {
	props.onClickSolid?.()
	closeModal()
}
const clickOutline = (params) => {
	props.onClickOutline?.()
	closeModal()
}
</script>
<template>
	<Modal
		maxWidth="md"
		:show="showModal"
		@close="showModal = false">
		<div class="p-6 pt-0 space-y-6">
			<header class="text-center">
				<h2 class="text-2xl font-semibold text-black">
					{{ title }}
				</h2>
				<p class="text-sm text-gray-500">
					{{ description }}
				</p>
			</header>
			<div class="space-y-2">
				<Button
					block
					:label="solidLabel"
					@click="clickSolid" />
				<Button
					block
					variant="outline"
					@click="clickOutline"
					:label="outlineLabel" />
			</div>
		</div>
	</Modal>
</template>
