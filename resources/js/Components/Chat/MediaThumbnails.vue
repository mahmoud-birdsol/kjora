<template>
    <div :class="isCurrentUser ? 'text-white' : 'text-stone-800'" class="w-full overflow-hidden rounded-md aspect-square">
        <template v-if="media?.mime_type.startsWith('image')">
            <img class="object-cover w-full h-full" :src="media?.original_url" alt="">
        </template>
        <template v-else-if="media?.mime_type.startsWith('video')">
            <video :src="media.original_url" class="object-cover w-full h-full">
            </video>
        </template>
    </div>
</template>

<script setup>

defineProps(['media', 'isCurrentUser'])

</script>

<style lang="scss" scoped></style>
