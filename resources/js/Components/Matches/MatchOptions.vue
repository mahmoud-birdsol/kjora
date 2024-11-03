<script setup lang="ts">
const showModal = ref<boolean>(false)
</script>
<template>
	<Button
		:label="$t('create-match')"
		color="primary"
		@click="showModal = true" />
	<Modal
		maxWidth="md"
		:show="showModal"
		@close="showModal = false">
		<div class="p-6 pt-0 space-y-6">
			<header class="text-center">
				<h2 class="text-2xl font-semibold text-black">
					{{ $t('create-match') }}
				</h2>
				<p class="text-sm text-gray-500">
					{{
						$t(
							'please-select-what-you-want-to-create-team-match-or-friendly-match'
						)
					}}
				</p>
			</header>
			<div class="space-y-2">
				<Button
					block
					:href="route('match.create', { type: 'team' })"
					:label="$t('team-match')" />
				<Button
					block
					variant="outline"
					:href="route('match.create', { type: 'individual' })"
					:label="$t('individual-match')" />
			</div>
		</div>
	</Modal>
</template>
