<script setup lang="ts">
import {
	EllipsisHorizontalIcon,
	StarIcon,
	TrashIcon,
} from '@heroicons/vue/24/outline'
type Model = Team
const props = defineProps<{
	team: Prettify<Model>
}>()
</script>
<template>
	<section class="flex flex-col items-center gap-1 card">
		<button class="self-end bg-black text-white p-0.5 rounded-full">
			<StarIcon class="w-5 h-5" />
		</button>
		<Avatar
			:id="team.id"
			:image-url="team.image"
			:size="'xlg'"
			:username="team.name"
			:enableLightBox="true" />
		<Link
			:href="route('teams.show', [team])"
			class="text-sm font-semibold text-black capitalize"
			>{{ team.name }}</Link
		>
		<StarRating
			show-rating-value
			:model-value="4"
			disabled />
		<p class="text-xs font-medium text-primary">
			{{ $tChoice('count-player-or-count-players', team.users.length) }}
		</p>
		<div class="self-end space-x-2 rtl:space-x-reverse">
			<button>
				<TrashIcon class="w-5 h-5" />
			</button>
			<button>
				<EllipsisHorizontalIcon class="w-5 h-5" />
			</button>
		</div>
	</section>
</template>
