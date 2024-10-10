<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import Avatar from './Avatar.vue'
import FavouriteButton from './FavouriteButton.vue'
import Modal from './Modal.vue'

const emit = defineEmits(['close', 'delete'])

defineProps({
	show: {
		type: Boolean,
		default: false,
	},
	maxWidth: {
		type: String,
		default: 'xs',
	},
	closeable: {
		type: Boolean,
		default: true,
	},
	users: {
		require: true,
		type: null,
	},
})

const close = () => {
	emit('close')
}

const currentUser = usePage().props.auth.user
</script>

<template>
	<Modal
		:show="show"
		:max-width="'xs'"
		:closeable="closeable"
		@close="close"
		:showCloseIcon="true">
		<div class="flex justify-center shadow-sm">
			<h2 class="flex gap-1 text-lg font-bold text-primary">
				<span>{{ users?.length }}</span>
				<span class="capitalize transition-all duration-150">
					{{ users?.length <= 1 ? $t('like') : $t('likes') }}
				</span>
			</h2>
		</div>
		<div
			class="min-h-[400px] max-h-[500px] p-4 pt-0 overflow-y-auto hideScrollBar">
			<template
				v-for="user in users"
				:key="user.id">
				<div class="flex items-center w-full gap-2 p-2 text-stone-800">
					<div>
						<Avatar
							:id="user.id"
							:username="user.name"
							:image-url="user.avatar_url"
							:size="'md'"
							:border="true"
							border-color="primary" />
					</div>
					<div class="flex flex-col">
						<Link
							:href="route('player.profile', user.id)"
							class="flex flex-row gap-2">
							<h3 class="m-0 font-bold leading-none capitalize">
								{{ user.name }}
							</h3>
						</Link>
						<Link
							:href="route('player.profile', user.id)"
							class="text-xs text-stone-400"
							>@{{ user.username }}
						</Link>
					</div>
					<!--                    <div v-if="currentUser.id !== user.id" class="mis-auto">-->
					<!--                        <FavouriteButton :user="user" />-->
					<!--                    </div>-->
				</div>
			</template>
		</div>
	</Modal>
</template>
