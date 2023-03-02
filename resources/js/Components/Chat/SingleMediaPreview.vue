<template>
    <div :class="isCurrentUser ? 'text-white' : 'text-stone-800'" class="rounded-md overflow-hidden w-full h-full">
        <div @click="$emit('showGallery')" v-if="media?.mime_type.startsWith('image')">
            <img class="object-contain w-52 max-w-full" :src="media?.original_url" alt="">
        </div>
        <div @click="$emit('showGallery')" v-else-if="media?.mime_type.startsWith('video')">
            <video controls class="w-full h-full object-contain  max-w-full">
                <source :src="media.original_url" :type="media.mime_type">
            </video>
        </div>
        <div v-else-if="media?.mime_type.endsWith('.document') || media?.mime_type.startsWith('application/msword') || media?.mime_type.startsWith('application/pdf')"
            class="flex  gap-2 items-center justify-between">
            <div class="flex gap-1 ">
                <img v-if="media?.mime_type.endsWith('.document') || media?.mime_type.startsWith('application/msword')"
                    class="w-7 h-7 object-contain" src="/images/doc.png" />
                <img v-if="media?.mime_type.startsWith('application/pdf')" class="w-7 h-7 object-contain"
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