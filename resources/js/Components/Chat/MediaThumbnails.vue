<template>
    <div :class="isCurrentUser ? 'text-white' : 'text-stone-800'" class="rounded-md overflow-hidden w-28 aspect-square">
        <template v-if="media?.mime_type.startsWith('image')">
            <img class="object-cover w-full h-full" :src="media?.original_url" alt="">
        </template>
        <template v-else-if="media?.mime_type.startsWith('video')">
            <video controls class="w-full h-full object-cover">
                <source :src="media.original_url" :type="media.mime_type">
            </video>
        </template>
    </div>
</template>

<script setup>
import { ArrowDownCircleIcon } from '@heroicons/vue/24/outline'
defineProps(['media', 'isCurrentUser'])

</script>

<style lang="scss" scoped></style>
