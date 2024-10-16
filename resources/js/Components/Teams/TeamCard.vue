<script setup lang='ts'>
import { EllipsisHorizontalCircleIcon, EllipsisHorizontalIcon, StarIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { EllipsisVerticalIcon } from '@heroicons/vue/24/solid';

const props = defineProps<{
    team:Team,
}>()
</script>
<template>
<section class="flex flex-col items-center gap-1 p-4 bg-white rounded shadow">
    <button class="self-end bg-black text-white p-0.5 rounded-full">
        <StarIcon class="w-5 h-5"/>
    </button>
    <Avatar
    :image-url="team.image"
    :size="'xlg'"
    :username="team.name"
    :enableLightBox="true" />
    <h2 class="text-sm font-semibold capitalize">{{team.name}}</h2>
    <StarRating show-rating-value :model-value="4" disabled />
    <p class="text-xs font-medium text-primary">{{ $tChoice('count-player-or-count-players',team.users.length) }}</p>
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
