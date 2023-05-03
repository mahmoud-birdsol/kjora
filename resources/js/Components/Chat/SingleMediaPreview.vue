<template>
    <div :class="isCurrentUser ? 'text-white' : 'text-stone-800'" class="w-full h-full overflow-hidden rounded-md">
        <div @click="$emit('showGallery')" v-if="media?.mime_type.startsWith('image')">
            <img class="object-contain max-w-full w-52" :src="media?.original_url" alt="">
        </div>
        <div @click="$emit('showGallery')" v-else-if="media?.mime_type.startsWith('video')">
            <video :src="media.original_url" controls class="object-contain w-full h-full max-w-full">
            </video>
        </div>
        <div v-else-if="media?.mime_type.endsWith('.document') || media?.mime_type.startsWith('application/msword') || media?.mime_type.startsWith('application/pdf')"
            class="flex items-center justify-between gap-2">
            <div class="flex gap-1 ">
                <img v-if="media?.mime_type.endsWith('.document') || media?.mime_type.startsWith('application/msword')"
                    class="object-contain w-7 h-7" src="/images/doc.png" />
                <img v-if="media?.mime_type.startsWith('application/pdf')" class="object-contain w-7 h-7"
                    src="/images/pdf.png" />
                <p class="truncate  text-start max-w-[15ch] ">{{ media.file_name }}</p>
            </div>
            <a :href="media.original_url" :download="media.file_name">
                <ArrowDownCircleIcon class="w-10 h-10 cursor-pointer" />
            </a>
        </div>
    </div>
</template>
<script setup>
import { ArrowDownCircleIcon } from '@heroicons/vue/24/outline'
defineProps(['media', 'isCurrentUser'])
defineEmits(["showGallery"])
</script>
<style lang="scss" scoped></style>