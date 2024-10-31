<script setup lang="ts">
import { ref, watch } from 'vue'
import FadeInTransition from '@/Components/FadeInTransition.vue'
import Avatar from '@/Components/Avatar.vue'
import ReportModal from '@/Components/ReportModal.vue'
import { useChat } from '@/stores/chat'
import {
	FlagIcon,
	MagnifyingGlassIcon,
	XMarkIcon,
} from '@heroicons/vue/24/outline'
import TextInput from '../TextInput.vue'
import { Link } from '@inertiajs/vue3'
import DateTranslation from '../DateTranslation.vue'
import { useDebounceFn } from '@vueuse/core'

const props = defineProps({
	conversation: {
		required: true,
		type: Object,
	},
	player: {
		required: true,
		type: Object,
	},
})

const chat = useChat()
const showSearchForm = ref(false)

function handleExitSearch() {
	showSearchForm.value = false
	chat.search = ''
	chat.messages = []
	chat.fetchMessages()
}

const searchMessagesDebounced = useDebounceFn(chat.searchMessages, 500)
watch(
	() => chat.search,
	() => {
		searchMessagesDebounced()
	}
)
</script>

<template>
	<FadeInTransition>
		<div
			v-if="showSearchForm"
			class="w-full">
			<div class="flex items-center justify-between gap-4 p-4">
				<div class="grow">
					<TextInput
						type="search"
						v-model="chat.search"
						:placeholder="$t('Search')" />
				</div>
				<div class="flex-none">
					<button
						@click="handleExitSearch"
						class="p-1 rounded-full group hover:ring-primary hover:ring">
						<XMarkIcon class="w-5 text-black group-hover:text-primary" />
					</button>
				</div>
			</div>
		</div>
		<div
			class="flex w-full"
			v-else>
			<div
				class="flex items-center flex-1 gap-4 p-4 ltr:border-r ltr:border-r-stone-400 rtl:border-l rtl:border-l-stone-400">
				<Avatar
					:image-url="player.avatar_url"
					:id="player.id"
					:username="player.name"
					size="md"
					:border="true"
					border-color="primary" />

				<div class="flex flex-col">
					<Link
						class="mb-1 font-bold leading-none capitalize text-primary"
						:href="route('player.profile', player.id)">
						{{ player.name }}
					</Link>
					<Link
						class="text-xs leading-none text-neutral-500"
						:href="route('player.profile', player.id)">
						@{{ player.username }}
					</Link>
					<div class="text-xs mt-1">
						<DateTranslation
							:end="player.last_seen_at"
							type="period" />
					</div>
				</div>
			</div>
			<div class="flex items-center gap-4 p-4">
				<button @click="showSearchForm = true">
					<MagnifyingGlassIcon
						class="w-5 h-5 cursor-pointer text-primary hover:text-primaryDark" />
				</button>
				<ReportModal
					:reportable-id="conversation.id"
					:reportable-type="'App\\Models\\Conversation'">
					<template #trigger>
						<button>
							<FlagIcon class="h-5 w-5 text-red-500 mt-0.5" />
						</button>
					</template>
				</ReportModal>
			</div>
		</div>
	</FadeInTransition>
</template>
