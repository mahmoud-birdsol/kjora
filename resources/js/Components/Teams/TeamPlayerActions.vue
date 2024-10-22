<script setup lang="ts">
import { ChatBubbleBottomCenterTextIcon } from '@heroicons/vue/24/outline'

const props = defineProps<{
	player: User
}>()
</script>
<template>
	<div class="flex gap-3">
		<Button
			icon="i-heroicons-chat-bubble-bottom-center-text"
			size="icon"
			variant="ghost"
			color="white"
			:arial-label="$t('open-chat')" />
		<DropdownMenu>
			<DropdownMenuTrigger />
			<DropdownMenuContent>
				<DropdownMenuItem label="detach player" />
			</DropdownMenuContent>
		</DropdownMenu>
	</div>
</template>
