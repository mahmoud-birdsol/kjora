<script setup>
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import HelloUserHeader from '@/Components/HelloUserHeader.vue'
import PerformanceTab from '@/Components/PerformanceTab.vue'
import ProfileGallery from '@/Components/ProfileGallery.vue'
import MainPlayerCard from '@/Components/PlayerCards/MainPlayerCard.vue'
import { computed, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import FadeInTransition from '../../Components/FadeInTransition.vue'

const props = defineProps({
	user: null,
	posts: Array,
	playerRating: Array,
	countries: Array,
	positions: Array,
	tabId: {
		default: 2,
		type: Number,
	},
})

const currentTabId = ref(props.tabId)

const tabs = computed(() => {
	return [
		{
			name: 'performance',
			id: 1,
			component: PerformanceTab,
			compProps: { playerRating: props.playerRating },
		},
		{
			name: 'gallery',
			id: 2,
			component: ProfileGallery,
			compProps: { user: props.user, posts: props.posts },
		},
	]
})

function reloadMedia() {
	router.reload({ only: ['posts'] })
}
</script>

<template>
	<Head :title="$t('home')" />

	<AppLayout :title="$t('home')">
		<template #header>
			<HelloUserHeader />
		</template>

		<div class="py-12">
			<div class="flex flex-col max-w-5xl mx-auto gap-y-6 sm:px-6 lg:px-8">
				<MainPlayerCard
					:player="user"
					size="lg"
					:show-report="false"
					:showFavorite="false" />
				<div class="flex justify-center p-2 bg-white rounded-full gap-x-3">
					<template
						v-for="(tab, index) in tabs"
						:key="index">
						<button
							@click="currentTabId = tab.id"
							:data-tab="tab.name"
							class="text-sm font-semibold uppercase transition-colors duration-150 ease-in hover:text-stone-600"
							:class="
								tab.id === currentTabId ? 'text-stone-800' : 'text-stone-400'
							">
							{{ $t(tab.name) }}
						</button>
					</template>
				</div>
				<div class="min-h-[350px] md:min-h-[550px]">
					<FadeInTransition>
						<template
							v-for="(tab, index) in tabs"
							:key="index">
							<div v-if="tab.id === currentTabId">
								<component
									v-bind="tab.compProps"
									:is="tab.component"
									@reload="reloadMedia"></component>
							</div>
						</template>
					</FadeInTransition>
				</div>
			</div>
		</div>
	</AppLayout>
</template>
